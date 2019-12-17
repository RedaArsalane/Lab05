<?php
require_once 'database.php';

$pdo = Database::connect();

$sql = 'SELECT * FROM country ORDER BY id';
$q = $pdo->query($sql);
$groups = $q->fetchAll(PDO::FETCH_ASSOC);

Database::disconnect();
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
    <div class="row">
        <h3>Users </h3>
    </div>
    <div class="row">
        <p>
            <a href="create_country.php" class="btn btn-success">Add </a>
        </p>
        <?php if (empty($groups)): ?>
            <br><h4>add informations please !</h4>
        <?php else: ?>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Country</th>
                    <th>Number of country's users</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $counter = 1;
                foreach ($country as $row) {

                    $title = $row['title'];

                    $sql = "SELECT COUNT(*) FROM user WHERE country_id = :id";
                    $q = $pdo->prepare($sql);
                    $q->bindParam(':id', $row['id']);
                    $q->execute();
                    $amountOfc = $q->fetchColumn(0);
                    if (!$amountOfc) {

                        $amountOfc = '0';
                    }

                    echo '<tr>';
                    echo '<td>' . $counter . '</td>';
                    echo '<td> <a href="update_country.php?id=' . $row['id'] . '">' . htmlspecialchars($title) . '</a> </td>';
                    echo '<td><a href="country.php?country_id=' . $row['id'] . '">' . $amountOfc . '</a></td>';
                    echo '<td> <a href="delete_country.php?id=' . $row['id'] . '"> Remove </a> </td>';
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
