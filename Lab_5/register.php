<?php
$servername = "localhost";
$username = "root"; // your MySQL username
$password = "";     // your MySQL password
$dbname = "user_system"; // database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hashing the password

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p>Username is already taken.   <a href='index.html'>Go to Login</a></p> ";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, password, login_count) VALUES (?, ?, 0)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo "<p class='success'>Registration successful! <a href='index.html'>Go to Login</a></p>";
        } else {
            echo "<p class='error'>Error: " . $stmt->error . "</p>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
