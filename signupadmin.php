<?php
include('config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $fname = $_POST['familyname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $birthdate = $_POST['birthdate'];
    $fullname = $firstname . ' ' . $mname . ' ' . $lname . ' ' . $fname;
    $role = 'user';



    $sql = "SELECT  `Email` FROM `users` where `Email`=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);

    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            header('location:users.php?res=The user already exsists');
        } else {
            $sql = "INSERT INTO `users`(`Name`, `Email`, `password`, `date created`, `date last login`, `role`) VALUES (:fullname,:email,:password,now(),now(),:role)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);

            try {
                $stmt->execute();
                header('location:users.php?ressucsses=register sucses');
                exit();
            } catch (PDOException $e) {
                echo "Error " . $e->getMessage();
                echo "<br> SQL Query: " . $sql;
            }
        }
    } catch (PDOException $e) {
        echo  $e->getMessage();
    }
} else {
    header('location:admin.php');
}
