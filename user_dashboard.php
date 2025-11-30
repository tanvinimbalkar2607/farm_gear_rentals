<?php
session_start();
include 'config.php';

$sql = "SELECT * FROM equipment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    text-align: center;
}

.container {
    padding: 20px;
}

.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    gap: 15px;
}

.card {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 250px; /* Slightly larger width */
    margin: 10px;
    padding: 15px;
    text-align: center;
    display: flex;
    flex-direction: column;
    height: auto; /* Allow cards to expand based on content */
}

.card .content {
    flex-grow: 1;
    padding: 10px;
}

.card img {
    width: 100%;
    height: 200px; /* Fixed height for images */
    object-fit: cover; /* Ensures the image covers the space without distortion */
    border-radius: 10px;
}

.card h3 {
    font-size: 1.2em;
    color: #333;
    margin-top: 10px;
}

.card p {
    font-size: 1em;
    color: #777;
}

.card .price {
    font-size: 1.5em;
    color: #28a745;
    font-weight: bold;
}

.book-now-btn {
    padding: 10px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    margin-top: auto; /* Push the button to the bottom */
}

.book-now-btn:hover {
    background: #0056b3;
}

    </style>
</head>
<body>

<nav>
    <a href="my_booking.php" class="btn btn-edit">My Booking</a>
</nav>

<div class="container">
    <h2>Available Equipment</h2>
    <div class="card-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="card">
                <form action="book_equipment.php" method="POST">
                    <input type="hidden" name="equipment_id" value="<?= $row['equipment_id'] ?>">
                    <img src="<?= !empty($row['image']) ? htmlspecialchars($row['image']) : 'default.jpg' ?>" alt="Image">
                    <div class="content">
                        <h3><?= $row['equipment_name'] ?></h3>
                        <p><?= $row['description'] ?></p>
                        <p class="price">₹<?= $row['rent_per_day'] ?> per day</p>
                    </div>
                    <button class="book-now-btn">Book Now</button>
                </form><br>

            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
