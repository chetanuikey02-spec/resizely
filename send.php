<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['send'])){

    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    /* =======================
       1️⃣ ADMIN EMAIL
    ======================= */
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'resizelytools@resizely.in';     // 👈 Gmail
        $mail->Password   = 'Chetan@032004';       // 👈 App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('yourgmail@gmail.com', 'Resizely Contact');
        $mail->addAddress('yourgmail@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Message';
        $mail->Body    = "
        <b>Name:</b> $name <br>
        <b>Email:</b> $email <br><br>
        <b>Message:</b><br>$message
        ";

        $mail->send();
    } catch (Exception $e) {
        echo "Admin mail error";
    }

    /* =======================
       2️⃣ AUTO-REPLY TO USER
    ======================= */
    $reply = new PHPMailer(true);
    try {
        $reply->isSMTP();
        $reply->Host       = 'smtp.gmail.com';
        $reply->SMTPAuth   = true;
        $reply->Username   = 'yourgmail@gmail.com';
        $reply->Password   = 'APP_PASSWORD_HERE';
        $reply->SMTPSecure = 'tls';
        $reply->Port       = 587;

        $reply->setFrom('yourgmail@gmail.com', 'Resizely');
        $reply->addAddress($email);

        $reply->isHTML(true);
        $reply->Subject = 'We received your message';
        $reply->Body = "
        Hi $name 👋,<br><br>
        Thank you for contacting <b>Resizely</b>.<br>
        We have received your message and will reply soon.<br><br>
        Regards,<br>
        <b>Resizely Team</b>
        ";

        $reply->send();
        echo "✅ Message sent successfully!";
    } catch (Exception $e) {
        echo "❌ Auto-reply failed";
    }
}
?>
