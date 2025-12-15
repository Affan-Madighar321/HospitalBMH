<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Include Composer's autoloader (if using Composer)
require 'vendor/autoload.php';
// Or, for manual installation:
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP(); // Use SMTP
    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'your-email@gmail.com'; // Your Gmail address
    $mail->Password = 'your-app-password'; // Gmail App Password (see below)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS
    $mail->Port = 587; // TCP port

    // Recipients
    $mail->setFrom('your-email@gmail.com', 'Your Name');
    $mail->addAddress('recipient@example.com', 'Recipient Name'); // Add recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Reminder: Upcoming Event';
    $mail->Body = 'Hello,<br>This is a reminder for your upcoming event on [Event Date]. Please prepare accordingly.<br>Best regards,<br>Your Team';
    $mail->AltBody = 'This is a reminder for your upcoming event on [Event Date]. Please prepare accordingly.';

    // Send email
    $mail->send();
    echo 'Reminder email sent successfully!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>