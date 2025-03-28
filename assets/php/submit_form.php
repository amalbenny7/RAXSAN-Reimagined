<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Validate input fields
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit
        http_response_code(400);
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Setup email recipient and subject
    $recipient = "amalbenny.contact@gmail.com";
    $subject = "New contact from $name";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Sending email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // If mail fails, set a 500 internal server error response code
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }
} else {
    // If not a POST request, set a 403 (forbidden) response code
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
