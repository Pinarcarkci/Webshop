<?php
session_start();
require 'functions.php';

$title = "Login";
HTMLhead($title);
displayNavbar($dbConnection);

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $stmt = $dbConnection->prepare("SELECT userId, userName, userPassword FROM users WHERE userEmail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['userPassword'])) {
        $_SESSION['user'] = $user['userName']; 
        $_SESSION['userId'] = $user['userId']; 
        header("Location: index.php");
        exit();
    
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<div class="registercontainer">
    <h2>Login</h2>
    <form method="POST" class="login-form">
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <div class="input-group">
            <span class="icon"><i class="fa-solid fa-user"></i></span>
            <input type="text" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <span class="icon"><i class="fa-solid fa-lock"></i></span>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button class="lbtn" type="submit">SIGN IN</button>
        <p class="signup-link">Not a member? <a href="register.php">Sign up now ➔</a></p>
    </form>
</div>

<?php HTMLfooter(); ?>
