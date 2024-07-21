<?php

$xmlFile = 'data.xml';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];

    if ($password !== $password_confirm) {
        die("Passwords do not match.");
    }


    $pass_hash = password_hash($password, PASSWORD_DEFAULT);


    $xml = simplexml_load_file($xmlFile);


    $user = $xml->addChild('user');
    $user->addChild('id', uniqid()); 
    $user->addChild('name', htmlspecialchars($name)); 
    $user->addChild('email', htmlspecialchars($email)); 
    $user->addChild('pass_hash', $pass_hash);

    
    $xml->asXML($xmlFile);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
<div class="form" id="form-signup">
    <form action="signup.php" method="post" novalidate>
        <div>
            <label for="name"> Nume:</label>
            <input type="text" id="name" name="name" class="form-input">
        </div>
        <div>
            <label for="email"> Email: </label>
            <input type="email" id="email" name="email" class="form-input">
        </div>
        <div>
            <label for="password"> Parola:</label>
            <input type="password" id="password" name="password" class="form-input">
        </div>
        <div>
            <label for="password_confirmation"> Confirmati: </label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-input">
        </div>
        <div class="g-recaptcha" data-sitekey="6Ld-Lr0pAAAAADxjRgR9NpxmDeGXYYnhD2EIEJn-"></div>
        <div>
            <input type="submit" value="Sign up">
        </div>
    </form>
</div>

</body>
</html>
