<?php 
session_start(); 
include 'config.php';  

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {     
    echo "Error: User not logged in.";     
    exit; 
}

$user_id = $_SESSION['user_id'];  // User ID from session
$query = $conn->query("SELECT  user_name  FROM users WHERE user_id = '$user_id'");
if ($query->num_rows <= 0) {
    echo "<script>alert('Invalid user ID!'); window.location.href='user_dashboard.php';</script>";
    exit;
}
$row = $query->fetch_assoc();
$user_name = $row['user_name'];
// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = trim($_POST['message']);
    
    // Validate message
    if (empty($message)) {
        $error = "Contact message is required.";
    } else {
        // Prepare the SQL statement to insert feedback
        $stmt = $conn->prepare("INSERT INTO contact (user_id, user_name, message) VALUES (?, ?, ?)");
        
        if ($stmt) {
            // Bind the user ID (integer) and the message (string)
            $stmt->bind_param("iss", $user_id, $user_name, $message);
            
            // Execute the statement
            if ($stmt->execute()) {
                header("Location: index.html");
                exit;  
                        } else {
                $error = "Error: " . $stmt->error;  // Display specific database error
            }
            
            $stmt->close();  // Close the prepared statement
        } else {
            $error = "Database error: " . $conn->error;  // Handle database preparation error
        }
    }
}

$conn->close();  // Close database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Contact</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submit </h2>
        <form action="contact.php" method="POST">
            <label> Message:</label>
            <textarea name="message" rows="5" required></textarea>
            
            <!-- Display error or success message -->
            <?php 
                if (isset($error)) {
                    echo "<p class='error'>$error</p>";
                }
                if (isset($success)) {
                    echo "<p class='success'>$success</p>";
                }
            ?>

            <button type="submit">Submit </button>
        </form>
    </div>
</body>
</html>
