<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id']; 
$equipment_id = $_POST['equipment_id'];

$query = $conn->query("SELECT * FROM equipment WHERE equipment_id = '$equipment_id'");
if ($query->num_rows <= 0) {
    echo "<script>alert('Invalid equipment ID!'); window.location.href='buyer_dashboard.php';</script>";
    exit;
}

$equipment = $query->fetch_assoc();
$rent_per_day = $equipment['rent_per_day'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $payment_method = $_POST['payment_method'];

    $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
    if ($days <= 0) {
        echo "<script>alert('End date must be after start date');</script>";
        exit;
    }

    $total_price = $rent_per_day * $days;

    // If Payment Method is Cash, Save directly
    if ($payment_method == "Cash") {
        $sql = "INSERT INTO bookings (user_id, equipment_id, start_date, end_date, payment_method, total_price, payment_status)
                VALUES ('$user_id', '$equipment_id', '$start_date', '$end_date', '$payment_method', '$total_price', 'Pending')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Booking Successful!'); window.location.href='user_dashboard.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
        exit;
    }

    // If Payment Method is Online → Redirect to Razorpay
    if ($payment_method == "Online") {
        $_SESSION['booking_amount'] = $total_price;
        $_SESSION['equipment_id'] = $equipment_id;
        $_SESSION['start_date'] = $start_date;
        $_SESSION['end_date'] = $end_date;

        header("Location: payment.php");
        exit;
    }
}
?>