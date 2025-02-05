<?php
// Replace with your real receiving email address
$receiving_email_address = 'manojbr815@gmail.com';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_name = htmlspecialchars($_POST['name']);
    $from_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validate form inputs
    if (empty($from_name) || empty($from_email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo 'Please fill in all the fields.';
        exit;
    }

    if (!filter_var($from_email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo 'Invalid email address.';
        exit;
    }

    // Compose the email
    $email_body = "You have received a new message from your website contact form:\n\n";
    $email_body .= "Name: $from_name\n";
    $email_body .= "Email: $from_email\n";
    $email_body .= "Subject: $subject\n";
    $email_body .= "Message:\n$message\n";

    $headers = "From: $from_name <$from_email>\r\n";
    $headers .= "Reply-To: $from_email\r\n";

    // Send the email
    if (mail($receiving_email_address, $subject, $email_body, $headers)) {
        echo 'Your message has been sent. Thank you!';
    } else {
        http_response_code(500);
        echo 'Sorry, there was an error sending your message.';
    }
} else {
    http_response_code(403);
    echo 'Invalid request.';
}
?>
