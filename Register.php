<?php
require 'actions/register_action.php'; 

$errors = ['register' => $_SESSION['register_error'] ?? ''];
$success = ['register_success' => $_SESSION['register_success'] ?? ''];


function showError($error) {
    return !empty($error) ? "<p class='errorMessage'>$error</p>" : '';
}

function showSuccess($success) {
    return !empty($success) ? "<p class='successfulMessage'>$success</p>" : '';
}
unset($_SESSION['register_error']);
unset($_SESSION['register_success']);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="form-box" id="Register-form">
            <form action="" method="post">
                <h2>Register</h2>
                <?php echo showError($errors['register']); ?>
                <?php echo showSuccess($success['register_success']); ?>
                <input type="text" name="name" placeholder="name" required> 
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="Register">Register</button>
                <p>Already have an account? <a href="Login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
