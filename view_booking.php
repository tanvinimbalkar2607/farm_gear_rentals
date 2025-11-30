<?php
session_start();
// Fetch all booked equipment details
$query = "SELECT bookings.*, users.name AS user_name, equipment.name AS equipment_name, 
                 equipment.description, equipment.price_per_day 
          FROM bookings 
          JOIN users ON bookings.user_id = users.user_id 
          JOIN equipment ON bookings.equipment_id = equipment.equipment_id 
          ORDER BY bookings.booking_id DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booked Equipment</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <
    <main>
        <h2>All Booked Equipment</h2>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>User</th>
                <th>Equipment Name</th>
                <th>Description</th>
                <th>Price (₹/Day)</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['booking_id']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['equipment_name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>₹<?php echo $row['price_per_day']; ?></td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['end_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending') { ?>
                            <a href="update_booking.php?id=<?php echo $row['booking_id']; ?>&status=Confirmed">✅ Approve</a>
                            <a href="update_booking.php?id=<?php echo $row['booking_id']; ?>&status=Cancelled">❌ Cancel</a>
                        <?php } else {
                            echo "✔ Processed";
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>
