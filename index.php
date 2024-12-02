<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Favorite Pets - ログイン</title>
  <style>
    body {
      font-family: "Hiragino Kaku Gothic ProN", "メイリオ", sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-image: linear-gradient(135deg, #f5f7fa 0%, #e4e8ff 100%);
    }

    .login-container {
      background-color: white;
      padding: 2.5rem;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .logo {
      margin-bottom: 1.5rem;
    }

    .logo img {
      width: 80px;
      height: 80px;
    }

    h1 {
      color: #2c3e50;
      margin-bottom: 0.5rem;
      font-size: 1.8rem;
    }

    .subtitle {
      color: #666;
      margin-bottom: 2rem;
      font-size: 1rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: #2c3e50;
      font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 0.8rem;
      border: 2px solid #e1e8f0;
      border-radius: 8px;
      box-sizing: border-box;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #4a90e2;
      outline: none;
    }

    input[type="submit"] {
      width: 100%;
      padding: 1rem;
      background-color: #4a90e2;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1.1rem;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #357abd;
    }

    .welcome-message {
      color: #666;
      margin-top: 1.5rem;
      font-size: 0.9rem;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="logo">
      <img src="images/pet-logo.png" alt="My Favorite Pets" onerror="this.src='data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22%234a90e2%22%20d%3D%22M12%2C8L10.67%2C8.09C9.81%2C7.07%207.4%2C4.5%205%2C4.5C5%2C4.5%203.03%2C7.46%204.96%2C11.41C4.41%2C12.24%204.07%2C12.67%204%2C13.66L2.07%2C13.95L2.28%2C14.93L4.04%2C14.67L4.18%2C15.38L2.61%2C16.32L3.08%2C17.21L4.53%2C16.32C5.68%2C18.76%208.59%2C20%2012%2C20C15.41%2C20%2018.32%2C18.76%2019.47%2C16.32L20.92%2C17.21L21.39%2C16.32L19.82%2C15.38L19.96%2C14.67L21.72%2C14.93L21.93%2C13.95L20%2C13.66C19.93%2C12.67%2019.59%2C12.24%2019.04%2C11.41C20.97%2C7.46%2019%2C4.5%2019%2C4.5C16.6%2C4.5%2014.19%2C7.07%2013.33%2C8.09L12%2C8Z%22%2F%3E%3C%2Fsvg%3E';">
    </div>
    <h1>My Favorite Pets</h1>
    <p class="subtitle">お気に入りのペットを見つけよう！</p>
    <form method="post" action="index_act.php">
      <div class="form-group">
        <label for="lid">メールアドレス</label>
        <input type="text" name="lid" id="lid" required placeholder="example@mail.com">
      </div>
      <div class="form-group">
        <label for="lpw">パスワード</label>
        <input type="password" name="lpw" id="lpw" required placeholder="パスワードを入力">
      </div>
      <input type="submit" value="ログイン">
    </form>
    <p class="welcome-message">素敵なペットとの出会いをお楽しみください</p>
  </div>
</body>

</html>