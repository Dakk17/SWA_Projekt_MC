<?php
$to = "your@email.com";
$subject = "Test Mail";
$message = "This is a test email.";
$headers = "From: webmaster@example.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Mail sent successfully";
} else {
    echo "Mail failed";
}
?>
