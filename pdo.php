<?php

try{$pdo=new PDO('mysql:host=127.0.0.1;port=3306;dbname=misc','fred' ,'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}
catch(Exception $ex){
    echo 'Do Not Forget to save it in log file::   '.$ex;
}
?>


