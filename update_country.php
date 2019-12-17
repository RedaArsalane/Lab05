<?php
require_once 'database.php';

$id = null;

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];

} else {

    header("Location: index.php");
    die();
}

if (!empty($_POST)) {

    $titleError = null;
    $title = trim($_POST['title']);

    
    $valid = true;
    if (empty($title)) {

        $titleError = 'write country';
        $valid = false;
    }

    if ($valid) {

        $pdo = Database::connect();

        $sql = "UPDATE country SET title = :title WHERE id = :id";
        $q = $pdo->prepare($sql);
        $q->bindParam(':title', $title);
        $q->bindParam(':id', $id);
        $q->execute();

        Database::disconnect();
        header("Location: index.php");
    }

} else {

    $pdo = Database::connect();

    $sql = "SELECT * FROM country WHERE id = :id";
    $q = $pdo->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $title = $data['title'];

    if(empty($title)) {

        header("Location: index.php");
    }

    Database::disconnect();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/bootstrap.js"></script>
</head>

<body>
<div class="container">

    <div>
        <div class="row">
            <h3>update informations</h3>
        </div>

        <form action="update_country.php?id=<?php echo $id ?>" method="post">

            <div class="control-group <?php echo !empty($titleError) ? 'error' : ''; ?>">
                <label class="control-label">country</label>
                <div class="controls">
                    <input name="title" type="text" placeholder="write country..."
                           value="<?php echo !empty($title) ? htmlspecialchars($title) : ''; ?>">
                    <?php if (!empty($titleError)): ?>
                        <span class="help-inline"><?php echo $titleError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="">
                <button type="submit" class="btn btn-success">update</button>
                <a class="btn" href="index.php">Return</a>
            </div>
        </form>

    </div>

</div>
</body>
</html>
