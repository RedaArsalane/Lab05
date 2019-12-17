<?php
require_once 'database.php';

$groupId = null;

if (isset($_GET['country_id']) &&  !empty($_GET['country_id'])) {

    $groupId = $_GET['country_id'];

} else {

    header('Location: index.php');
    die();
}

if (!empty($_GET)) {

    $pdo = Database::connect();

    $sql = "SELECT title FROM country WHERE id = :country_id";
    $q = $pdo->prepare($sql);
    $q->bindParam(':country_id', $groupId);
    $q->execute();
    $groupName = $q->fetchColumn();

    
    if(empty($groupName)) {

        header("Location: index.php");
    }


    $sql = "SELECT * FROM users WHERE user_id = :country_id";
    $q = $pdo->prepare($sql);
    $q->bindParam(':country_id', $countryId);
    $q->execute();
    $students = $q->fetchAll(PDO::FETCH_ASSOC);

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
    <div class="row">
        <h3>users <?php echo htmlspecialchars($userName) ?></h3>
    </div>

    <div class="row">
        <p>
            <a href="create_user.php?country_id=<?php echo "$countryId" ?>" class="btn btn-success">add</a>
        </p>

        <?php if (empty($students)): ?>
            <br><h4>Add user</h4>
        <?php else: ?>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $counter = 1;
                foreach ($users as $user) {

                    echo '<tr>';
                    echo '<td>' . $counter . '</td>';
                    echo '<td> <a href="update_user.php?user_id=' . $user['id'] . '">' . htmlspecialchars($user['name']) . '</a></td>';
                    echo '<td> <a href="update_user.php?user_id=' . $user['id'] . '">' . htmlspecialchars($user['email']) . '</a></td>';
                    echo '<td> <a href="delete_user.php?user_id=' . $user['id'] . '"> Remove </a></td>';
                    echo '</tr>';
                    $counter++;
                }
                ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</div>
</body>

</html>
