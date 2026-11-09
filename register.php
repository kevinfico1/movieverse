<?php
require_once __DIR__ . '/config/database.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Planarcadia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style/base.css">
    <link rel="stylesheet" href="style/login_and_register/login.css">
</head>
<body class="auth-body">

    <main class="auth-wrapper">
        <div class="auth-container">
            <h2 class="auth-title">Register</h2>
            
            <form action="" method="POST">

                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                
                <button type="submit" class="btn-auth">Register</button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </main>

    <script src="script/script.js"></script>
</body>
</html>