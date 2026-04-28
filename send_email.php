<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Ambil data dari fetch
$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$email = $data['email'];
$subject = $data['subject'];
$message = $data['message'];

$mail = new PHPMailer(true);

try {
    // CONFIG SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'emailkamu@gmail.com'; // GANTI
    $mail->Password   = 'APP_PASSWORD_KAMU';   // GANTI
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // PENGIRIM
    $mail->setFrom('emailkamu@gmail.com', 'Portfolio Website');

    // TUJUAN
    $mail->addAddress('adamviansyah123@gmail.com');

    // ISI
    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body    = "Nama: $name\nEmail: $email\nPesan:\n$message";

    $mail->send();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $mail->ErrorInfo
    ]);
}
fetch("send-email.php", {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  body: JSON.stringify({
    name: name,
    email: email,
    subject: subject,
    message: message
  })
})
.then(res => res.json())
.then(data => {
  if (data.success) {
    alert("Email berhasil dikirim!");
  } else {
    alert("Error: " + data.message);
  }
});