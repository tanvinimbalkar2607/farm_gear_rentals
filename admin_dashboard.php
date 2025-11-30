<?php
session_start();
include 'config.php';

// Fetch all equipment
$equipment_result = $conn->query("SELECT * FROM equipment");

// Fetch all bookings
$booking_result = $conn->query("SELECT * FROM bookings");
// Check if form is submitted



?>

<!DOCTYPE html>
<html lang="en">
<head><style>

        body { font-family: Arial, sans-serif;    background: white ;
        }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: center; }
        th { background: #28a745; color: white; }
        .btn { padding: 5px 10px; color: black; border: none; border-radius: 5px; cursor: pointer; }
         .btn-delete { background: #dc3545; }
    
{  
display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(0, 0, 0, 0.8);
    padding: 10px 20px;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
}

nav .logo {
    color: white;
    font-size: 20px;
    font-weight: bold;
}

nav ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

nav ul li {
    margin: 0 10px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 5px;
}

nav ul li a:hover {
    background:rgb(226, 146, 33);
}
    </style>
</head>
<body>
<nav>
<ul>
   <li> <a href="user_list.php" class="btn btn-edit">User list</a></li>
   <li><a href="add_equipment.php" class="btn btn-edit">+ Add Equipment</a></li>
   <li> <a href="logout.php" class="btn btn-logout">Logout</a><br><br></li>
   <li> <a href="Registration_report.php" class="btn btn-logout">Regisrtion Report</a><br><br></li>
   <li> <a href="equipment_report.php" class="btn btn-logout">Equipment Reort</a><br><br></li>
   <li> <a href="booking_report.php" class="btn btn-logout">Booking Roport</a><br><br></li>
   <li> <a href="feedback_report.php" class="btn btn-logout">Feedback Report</a><br><br></li>



</ul>
</nav>
    <div class="container">
            <table>
                <tr>
                    <th> Equipment ID</th>
                    <th> Equipment image</th>
                    <th> Equipment Name</th>
                    <th>Description</th>
                    <th>Rent per day</th>
                    <th>Action</th>
        </tr>
        <?php while ($row = $equipment_result->fetch_assoc()) { ?>
         
        <tr>
        <td><?= $row['equipment_id'] ?></td>

                <td>
    <img src="<?= !empty($row['image']) ? htmlspecialchars($row['image']) : 'default.jpg' ?>" alt="Image" width="50">
</td><br>

                <td><?= $row['equipment_name'] ?></td>
                <td><?= $row['description'] ?></td>
                <td>₹<?= $row['rent_per_day'] ?>/day</td>
                <td>
     
     <a href="delete_equipment.php">Delete Equipment</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        
            <h3>Booking Reports</h3>
    



<form method="POST" action="update_booking.php">
<table>
        <tr>
            <th>Booking ID</th>
            <th>user id</th>
            <th>Equipment id</th>
            <th>From</th>
            <th>To</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
        <?php while ($row = $booking_result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['booking_id'] ?></td>
                <td><?= $row['user_id'] ?></td>
                <td><?= $row['equipment_id'] ?></td>
                <td><?= $row['start_date'] ?></td>
                <td><?= $row['end_date'] ?></td>
                <td>₹<?= $row['total_price'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                <form method="POST" action="update_booking.php">
    <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
    <select name="status">
        <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
        <option value="Confirmed" <?php if ($row['status'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
        <option value="Cancelled" <?php if ($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
        <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
    </select>
    <button type="submit">Update</button>
</form>
            </td>
        </tr>
    <?php } ?>

    </table>
<br>
<button type="submit" name="update_booking">Update</button>
</form>
</body>
</html>