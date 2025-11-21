<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $service = $_POST["service"];
    $message = $_POST["message"];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'pravinsamr@gmail.com';
        $mail->Password = 'iqimxmrwfnwqacwg'; // Gmail App Password

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('pravinsamr@gmail.com', 'Website Contact Form');
        $mail->addAddress('pravinsamr@gmail.com');

        $mail->Subject = "New Contact Form Submission";
        $mail->Body = "
Name: $name
Email: $email
Phone: $phone
Service: $service

Message:
$message
";

        $mail->send();
        echo "Message sent successfully";
    } catch (Exception $e) {
        echo "Email failed. Error: {$mail->ErrorInfo}";
    }
}
?>
