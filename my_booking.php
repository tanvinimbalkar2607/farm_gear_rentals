<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id']; 

$query = "SELECT * FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; }
        .container { width: 80%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px #ccc; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #28a745; color: white; }
        img { width: 100px; }
        button { padding: 8px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style></head>
<body>

<h2>My Bookings</h2>

<table>
    <tr>
        <th>Booking ID</th>
        <th>User ID</th>
        <th>Equipment ID</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Total Price</th>
        <th>Status</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>

        <tr>
            <td><?php echo $row['booking_id']; ?></td>            
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['equipment_id']; ?></td>
            <td><?php echo $row['start_date']; ?></td>
            <td><?php echo $row['end_date']; ?></td>
            <td><?php echo $row['total_price']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
    <?php } ?>

</table>

<a href="user_dashboard.php">Back to Dashboard</a>

</body>
</html>

<?php $conn->close(); ?>
