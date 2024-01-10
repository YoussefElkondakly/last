<?php
require_once('pdo.php');
session_start();
if (isset($_POST['email']) && isset($_POST['pass'])) {
    unset($_SESSION['account']);
    if ($_POST['email'] == '' || $_POST['pass'] == '') {
        $_SESSION['error'] = 'User name and password are required';
        header('Location: login.php');
        return;
    } elseif (str_contains($_POST['email'], '@') === false) {
        $_SESSION['error'] = 'Email must have an at-sign (@)';
        header('Location: login.php');
        return;
    } else {
        $sql = "SELECT name FROM users 
    WHERE  email=:email
    AND password=:pass";

        $data = $pdo->prepare($sql);

        $data->execute(
            array(
                ':email' => $_POST['email'],
                ':pass' => $_POST['pass']
            )
        );
        $result = $data->fetch(PDO::FETCH_ASSOC);
        $pass = hash('md5', 'XyZzy12*_' . $_POST['pass']);

        if ($result === false) {
            echo '<h1 class="error">Incorrect password</h1>';
            error_log("Login fail " . $_POST['email']);
            $_SESSION['error'] = "Incorrect password";
            header('Location: login.php');
            return;
        } else {
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["success"] = "Logged in.";
            error_log("Login success " . $_POST['email'] . '    ' . $pass);

            header('Location: index.php');
            return;
        }
    }
}
?>
<html>

<head>
    <title>Youssef Mohamed Yahia Elkondakly</title>
</head>
<style>
    .error {
        color: red;
    }

    .success {
        color: yellowgreen;
    }
</style>

<body style="font-family: sans-serif;">
    <b style="font-size: xx-large;">Please Login</b>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p class="error">' . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p class="success">' . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    ?>
    <form method="post">
        User Name <input type="text" name="email"><br />
        Password <input type="text" name="pass"><br />
        <p>
        <input type="submit" value="Log In">
        <a href="dashboard.php">Cancel</a>
        </p>
    </form>
</body>

</html>