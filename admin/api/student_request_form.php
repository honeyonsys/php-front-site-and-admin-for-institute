<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and sanitize the input
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $class = filter_var($_POST["class"], FILTER_SANITIZE_STRING);
    $rollno = filter_var($_POST["rollno"], FILTER_SANITIZE_STRING);
    $leavefrom = filter_var($_POST["leavefrom"], FILTER_SANITIZE_STRING);
    $leaveto = filter_var($_POST["leaveto"], FILTER_SANITIZE_STRING);
    $reason = filter_var($_POST["reason"], FILTER_SANITIZE_STRING);
    $days = filter_var($_POST["days"], FILTER_SANITIZE_STRING);
    $teachername = filter_var($_POST["teachername"], FILTER_SANITIZE_STRING);

    // Set the email recipient
    $to = "your_email@example.com";

    // Set the email subject
    $subject = "Leave Application Form Submitted";

    // Set the email message body
    $message = "Name: $name\n\n";
    $message .= "Class: $class\n\n";
    $message .= "Roll No: $rollno\n\n";
    $message .= "Leave From: $leavefrom\n\n";
    $message .= "Leave To: $leaveto\n\n";
    $message .= "Reason: $reason\n\n";
    $message .= "No of Days: $days\n\n";
    $message .= "Tutorial Teacher Name: $teachername\n\n";

    // Set the email headers
    $headers = "From: $name <$to>" . "\r\n";
    $headers .= "Reply-To: $to" . "\r\n";

    // Send the email
    if(mail($to, $subject, $message, $headers)) {
        // If the email was sent successfully, redirect to a success page
        header("Location: success.html");
        exit;
    } else {
        // If the email was not sent, redirect to an error page
        header("Location: error.html");
        exit;
    }
}
?>
