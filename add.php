<?php
require_once('pdo.php');
session_start();
if (! isset($_SESSION['email'])) {
  die('ACCESS DENIED');
}
if (isset($_POST['cancel']) ) {header("Location: index.php");
 return;
}


if (isset($_POST['make']) &&isset($_POST['model']) &&  isset($_POST['year']) && isset($_POST['mileage'])) {
    if (empty($_POST['make'])){
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }elseif (empty($_POST['model'])){
        $_SESSION['error']='All fields are required';
    
        header("Location: add.php");
        return;
    }
    elseif (is_numeric($_POST['year']) === true && is_numeric($_POST['mileage']) === true) {
        $sql = 'INSERT INTO autos (make,model ,year, mileage) VALUES (:make,:model,:year,:mileage)';
        $addingmake = $pdo->prepare($sql);
        $addingmake->execute(
            array(
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage']
            )
        );
        $_SESSION['success'] = 'Record added';
        header("Location: index.php");
    } else {
        $_SESSION['error'] = 'Year must be an integer';
        header("Location: add.php");
        return;
    }

} else {
}
?>


<html>

<head>
    <title>Youssef Mohamed Yahia Elkondakly</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
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
        <h1>Tracking Autos for <?=$_SESSION['email']?>
        </h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
       
        ?>
        <form method="post">
            <p>Make:
                <input type="text" name="make" size="60" />
            </p>
            <p>Model:
                <input type="text" name="model" size="60" />
            </p>
            <p>Year:
                <input type="text" name="year" />
            </p>
            <p>Mileage:
                <input type="text" name="mileage" />
            </p>
            <input type="submit" value="Add">
         <input type="submit" name="cancel" value="Cancel">
        </form> 
          
        </ul>
    </div>
</body>

</html>