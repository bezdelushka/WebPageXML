<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $xml = simplexml_load_file('data.xml');

    $user = authenticateUser($xml, $_POST["email"], $_POST["password"]);

    if ($user !== false) {
        $_SESSION["username"] = (string)$user->name;
        header("Location: index.php");
        exit;
    } else {
        die("Email sau parolă greșită.");
    }
}

function authenticateUser($xml, $email, $password) {
    foreach ($xml->user as $user) {
        if ((string)$user->email === $email && password_verify($password, (string)$user->pass_hash)) {
            return $user;
        }
    }
    return false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form" id="form-login">
        <form action="login.php" method="post" novalidate>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-input">
            </div>
            <div>
                <label for="password">Parolă:</label>
                <input type="password" id="password" name="password" class="form-input">
            </div>
            <div>
                <label for="remember_me">
                    <input type="checkbox" name="remember_me" id="remember_me" value="checked"> Remember me
                </label>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
