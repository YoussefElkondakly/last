<?php
require_once("pdo.php");
session_start();
if (! isset($_SESSION['email'])){
    die('ACCESS DENIED');
}

if (isset($_POST['make'])   &&
    isset($_POST['model'])  && 
    isset($_POST['year'])   && 
    isset($_POST['mileage'])&&
    isset($_POST['auto_id'])
    ) {
    if (empty($_POST['make'])){
        $_SESSION['error'] = 'Make is required';
        header("Location: edit.php?auto_id=".$_REQUEST['auto_id']);
        return;
    }elseif (empty($_POST['model'])){
        $_SESSION['error'] = 'Model is required';
        header("Location: edit.php?auto_id=".$_REQUEST['auto_id']);
        return;
    }
    elseif (is_numeric($_POST['year']) === true && is_numeric($_POST['mileage']) === true) {
        $sql="UPDATE autos SET make=:make, model=:model , year=:year ,mileage=:mileage WHERE auto_id=:auto_id";
        $editingmake = $pdo->prepare($sql);
        $editingmake->execute(
            array(
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage'],
                ':auto_id'=>$_POST['auto_id']
            )
        );
        $_SESSION['success'] = 'Record edited';
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = 'Year must be an integer';
        header("Location: edit.php?auto_id=".$_REQUEST['auto_id']);
        return;
    }

} else {
    
}
    $autodata=$pdo->prepare("SELECT * FROM autos where auto_id= :id");
    $autodata->execute(array(":id"=>$_GET['auto_id']));
    $row=$autodata->fetch(PDO::FETCH_ASSOC);
    if($row===false){
        $_SESSION['error']='invalid Auto id given '.$_GET['auto_id'];
        header("Location: index.php");
    return;
    }else{
        $make=$row['make'];
        $model=$row['model'];
        $year=$row['year'];
        $mileage=$row['mileage'];
        $id=$row['auto_id'];
    } 
    //
            
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
<body>


    <p> Update Make</p>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p class="error">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p class="success">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }
    ?>
    <form method="post">
        <input type="hidden" name="auto_id" value="<?=$id?>">
        <p>make: <input type="text" name="make" value="<?=$make?>"></p>
        <p>model: <input type="text" name="model" value="<?=$model?>"></p>
        <p>year: <input type="text" name="year" value="<?=$year?>"></p>
        <p>mileage: <input type="text" name="mileage" value="<?=$mileage?>"></p>
        <p><input type="submit" value="Save" >
    <a href="index.php">Back</a>
    </p>
    </form>

</body>

</html>