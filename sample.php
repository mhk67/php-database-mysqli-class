<?php
include "database.php";
$db=new database();
$db->connect('localhost','root' ,'' ,'nlpfarsi' );

$query="INSERT INTO `table_name` 
                    (`f1`,`f2`)
                    VALUE
                    ('hi','hello')";
$result=$db->query($query);


//////////////////////////////////////
$query="SELECT * FROM `table_name` LIMIT 1";
$result=$db->query($query);
echo $db->num_rows($result);


?>