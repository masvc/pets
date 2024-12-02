<?php
session_start();
include("funcs.php");
sschk();
admin_chk();

// 管理者チェック
if ($_SESSION["kanrisya_flg"] != 1) {
    exit("権限がありません");
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>動物登録</title>
    <style>
        form {
            max-width: 500px;
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
        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .preview {
            max-width: 200px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include("includes/header.php"); ?>
    <form method="POST" action="animal_insert.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">動物の名前：</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label for="imgfile">画像：</label>
            <input type="file" name="imgfile" accept="image/*" required onchange="previewImage(this)">
            <img id="preview" class="preview" style="display:none;">
        </div>
        <input type="submit" value="登録">
    </form>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>