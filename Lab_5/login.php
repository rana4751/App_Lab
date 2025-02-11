<?php
session_start();

$servername = "localhost";
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "user_system"; // database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginUsername = $_POST['loginUsername'];
    $loginPassword = $_POST['loginPassword'];

    // Validate user credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $loginUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($loginPassword, $user['password'])) {
        // Increase login count
        $newLoginCount = $user['login_count'] + 1;
        $stmt = $conn->prepare("UPDATE users SET login_count = ? WHERE username = ?");
        $stmt->bind_param("is", $newLoginCount, $loginUsername);
        $stmt->execute();

        // Display login info
        echo "<h1 style='background-color: #4CAF50; color: white; padding: 20px; text-align: center; border-radius: 8px;'>Welcome, " . $loginUsername . "! You have logged in " . $newLoginCount . " times.</h1>";
        echo "<div class='home-btn'><a href='index.html'>Go to Home Page</a></div>";
    } else {
        echo "<p class='error'>Invalid username or password.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
