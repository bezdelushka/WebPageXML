<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $xmlFile = 'data.xml';
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
            if ($xml === false) {
                die("Error: Failed to load XML file.");
            }

            $username = $_SESSION["username"];
            $target_file = $_FILES["image"]["tmp_name"];
            $image_data = base64_encode(file_get_contents($target_file));
            $image_filename = basename($_FILES["image"]["name"]);

            $user_found = false;
            foreach ($xml->user as $user) {
                if ((string)$user->name == $username) {
                    if (!isset($user->images)) {
                        $user->addChild('images');
                    }
                    $image = $user->images->addChild('image');
                    $image->addChild('filename', htmlspecialchars($image_filename));
                    $image->addChild('data', htmlspecialchars($image_data));
                    $user_found = true;
                    break;
                }
            }

            if ($user_found) {
                $xml->asXML($xmlFile);
            } else {
                die("Error: User not found in XML.");
            }
        } else {
            die("Error: The XML file does not exist.");
        }
    }
    header("Location: index.php");
    exit;
}
?>
