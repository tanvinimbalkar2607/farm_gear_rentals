<?php
// Database Connection
session_start();
include 'config.php';

// PHPMailer import
require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    // 1️⃣ Update status in database
    $sql = "UPDATE bookings SET status='$status' WHERE booking_id='$booking_id'";
    
    if ($conn->query($sql) === TRUE) {
        // 2️⃣ Get user_id from bookings table
        $sql2 = "SELECT user_id, equipment_id, start_date, end_date FROM bookings WHERE booking_id='$booking_id'";
        $result2 = $conn->query($sql2);
        if($result2->num_rows > 0){
            $booking = $result2->fetch_assoc();
            $user_id = $booking['user_id'];
            $equipment_id = $booking['equipment_id'];
            $start_date = $booking['start_date'];
             $end_date = $booking['end_date'];

            // 3️⃣ Get user email from users table
            $sql3 = "SELECT user_email, user_name FROM users WHERE user_id='$user_id'";
            $result3 = $conn->query($sql3);
            if($result3->num_rows > 0){
                $user = $result3->fetch_assoc();
                $user_email = $user['user_email'];
                $user_name = $user['user_name'];


                $sql4 = "SELECT equipment_name FROM equipment WHERE equipment_id='$equipment_id'";
        $result4 = $conn->query($sql4);
        $equipment = $result4->fetch_assoc();
        $equipment_name = $equipment['equipment_name'];
        

                

                 

                // 4️⃣ Send email using PHPMailer
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tanvinimbalkar2607@gmail.com';      
    $mail->Password   = 'dfoz dmww vwwm jshl';        
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

                    $mail->setFrom('tanvinimbalkar2607@gmail.com', 'Farm Gear Rentals');
                    $mail->addAddress($user_email, $user_name);
                     $mail->isHTML(true);
                     $mail->Subject = 'Booking Confirmed';
                     $mail->Body = "Hello $user_name,<br><br>Your booking has been 
                     <b>$status</b>.<br><b>Booking id</b> =$booking_id. <br><br><b>Equipment Details:</b><br>Name: $equipment_name<br>
                     Start Date: $start_date<br>End Date: $end_date<br><br>Thank you for choosing <b>Farm Gear Rentals</b>! .";             

                    $mail->send();
                    echo "Booking updated & email sent successfully!";
                } catch (Exception $e) {
                    echo "Booking updated but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    
    }
    } else {
        echo "Error updating record: " . $conn->error;
    }


// Redirect back to admin dashboard
header("Location: admin_dashboard.php");
exit();


$conn->close();
?>