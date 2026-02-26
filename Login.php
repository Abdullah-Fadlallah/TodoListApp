<?php
require 'actions/login_action.php'; //session_start();

$errors = ['login'=> $_SESSION['login_error'] ?? '',];

unset($_SESSION['login_error']);
function showError($error) {
    return !empty($error) ? "<p class='errorMessage'>$error</p>" : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="form-box" id="login-form">
            <form action="" method="post">
                <h2>Login</h2>
                <?php echo showError($errors['login']); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">login</button>
                <p>Don't have an account? <a href="Register.php">Register</a></p>
            </form>
        </div>
</body>
</html>