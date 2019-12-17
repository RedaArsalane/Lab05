<?php
require_once 'database.php';

$userId = null;

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {

    $studentId = $_GET['user_id'];

} else {

    header("Location: index.php");
    die();
}

$pdo = Database::connect();

$sql = "SELECT country_id FROM user WHERE id = :country_id";
$q = $pdo->prepare($sql);
$q->bindParam(":user_id", $userId);
$q->execute();
$groupId = $q->fetchColumn();

Database::disconnect();

if (!empty($_POST)) {

    $NameError = null;
    $emailError = null;
    $Name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $valid = true;

    
    if (empty($Name)) {

        $NameError = 'write name';
        $valid = false;
    }

    if (empty($email)) {

        $emailError = 'write email';
        $valid = false;
    }

    if ($valid) {

        $pdo = Database::connect();

        $sql = "UPDATE user  SET name = :name, email = :name WHERE id = :user_id";
        $q = $pdo->prepare($sql);
        $q->bindParam(':name', $Name);
        $q->bindParam(':email', $email);
        $q->bindParam(':user_id', $userId);
        $q->execute();

        Database::disconnect();
        header("Location: user.php?country_id=$countryId");
    }

} else {

    
    $pdo = Database::connect();

    $sql = "SELECT * FROM user WHERE id = :user_id";
    $q = $pdo->prepare($sql);
    $q->bindParam(':user_id', $userId);
    $q->execute();
    $data = $q->fetch(PDO::FETCH_ASSOC);

    Database::disconnect();

    if(empty($data)) {

        header("Location: index.php");

    } else {

        $firstName = $data['name'];
        $lastName = $data['email'];
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
            <h3>update user </h3>
        </div>

        <form action="update_student.php?student_id=<?php echo $studentId ?>" method="post">

            <div class="control-group <?php echo !empty($NameError) ? 'error' : ''; ?>">
                <label class="control-label">name</label>
                <div class="controls">
                    <input name="name" type="text" placeholder="write name ..."
                           value="<?php echo !empty($firstName) ? htmlspecialchars($Name) : ''; ?>">
                    <?php if (!empty($NameError)): ?>
                        <span class="help-inline"><?php echo $NameError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                <label class="control-label">email</label>
                <div class="controls">
                    <input name="email" type="text" placeholder="write email..."
                           value="<?php echo !empty($email) ? htmlspecialchars($email) : ''; ?>">
                    <?php if (!empty($emailError)): ?>
                        <span class="help-inline"><?php echo $emailError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="">
                <button type="submit" class="btn btn-success">update</button>
                <a class="btn" href="students.php?group_id=<?php echo $groupId ?>">return</a>
            </div>
        </form>

    </div>
</div>
</body>
</html>
