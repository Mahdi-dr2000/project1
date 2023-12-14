<!DOCTYPE html>
<html>

<head>
    <title>Image Upload Form</title>
    <link rel="stylesheet" href="../admin.css">
</head>

<body>
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen'></i>
            <span class="logo navLogo"><a href="#">CodingLab</a></span>

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="#">CodingLab</a></span>
                    <i class='bx bx-x siderbarClose'></i>
                </div>

                <ul class="nav-links">
                    <li><a href="../user.php">Home</a></li>
                    <li><a href="../image/image.php">image manage</a></li>

                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun'></i>
                </div>



            </div>
        </div>
        </div>

    </nav>

    <h2>Upload an Image</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

        <br><br><br>
        <input type="file" name="image" accept="image/*">
        <br><br>
        <input type="submit" value="Upload">
    </form>
    <?php if (isset($_GET['res'])) {
        echo $_GET['res'];
    }
    ?>
</body>

</html>

<?php



session_start();
if ($_SESSION['login'] == true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include('../config.php');
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imgename = $_FILES['image']['name'];
            $imagesize = $_FILES['image']['size'];
            $imagepath = $_FILES['image']['tmp_name'];
            $format = explode('.', $imgename);
            $imageallow = ['jpg', 'png', 'jpeg'];
            $file_extension = strtolower(end($format));
            $types = array_search($file_extension, $imageallow);

            if ($types === false) {
                echo "File format not allowed";
            } elseif ($imagesize > 100000000) {
                echo "File size is too big";
            } else {
                $newpath = '../images/' . $imgename;
                if (!file_exists('../images/')) {
                    mkdir('../images/', 0777, true);
                }
                if (move_uploaded_file($imagepath, $newpath)) {
                    $id = $_SESSION['id'];
                    $sql = 'INSERT INTO upload(id_user,imagepath) VALUES (:id,:imagename)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':imagename', $imgename);
                    try {
                        $stmt->execute();
                        //echo "Upload Image Success";
                        //header('Refresh:2');
                        header('location:image.php?res=Upload Image Success');
                        exit();
                    } catch (PDOException $e) {
                        echo "Error" . $e->getMessage();
                    }
                }
            }
        }
    }
}


?>