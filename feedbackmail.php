<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient_email = "assignmentnext@gmail.com"; // Owner's email address

    // Get form inputs
    $sender_name = $_POST["name"];
    $sender_phone = $_POST["phone"];
    $sender_email = $_POST["email"];
    $subject = "FeedBack from Client";
    $message = $_POST["message"];

    // Validation (you can add more validation as needed)
    if (empty($sender_name) || empty($sender_email) || empty($subject) || empty($message)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
        echo "<script>window.location.href='your_form_page.html';</script>";
        exit; // Exit to prevent further execution
    }

   

    // Compose email
    $headers = "From: $sender_name <$sender_email>";
    $headers .= "\r\nReply-To: $sender_email";
    $headers .= "\r\nMIME-Version: 1.0";
    $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"boundary_example\"";

    $email_message = "--boundary_example\r\n";
    $email_message .= "Content-Type: text/html; charset=\"ISO-8859-1\"\r\n\r\n";
    $email_message .= "
    <html>
    <body>
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $sender_name</p>
        <p><strong>Email:</strong> $sender_email</p>
        <p><strong>Phone:</strong> $sender_phone</p>
        <p><strong>Subject:</strong> $subject</p>
        <p><strong>Message:</strong> $message</p>
    </body>
    </html>";

   


    $email_message .= "--boundary_example--";

    // Send email
    if (mail($recipient_email, $subject, $email_message, $headers)) {
        echo "<script>alert('Your Quote has been sent successfully');</script>";
        echo "<script>window.location.href='product.html';</script>";
     } else {
         echo "<script>alert('Error In Sending your Quote');</script>";
         echo "<script>window.location.href='index.html';</script>";
     }
}
?>
