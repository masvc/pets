<?php
session_start();
include("funcs.php");
sschk();

//DB接続
$pdo = db_conn();

//ユーザー一覧を取得
$sql = "SELECT * FROM users WHERE life_flg=1";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        $view .= '<td>' . h($row["name"]) . '</td>';
        $view .= '<td>' . h($row["lid"]) . '</td>';
        $view .= '<td>' . ($row["kanrisya_flg"] ? "管理者" : "一般") . '</td>';
        $view .= '<td>';
        $view .= '<a href="user_edit.php?id=' . h($row["id"]) . '">編集</a>';
        $view .= ' | ';
        $view .= '<a href="user_delete.php?id=' . h($row["id"]) . '">削除</a>';
        $view .= '</td>';
        $view .= '</tr>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー一覧</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>ユーザー一覧</h1>
    <a href="user_add.php">新規ユーザー登録</a>
    <table>
        <tr>
            <th>名前</th>
            <th>ログインID</th>
            <th>権限</th>
            <th>操作</th>
        </tr>
        <?= $view ?>
    </table>
</body>

</html>