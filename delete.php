<?php
require_once("pdo.php");
session_start();
if (! isset($_SESSION['email'])){
    die('ACCESS DENIED');
}
if( isset($_POST['delete']) && isset($_POST['auto_id'])){
    $sql='DELETE FROM autos WHERE auto_id=:zip';
   
    $deleteauto=$pdo->prepare($sql);
    $deleteauto->execute(array(':zip'=>$_POST['auto_id']));
$_SESSION['success']='Record deleted';
header("Location: index.php");
return;

}

$auto=$pdo->prepare("SELECT * FROM autos where auto_id= :id");
$auto->execute(array(":id"=>$_GET['auto_id']));
$row=$auto->fetch(PDO::FETCH_ASSOC);
if($row===false){
    $_SESSION['error']='invalid Auto id';
    header("Location: index.php");
return;
}
?>
<html>
    <head>
<title>Youssef Mohamed Yahia Elkondakly</title>
    </head>
    <body>
        <h1>Confirm Delete for <?= htmlentities($row['make']) ?>with this model : <?= htmlentities($row['model']) ?> </h1>
        <form method="post">
            <input type="hidden" name="auto_id" value="<?=$row['auto_id']?>" >
           <p> <input type="submit" name="delete" value="Delete">
<a href="index.php">Cancel</a>
        </p>
        </form>
    </body>
</html>