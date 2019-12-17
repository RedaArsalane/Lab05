<?php

require_once 'database.php';

$countryId = 0;

if (isset($_GET['country_id']) && !empty($_GET['country_id'])) {

    $studentId = $_GET['country_id'];

} elseif (isset($_POST['country_id']) && !empty($_POST['country_id'])) {

    $studentId = $_POST['country_id'];

} else {

    header("Location: index.php");
    die();
}

$pdo = Database::connect();

$sql = "SELECT country FROM student WHERE id = :country_id";
$q = $pdo->prepare($sql);
$q->bindParam(":country_id", $countryId);
$q->execute();
$groupId = $q->fetchColumn();

Database::disconnect();

if (!empty($_POST)) {

    $pdo = Database::connect();

    
    $sql = "DELETE FROM country  WHERE id = :id";
    $q = $pdo->prepare($sql);
    $q->bindParam(':id', $studentId);
    $q->execute();

    Database::disconnect();
    header("Location: country.php?country_id=$countryId");

} else {

    $pdo = Database::connect();

    
    $sql = "SELECT name, email FROM user WHERE id = :country_id";
    $q = $pdo->prepare($sql);
    $q->bindParam(':country_id', $countryId);
    $q->execute();
    $studentData = $q->fetch(PDO::FETCH_ASSOC);

    Database::disconnect();

    if(empty($userData)) {

        header("Location: index.php");

    } else {

        $Name = $userData['name'];
        $email = $userData['email'];
    }
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
            <h3>delete  <?php echo '"' . htmlspecialchars($Name) . ' ' . htmlspecialchars($email) . '"' ?></h3>
        </div>

        <form class="form-horizontal" action="delete_student.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $countryId; ?>"/>
            <p class="alert alert-error">you want to delete ?</p>
            <div class="">
                <button type="submit" class="btn btn-danger">Yes</button>
                <a class="btn" href="students.php?group_id=<?php echo $groupId ?>">No</a>
            </div>
        </form>
    </div>

</div>
</body>
</html>