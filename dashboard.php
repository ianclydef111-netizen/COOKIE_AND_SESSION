<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="dashboard-container">
    <h1>Hello, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
    <p>You have successfully accessed your <strong>Final Project Hub</strong>.</p>
    <hr>
    <p><strong>Session Status:</strong> Active ✅</p>
    <p><strong>Cookie Status:</strong> 'remember_user' is stored in your browser.</p>
    <br>
    <a href="logout.php" class="logout-btn">Sign Out</a>
</div>

</body>
</html>