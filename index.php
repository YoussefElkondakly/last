<?php
require_once("pdo.php");
session_start();
if (!isset($_SESSION['email'])) {
    die('ACCESS DENIED');
}
?>

<html>

<head>
    <title>Youssef Mohamed Yahia Elkondakly</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
        integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<style>
    .error {
        color: red;
    }

    .success {
        color: yellowgreen;
    }
</style>

<body>
    <div class="container">
        <h1>Tracking Autos for
            <?= $_SESSION['email'] ?>
        </h1>
        <?php
        if (isset($_SESSION['success'])) {
            echo '<p class="success">' . htmlentities($_SESSION['success']) . "</p>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . htmlentities($_SESSION['error']) . "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <h2>Automobiles</h2>
<?php
$viewautos = $pdo->query("SELECT * FROM autos");
if (($viewautos->fetch(PDO::FETCH_ASSOC))=== false) {
    echo '<p class="error">No rows found</p>';
} 
else {
    print('<table border="1">
    <tr>
        <td style="font-weight: bold;">Make</td>
        <td style="font-weight: bold;">Model</td>
        <td style="font-weight: bold;">Year</td>
        <td style="font-weight: bold;">Mileage</td>
        <td style="font-weight: bold;">Action</td>
        <td>');
    while ($row = $viewautos->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>";
        echo (htmlentities($row['make']));
        echo "</td><td>";
        echo (htmlentities($row['model']));
        echo "</td><td>";
        echo ($row['year']);
        echo "</td><td>";
        echo ($row['mileage']);
        echo "</td><td>";
        echo ('<a href="edit.php?auto_id=' . $row['auto_id'] . '">Edit </a> /');
        echo ('<a href="delete.php?auto_id=' . $row['auto_id'] . '"> Delete</a>');
        echo "</td></tr>";

    }
}
echo "\n";
echo"  </table>";
?>
<br>
        <p>
            <a href="add.php">Add New Entry</a>
        </p>
        <p>
            <a href="logout.php">Logout</a>
        </p>
    </div>
</body>

</html>