<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続
function db_conn()
{
    try {
        $db_name = "pets";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "";      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト
        return new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}

//SQLエラー
function sql_error($stmt)
{
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQLError:" . $error[2]);
}

//リダイレクト
function redirect($file_name)
{
    header("Location: " . $file_name);
    exit();
}

//SessionCheck
function sschk()
{
    if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
        exit("Login Error");
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}

//管理者権限チェック
function admin_chk()
{
    if (!isset($_SESSION["kanrisya_flg"]) || $_SESSION["kanrisya_flg"] != 1) {
        exit("権限がありません");
    }
}

// ファイルアップロードチェックと処理
function handle_file_upload($file, $upload_dir = "images/")
{
    $upload_name = basename($file['name']);
    $upload_path = $upload_dir . $upload_name;

    // ファイルの拡張子チェック
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    $file_ext = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        exit('許可されていないファイル形式です');
    }

    // ファイルアップロード
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        exit('ファイルのアップロードに失敗しました');
    }

    return $upload_name;
}

// JSONレスポンス送信
function send_json_response($success, $error = null)
{
    header('Content-Type: application/json');
    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $error]);
    }
}

// パスワードのハッシュ化
function hash_password($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// データベーストランザクション処理
function db_transaction($pdo, $callback)
{
    try {
        $pdo->beginTransaction();
        $result = $callback($pdo);
        $pdo->commit();
        return $result;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

// ログイン認証処理
function login_check($lid, $lpw)
{
    $pdo = db_conn();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE lid = :lid AND life_flg = 1");
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $status = $stmt->execute();

    if ($status) {
        $val = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($val && password_verify($lpw, $val['lpw'])) {
            $_SESSION["chk_ssid"] = session_id();
            $_SESSION["kanrisya_flg"] = $val['kanrisya_flg'];
            $_SESSION["name"] = $val['name'];
            $_SESSION["id"] = $val['id'];
            return true;
        }
    }
    return false;
}

// ログアウト処理
function logout()
{
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
}

// フォーム入力値の取得と検証
function get_form_data($key, $filter = FILTER_DEFAULT)
{
    return filter_input(INPUT_POST, $key, $filter);
}

// 画像表示用のHTML生成
function generate_animal_card($result)
{
    $html = '<div class="animal-card">';
    $html .= '<img src="images/' . h($result['imgfile']) . '" alt="' . h($result['name']) . '">';
    $html .= '<h3>' . h($result['name']) . '</h3>';
    $html .= '<p>登録日: ' . h(substr($result['indate'], 0, 10)) . '</p>';
    $html .= '<button onclick="addToFavorites(' . h($result['id']) . ')" class="favorite-btn">お気に入りに追加</button>';
    if ($_SESSION["kanrisya_flg"] == 1) {
        $html .= '<button onclick="deleteAnimal(' . h($result['id']) . ')" class="delete-btn">削除</button>';
    }
    $html .= '</div>';
    return $html;
}

// ユーザーリスト表示用のHTML生成
function generate_user_row($row)
{
    $html = '<tr>';
    $html .= '<td>' . h($row["name"]) . '</td>';
    $html .= '<td>' . h($row["lid"]) . '</td>';
    $html .= '<td>' . ($row["kanrisya_flg"] ? "管理者" : "一般") . '</td>';
    $html .= '<td>';
    $html .= '<a href="user_edit.php?id=' . h($row["id"]) . '">編集</a>';
    $html .= ' | ';
    $html .= '<a href="user_delete.php?id=' . h($row["id"]) . '">削除</a>';
    $html .= '</td>';
    $html .= '</tr>';
    return $html;
}

// データベースからユーザー情報を取得
function get_user_by_id($id)
{
    $pdo = db_conn();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status == false) {
        sql_error($stmt);
    }
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 共通のヘッダーHTML生成
function generate_header($title)
{
    $html = '<!DOCTYPE html>';
    $html .= '<html lang="ja">';
    $html .= '<head>';
    $html .= '<meta charset="UTF-8">';
    $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . h($title) . '</title>';
    return $html;
}

// 共通のスタイルシート
function get_common_style()
{
    return '
        <style>
            form {
                max-width: 400px;
                margin: 20px auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
            }
            .form-group {
                margin-bottom: 15px;
            }
            label {
                display: block;
                margin-bottom: 5px;
            }
            input[type="text"],
            input[type="password"],
            input[type="email"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            button, .btn {
                background-color: #008CBA;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .back-link {
                display: block;
                margin-top: 20px;
                text-align: center;
            }
        </style>
    ';
}
