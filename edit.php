<?php
include('config.php');
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $role=$_POST['role'];
    $id=$_POST['editid'];

    $sql="UPDATE `users` SET `role`=:role WHERE ID =:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':role',$role);
    $stmt->bindParam(':id',$id);

    try{
        $stmt->execute();
        header('location:users.php?updaterole=sucses update Role');
    }
    catch(PDOException $e)
    {
        echo "Error".$e->getMessage();
    }
   
}


?>