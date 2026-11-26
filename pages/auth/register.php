<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit;
}

$errors      = [];
$email       = "";
$email_salah = false;
$pass_salah  = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $pass  = isset($_POST['password']) ? $_POST['password'] : "";

    if ($email == "") {
        $errors[] = "Email belum diisi";
        $email_salah = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
        $email_salah = true;
    }

    if ($pass == "") {
        $errors[] = "Password belum diisi";
        $pass_salah = true;
    } elseif (strlen($pass) < 6) {
        $errors[] = "Password minimal 6 karakter";
        $pass_salah = true;
    }

    if (count($errors) == 0) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors[] = "Email sudah terdaftar";
            $email_salah = true;
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
            $stmt->execute([$email, $hash]);

            header('Location: login.php?daftar=berhasil');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Planarcadia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../style/base.css">
    <link rel="stylesheet" href="../../style/login_and_register/login.css">
</head>
<body class="auth-body">

    <main class="auth-wrapper">
        <div class="auth-container">
            <h2 class="auth-title">Register</h2>

            <?php if (count($errors) > 0) { ?>
                <div class="auth-alert error">
                    <ul>
                        <?php foreach ($errors as $err) { ?>
                            <li><?php echo htmlspecialchars($err); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <form action="" method="POST" novalidate>

                <div class="input-group <?php if ($email_salah) { echo 'error'; } ?>">
                    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <div class="input-group <?php if ($pass_salah) { echo 'error'; } ?>">
                    <input type="password" name="password" placeholder="Password">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <button type="submit" class="btn-auth">Register</button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
        </div>
    </main>

    <script src="../../script/script.js"></script>
</body>
</html>