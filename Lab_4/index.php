<?php
// Database connection settings
$servername = "localhost";  // Usually localhost
$username = "root";         // Default MySQL username in XAMPP
$password = "";             // Default MySQL password in XAMPP (empty)
$dbname = "textbook_reviews";  // Name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$review = '';
$error = '';
$visitorCount = 0; 

// Read visitor count from file (as before)
$file = 'visitor_count.txt';
if (file_exists($file)) {
    $visitorCount = (int)file_get_contents($file);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['review'])) {
        $review = (int)$_POST['review'];

        // Validate review input
        if ($review < 0 || $review > 5) {
            $error = "Review must be between 0 and 5!";
        } else {
            // Insert the valid review into the database
            $sql = "INSERT INTO reviews (review) VALUES ('$review')";

            if ($conn->query($sql) === TRUE) {
                // Review inserted successfully
                // Increment visitor count
                $visitorCount++;
                file_put_contents($file, $visitorCount);

                // Display success message
                echo "<p>Thank you for your review! You rated the textbook: $review/5</p>";
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Textbook Review</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Textbook Review System</h1>
            <p>Leave your review for the textbook (0-5):</p>
        </header>

        <section>
            <form action="" method="POST">
                <label for="review">Your Review (0 to 5):</label>
                <input type="number" name="review" id="review" min="0" max="5" value="<?= $review ?>" required>
                <button type="submit">Submit Review</button>
            </form>

            <?php if ($error): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            <!-- Only show the visitor count if a valid review was submitted -->
            <?php if ($review >= 0 && $review <= 5): ?>
                <p>Visitor count: <?= $visitorCount ?></p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
