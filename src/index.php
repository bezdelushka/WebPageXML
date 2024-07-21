<?php
session_start();

// Load user images
$xmlFile = 'data.xml';
if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    if ($xml === false) {
        die("Error: Failed to load XML file.");
    }
} else {
    die("Error: The XML file does not exist.");
}

$user_images = [];

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    if (isset($xml->user)) {
        foreach ($xml->user as $user) {
            if ((string)$user->name == $username) {
                if (isset($user->images->image)) {
                    foreach ($user->images->image as $image) {
                        $user_images[] = [
                            'filename' => (string)$image->filename,
                            'data' => (string)$image->data
                        ];
                    }
                }
                break;
            }
        }
    } else {
        echo "No users found in XML.";
    }
}

// Extract MathML and SVG
$mathml = $xml->math->asXML();
$svg = $xml->svg->asXML();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: LemonChiffon;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">PRJ XML</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if (!isset($_SESSION["username"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="datalist.php">User Data</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>PRJ 4 XML</h1>
        <?php if (isset($_SESSION["username"])): ?>
            <p> <?php echo htmlspecialchars($_SESSION["username"]); ?>, ești logat</p>
            <h2>Imaginile tale:</h2>
            <div class="row">
                <?php if (!empty($user_images)): ?>
                    <?php foreach ($user_images as $image): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($image['data']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($image['filename']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($image['filename']); ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p> Nu există imagini</p>
                <?php endif; ?>
            </div>
            <form method="post" enctype="multipart/form-data" action="save.php" class="mt-4">
                <div class="mb-3">
                    <label for="image" class="form-label">Selectati Imaginea</label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Încărcați Imaginea</button>
            </form>

           
            <div class="center">
                <p><?php echo $mathml; ?></p>
            </div>

           
            <div class="center">
                <?php echo $svg; ?>
            </div>

        <?php else: ?>
            <p>Please <a href="login.php">login</a> or <a href="signup.php">sign up</a> to continue.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
