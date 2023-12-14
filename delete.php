<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $employee_id = $_POST['delteids'];
   // echo $employee_id;

    $sql = "DELETE FROM `users` WHERE `ID` = :employee_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);

    try {
        $stmt->execute();
        $deletedRows = $stmt->rowCount();

        if ($deletedRows > 0) {
            header('Location: users.php');
            exit();
        } else {
            echo "No employee found with ID: $employee_id";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
