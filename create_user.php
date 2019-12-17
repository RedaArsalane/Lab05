<?php
require_once 'database.php';

$countryId = null;

if (isset($_GET['country_id']) && !empty($_GET['country_id'])) {

    $countryId = $_GET['country_id'];

} else {

    header("Location: index.php");
    die();
}

if (!empty($_POST)) {

    $NameError = null;
    $EmailError = null;
    $Name = trim($_POST['name']);
    $Email = trim($_POST['email']);
    $valid = true;

    // Validate
    if (empty($firstName)) {
        $NameError = "please add country";
        $valid = false;
    }

    if (empty($lastName)) {
        $emailError = "please add email";
        $valid = false;
    }

    // Save data
    if ($valid) {

        $pdo = Database::connect();

        $sql = "INSERT INTO student (name, email, country_id) VALUES(:name, :email, :country_id)";
        $q = $pdo->prepare($sql);
        $q->bindParam(":name", $Name);
        $q->bindParam(":email", $email);
        $q->bindParam(":country_id", $country_Id);
        $q->execute();

        Database::disconnect();

        header("Location: country.php?country_id=$countryId");
    }
} else {

    $pdo = Database::connect();

    $sql = "SELECT title FROM country WHERE id = :country_id";
    $q = $pdo->prepare($sql);
    $q->bindParam(":country_id", $countryId);
    $q->execute();
    $groupName = $q->fetchColumn();

    // If no group with set id
    if(empty($groupName)) {

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
            <h3>Add users to  <?php echo htmlspecialchars($groupName)  ?></h3>
        </div>

        <form action="create_user.php?country_id=<?php echo $groupId ?>" method="post">

            <div class="control-group <?php echo !empty($firstNameError) ? 'error' : ''; ?>">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input name="first_name" type="text" placeholder="Add name ..."
                           value="<?php echo !empty($firstName) ? htmlspecialchars($Name) : ''; ?>">
                    <?php if (!empty($NameError)): ?>
                        <span class="help-inline"><?php echo $NameError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                <label class="control-label">Email</label>
                <div class="controls">
                    <input name="email" type="text" placeholder="Add email..."
                           value="<?php echo !empty($email) ? htmlspecialchars($email) : ''; ?>">
                    <?php if (!empty($email)): ?>
                        <span class="help-inline"><?php echo $emailError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-success">Add</button>
                <a class="btn" href="user.php?country_id=<?php echo $countryId ?>">Return</a>
            </div>
        </form>

    </div>

</div>
</body>
</html>
