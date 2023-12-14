<?php
include('config.php');
// session_start();
// if ($_SESSION['login'] == true && $_SESSION['role'] == 'admin') {
//     //echo "welcome " . $_SESSION['email'];
// } else {
//     header('location:user.php');
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap CRUD Data Table for Database with Modal Form</title>
    <link rel="stylesheet" href="users.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>

    </style>

</head>

<body>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Employees</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>date created</th>
                            <th>date last login</th>
                            <th>role</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        session_start();
                        if ($_SESSION['login'] == true && $_SESSION['role'] == 'admin') {
                            //echo "welcome " . $_SESSION['email'];
                        } else {
                            header('location:user.php');
                        }

                        $user = $_SESSION['id'];
                        $query = $pdo->prepare("SELECT * FROM users WHERE ID !=:user");
                        $query->bindParam(':user', $user);
                        $query->execute();
                        $users = $query->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($users as $user) {
                        ?>
                            <tr>
                                <td>
                                    <!-- Your checkbox code here -->
                                </td>

                                <td><?php echo $user['Name'];
                                    ?></td>
                                <td><?php echo $user['Email'];
                                    ?></td>
                                <td><?php echo $user['date created'];
                                    ?></td>
                                <td><?php echo $user['date last login'];
                                    ?></td>
                                <td><?php echo $user['role'];
                                    ?></td>
                                <td>
                                    <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                    <a href="#deleteEmployeeModal" class="deleteButton" id="del" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                    <input type="hidden" class="userid" value="<?php echo $user['ID']; ?>">
                                    <input type="hidden" class="role" value="<?php echo $user['role']; ?>">

                                </td>
                            </tr>
                        <?php }
                        ?>



                        <?php if (isset($_GET['res']) && !isset($_SESSION['alert_shown'])) {
                            $_SESSION['alert_shown'] = true;
                        ?>
                            <div id="myalert" class="alert alert-danger" role="alert">
                                <?php echo $_GET['res']; ?>
                            </div>
                            <script>
                                setTimeout(function() {
                                    document.getElementById('myalert').style.display = 'none';
                                }, 5000);
                            </script>
                        <?php
                        } elseif (!isset($_GET['res']) && isset($_SESSION['alert_shown'])) {
                            unset($_SESSION['alert_shown']);
                        }


                        ?>


                        <?php if (isset($_GET['ressucsses']) && !isset($_SESSION['alert_sucsses'])) {
                            $_SESSION['alert_sucsses'] = true;
                        ?>
                            <div id="alertsucses" class="alert alert-warning" role="alert">
                                <?php echo $_GET['ressucsses']; ?>
                            </div>
                            <script>
                                setTimeout(function() {
                                    document.getElementById('alertsucses').style.display = 'none';
                                }, 5000);
                            </script>
                        <?php
                        } elseif (!isset($_GET['ressucsses']) && isset($_SESSION['alert_sucsses'])) {
                            unset($_SESSION['alert_sucsses']);
                        }


                        ?>


                        <?php if (isset($_GET['updaterole']) && !isset($_SESSION['update_role'])) {
                            $_SESSION['update_role'] = true;
                        ?>
                            <div id="updaterole" class="alert alert-warning" role="alert">
                                <?php echo $_GET['updaterole']; ?>
                            </div>
                            <script>
                                setTimeout(function() {
                                    document.getElementById('updaterole').style.display = 'none';
                                }, 5000);
                            </script>
                        <?php
                        } elseif (!isset($_GET['updaterole']) && isset($_SESSION['update_role'])) {
                            unset($_SESSION['update_role']);
                        }


                        ?>






                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <!-- ADD Modal HTML -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="signupadmin.php" id="signup">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" required>
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="mname" id="mname" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname" required>
                        </div>
                        <div class="form-group">
                            <label>Family Name</label>
                            <input type="text" class="form-control" name="familyname" id="familyname" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                            <div id="emailmassage"></div>

                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            <div id="passwordmassage"></div>

                        </div>

                        <div class="form-group">
                            <label>Repassword</label>
                            <input type="password" class="form-control" name="repassword" id="repassword" required>
                            <div id="repasswordmassage"></div>

                        </div>


                        <input type="date" id="birthdate" name="birthdate" required />
                        <div id="dobMessage"></div>

                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="edit.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">

                            <select id="role" name="role" class="form-control">
                            </select>
                            <input type="hidden" id="editid" name="editid" value="" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Delete Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="delete.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Record?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <input type="hidden" name="delteids" id="deleteid">

                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>


<script>
    //get id and send to delete form
    var deleteButtons = document.querySelectorAll('.deleteButton');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var userIdInput = this.parentNode.querySelector('.userid');
            if (userIdInput) {
                var id = userIdInput.value;
                console.log(id);

                var deleteIdInput = document.getElementById('deleteid');
                if (deleteIdInput) {
                    deleteIdInput.value = id;
                }
            }
        });
    });
</script>

<script>
    // get id and send to edit form
    var edit = document.querySelectorAll('.edit');
    edit.forEach(function(button) {
        button.addEventListener('click', function() {
            var userIdInput = this.parentNode.querySelector('.userid');
            if (userIdInput) {
                var id = userIdInput.value;
                var deleteIdInput = document.getElementById('editid');
                if (deleteIdInput) {
                    deleteIdInput.value = id;
                }
            }
        });
    });
</script>

<script>
    //get role from input hidden and view inside edit form 
    var editButtons = document.querySelectorAll('.edit');
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var roleInput = this.parentNode.querySelector('.role');
            if (roleInput) {
                var roleValue = roleInput.value;
                var roleSelect = document.getElementById('role');
                if (roleSelect) {
                    roleSelect.innerHTML = '';

                    var adminOption = document.createElement('option');
                    adminOption.value = 'admin';
                    adminOption.text = 'admin';
                    var userOption = document.createElement('option');
                    userOption.value = 'user';
                    userOption.text = 'user';
                    if (roleValue === 'admin') {
                        roleSelect.appendChild(adminOption);
                        roleSelect.appendChild(userOption);
                        adminOption.selected = true;
                    } else if (roleValue === 'user') {
                        roleSelect.appendChild(userOption);
                        roleSelect.appendChild(adminOption);
                        userOption.selected = true;
                    }
                }
            }
        });
    });
</script>

<script>
    document.getElementById("signup").addEventListener("submit", function(e) {
        e.preventDefault();
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var repassword = document.getElementById("repassword").value;
        var fname = document.getElementById("fname").value;
        var mname = document.getElementById("mname").value;
        var lname = document.getElementById("lname").value;
        var familyname = document.getElementById("familyname").value;

        document.getElementById("emailmassage").innerHTML = " ";
        document.getElementById("passwordmassage").innerHTML = " ";
        document.getElementById("repasswordmassage").innerHTML = " ";
        document.getElementById("dobMessage").innerHTML = " ";

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var passwordPattern =
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&^#])[A-Za-z\d@$!%*?&^#]{8,}$/;

        var nameFields = [fname, mname, lname, familyname];
        let valid = true;

        nameFields.forEach((field) => {
            if (field.trim() === "") {
                valid = false;
            }
        });

        if (!valid) {
            alert("Please enter text for all name sections.");
        }
        if (valid && !emailPattern.test(email)) {
            document.getElementById("emailmassage").innerHTML = "email not correct";
            valid = false;
        }

        if (valid && password !== repassword) {
            document.getElementById("repasswordmassage").innerHTML =
                "password and repassword not Confarimed";
            valid = false;
        } else {
            if (valid && password < 8) {
                document.getElementById("passwordmassage").innerHTML =
                    "The password should be at least 8 characters";
                valid = false;
            } else if (valid && !passwordPattern.test(password)) {
                document.getElementById("repasswordmassage").innerHTML =
                    "should cover password strength rules such as (upper case, lower case, numbers, special character, no spaces )";
                valid = false;
            }
        }
        if (valid) {
            var date = new Date();
            var birthdate = new Date(document.getElementById("birthdate").value);
            var age = date.getFullYear() - birthdate.getFullYear();
            if (age < 16) {
                document.getElementById("dobMessage").innerHTML =
                    "You must be over 16 years old";
                valid = false;
            }
        }
        if (valid == true) {
            this.submit();
        }
    });
</script>