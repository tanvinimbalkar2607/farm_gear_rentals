
<?php
session_start();
if (!isset($_SESSION['admin']) ) {
    header("Location: admin_login.php");
    exit();
    
        
}

include 'config.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_name = isset($_POST['name']) ? $_POST['name']: '';
    $description = isset($_POST['description']) ? $_POST['description']: '';
    $rent_per_day = isset($_POST['rent_per_day']) ? $_POST['rent_per_day']: '';
    
    // Handle Image Upload
    $target_dir = "uploads/";
    $image_name = time() . "_" . basename($_FILES["image"]["name"]); // Unique filename
    $target_file = $target_dir . $image_name; // Full path
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO equipment (equipment_name, description, rent_per_day, image) VALUES ('$equipment_name', '$description', '$rent_per_day', '$target_file')";
        if ($conn->query($sql) === TRUE) {
         echo "Equipment added successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 50%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px #ccc; margin-top: 30px; }
        input, select, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #28a745; color: white; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Farming Equipment</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Equipment Name" required>
        <input type="text" name="description" placeholder="description" required>
        <input type="decimal" name="rent_per_day" placeholder="Rent per Day (₹)" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Equipment</button>
    </form>
    <p>Equipment Add successfully</p>
</div>

</body>
</html>

