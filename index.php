<?php
session_start();

// COOKIE: Check if username was previously saved
$saved_name = isset($_COOKIE['remember_user']) ? $_COOKIE['remember_user'] : '';

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];
    $email = $_POST['email'] ?? '';

    // VALIDATIONS
    if (empty($user) || empty($pass)) {
        $errors[] = "All fields are required.";
    } elseif (strlen($user) < 6) {
        $errors[] = "Username must be at least 6 characters.";
    } elseif (strlen($pass) < 8) { // Add this to check password length
    $errors[] = "Password must be at least 8 characters.";
    } elseif (isset($_GET['mode']) && $_GET['mode'] == 'signup' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($errors)) {
        // SESSION: Log the user in
        $_SESSION['user'] = $user;
        // COOKIE: Save username for 24 hours
        setcookie("remember_user", $user, time() + 86400, "/");
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Hub | Access</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <h2><?php echo isset($_GET['mode']) && $_GET['mode'] == 'signup' ? 'Create Account' : 'Welcome Back'; ?></h2>
    
    <?php if(!empty($errors)): ?>
        <div class="error-msg">
            <?php foreach($errors as $err) echo $err . "<br>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" value="<?php echo $saved_name; ?>">
        
        <?php if(isset($_GET['mode']) && $_GET['mode'] == 'signup'): ?>
            <input type="text" name="email" placeholder="Email Address">
        <?php endif; ?>

        <input type="password" name="password" placeholder="Password">
        <button type="submit">Continue</button>
    </form>

    <a href="index.php?mode=<?php echo isset($_GET['mode']) ? 'login' : 'signup'; ?>" class="toggle-link">
        <?php echo isset($_GET['mode']) ? 'Already have an account? Login' : 'Need an account? Signup'; ?>
    </a>
</div>

</body>
</html>