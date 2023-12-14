<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Login & Registration Form | CoderGirl</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <?php if (isset($_GET['res'])) {
    echo $_GET['res'];
  }
  ?>
  <div class="container">
    <input type="checkbox" id="check" />
    <div class="login form">
      <header>Login</header>
      <form method="post" action="login.php">

        <input type="email" placeholder="Enter your email" required name="email" />
        <input type="password" placeholder="Enter your password" required name="password" />
        <?php if (isset($_GET['log'])) {
          echo $_GET['log'];
        }
        ?>
        <input type="submit" class="button" value="Login" />

      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
          <label for="check">Signup</label>
        </span>
      </div>
    </div>
    <div class="registration form">
      <header>Signup</header>
      <form method="post" action="signup.php" id="signup">

        <input type="text" id="fname" name="fname" required placeholder="First Name" />

        <input type="text" id="mname" name="mname" placeholder="Middle Name" />

        <input type="text" id="lname" name="lname" required placeholder="Last Name" />

        <input type="text" id="familyname" name="familyname" required placeholder="Family Name" />

        <input type="text" placeholder="Enter your email" required id="email" name="email" />
        <div id="emailmassage"></div>
        <input type="password" placeholder="Create a password" required id="password" name="password" />
        <div id="passwordmassage"></div>

        <input type="password" placeholder="Confirm your password" required id="repassword" />
        <div id="repasswordmassage"></div>
        <input type="date" id="birthdate" name="birthdate" required />
        <div id="dobMessage"></div>
        <input type="submit" class="button" value="Signup" />
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
          <label for="check">Login</label>
        </span>
      </div>
    </div>
  </div>
</body>

</html>

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