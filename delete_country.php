<?php

require_once 'database.php';

$id = 0;

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];

} elseif(isset($_POST['id']) && !empty($_POST['id'])) {

    $id = $_POST['id'];

} else {

    header("Location: index.php");
    die();
}

if (!empty($_POST)) {

    $pdo = Database::connect();

    $sql = "DELETE FROM country  WHERE id = :id";
    $q = $pdo->prepare($sql);
    $q->bindParam(':id', $id);
    $q->execute();

    Database::disconnect();
    header("Location: index.php");

} else {

    $pdo = Database::connect();

    $sql = "SELECT title FROM country WHERE id = :id";
    $q = $pdo->prepare($sql);
    $q->bindParam(":id", $id);
    $q->execute();
    $groupTitle = $q->fetchColumn();

    
    if(empty($countryTitle)) {

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
	<script type="text/javascript" src="js/script.js"></script>

</head>

<body>
<div class="container">

    <div>
        <div class="row">
            <h3>Delete user <?php echo htmlspecialchars($countrtTitle) ?></h3>
        </div>

        <form class="form-horizontal" action="delete_country.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <p class="alert alert-error">You want to delete this user ?</p>
            <div class="">
                <button type="submit" class="btn btn-danger">Yes</button>
                <a class="btn" href="index.php">No</a>
            </div>
        </form>
    </div>

</div>
</body>
</html>