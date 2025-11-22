<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* ------------------------------------------
       TURNSTILE CAPTCHA VERIFICATION
    ------------------------------------------- */

    $secretKey = "0x4AAAAAACCV9vXEuRxLQyIPIGLohTQXfrA";  // <-- YOUR SECRET KEY
    $token = $_POST["cf-turnstile-response"];

    $ch = curl_init("https://challenges.cloudflare.com/turnstile/v0/siteverify");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $secretKey,
        'response' => $token
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($ch), true);

    if (!$response["success"]) {
        die("Captcha verification failed.");
    }

    /* ------------------------------------------
       FORM DATA
    ------------------------------------------- */

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $service = $_POST["service"];
    $message = $_POST["message"];

    /* ------------------------------------------
       SEND EMAIL
    ------------------------------------------- */

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