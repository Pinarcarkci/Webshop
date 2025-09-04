<?php
session_start();
require 'functions.php';

$title = "Register";
HTMLhead($title);
displayNavbar($dbConnection);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name']; 
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
     // zet dit wachtwoord om in een onleesbare, veilige hash.

   //MYSQL statement
    $stmt = $dbConnection->prepare("INSERT INTO users (userName, userEmail, userPassword) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password); //"sss" betekent je gaat 3 strings (s = string) binden
    $stmt->execute();
    $stmt->close();

    header("Location: login.php");
    exit();
}
?>

<div class="registercontainer">
    <h2>Register</h2>
    <form method="POST">

    <div class="input-group">
        <span class="icon"><i class="fa-solid fa-user"></i></span>
        <input type="text" name="name" placeholder="Name" required>
    </div>
    <div class="input-group">
        <span class="icon"><i class="fa-solid fa-at"></i></span>
        <input type="text" name="email" placeholder="E-mail" required>
    </div>
    <div class="input-group">
        <span class="icon"><i class="fa-solid fa-lock"></i></span>
        <input type="password" name="password" placeholder="Password" required>
    </div>
    <div class="input-group">
        <span class="icon"><i class="fa-solid fa-check"></i></span>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    </div>

    <button class="lbtn" type="submit">SIGN UP</button>
    <p class="signup-link">Already a member? <a href="login.php">Log in now ➔</a></p>
</form>
</div>

<?php HTMLfooter(); ?>
