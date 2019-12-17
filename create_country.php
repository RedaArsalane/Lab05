<?php

require_once 'database.php';

if (!empty($_POST)) {

    $titleError = null;
    $title = trim($_POST['title']);
    $valid = true;

    // validate
    if (empty($title)) {

        $titleError = '';
        $valid = false;
    }

    // save data
    if ($valid) {

        $pdo = Database::connect();

        $sql = "INSERT INTO study_group (title) VALUES(:title)";
        $q = $pdo->prepare($sql);
        $q->bindParam(':title', $title);
        $q->execute();

        Database::disconnect();
        header("Location: index.php");
    }
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
            <h3>Add country</h3>
        </div>

        <form action="create_group.php" method="post">

            <div class="control-group <?php echo !empty($titleError) ? 'error' : ''; ?>">
                <label class="control-label">Country</label>
                <div class="controls">
                    <input name="title" type="text" placeholder="add country"
                           value="<?php echo !empty($title) ? htmlspecialchars($title) : ''; ?>">
                    <?php if (!empty($titleError)): ?>
                        <span class="help-inline"><?php echo $titleError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="">
                <button type="submit" class="btn btn-success">Add</button>
                <a class="btn" href="index.php">Return</a>
            </div>
        </form>

    </div>

</div>
</body>
</html>