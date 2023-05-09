<?php
session_start();

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register -Phone Book Application</title>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
    <div class="container">
        <?php

            if (isset($errors)) {
                foreach ($errors as $key => $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
        ?>
        <form method="POST" action="./backend/actions/regiter.php" enctype="multipart/form_data">
            <h1>Register</h1>

            <label for="name">Name</label>
            <input type="text" name="name" required>

            <label for="email">Email</label>
            <input type="email" name="email">

            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" style="margin-bottom: 10px;" name="profile_picture" accept="image/*" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Register</button>

            <p>Already have an account?<a href="login.php">Login Here</a></p>
        </form>
    </div>
    <script type="text/javascript" src="scripts/scripts.js"></script>
</body>
</html>