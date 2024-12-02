<?php
if (!isset($page_title)) {
    $page_title = "My Favorite Pets";
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($page_title) ?></title>
    <style>
        /* 共通スタイル */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #333;
            color: white;
            padding: 1rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
        }

        .nav-links a:hover {
            background: #444;
            border-radius: 4px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .user-info {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <h1><?= h($page_title) ?></h1>
            <nav class="nav-links">
                <a href="main.php">ホーム</a>
                <a href="favorite.php">お気に入り</a>
                <?php if (isset($_SESSION["kanrisya_flg"]) && $_SESSION["kanrisya_flg"] == 1): ?>
                    <a href="animal_add.php">動物登録</a>
                    <a href="user_list.php">ユーザー管理</a>
                <?php endif; ?>
                <a href="logout.php">ログアウト</a>
            </nav>
        </div>
    </header>
    <div class="container">
        <?php if (isset($_SESSION["name"])): ?>
            <div class="user-info">
                ログインユーザー: <?= h($_SESSION["name"]) ?>
                <?php if ($_SESSION["kanrisya_flg"] == 1): ?>
                    （管理者）
                <?php endif; ?>
            </div>
        <?php endif; ?>