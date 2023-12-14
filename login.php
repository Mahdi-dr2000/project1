<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `users` WHERE email=:email ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);

    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $hashedPasswordFromDB = $result['password'];
            if ($hashedPasswordFromDB === md5($password)) {
                $sql = 'UPDATE `users` SET `date last login`=now() WHERE Email=:email';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $role = $result['role'];

                $_SESSION['login'] = true;
                $_SESSION['email'] = $result['Email'];
                $_SESSION['id'] = $result['ID'];

                if ($role === 'admin') {
                    $_SESSION['role'] = 'admin';
                    header("location:admin.php");
                    exit();
                } else if ($role === 'user') {
                    $_SESSION['role'] = 'user';
                    header('location:user.php');
                    exit();
                }
            } else {
                header('location:loginandsignup.php?log=Email or Password Not Correct');
                exit();
            }
        } else {
            header('location:loginandsignup.php?log=Email or Password Not Correct');
            exit();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header('location:index.php');
    exit();
}
