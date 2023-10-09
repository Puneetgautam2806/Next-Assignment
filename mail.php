<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient_email = ".com"; // Owner's email address

    // Get form inputs
    $sender_name = $_POST["name"];
    $sender_email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Validation (you can add more validation as needed)
    if (empty($sender_name) || empty($sender_email) || empty($subject) || empty($message)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
        echo "<script>window.location.href='your_form_page.html';</script>";
        exit; // Exit to prevent further execution
    }

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["document"]["name"]);
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_extensions = array("pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx", "jpg", "jpeg", "png");

    if (in_array($file_extension, $allowed_extensions)) {
        move_uploaded_file($_FILES["document"]["tmp_name"], $target_file);
    } else {
        echo "<script>alert('Invalid file type. Please upload a PDF, Word, PowerPoint, Excel, JPEG, JPG, or PNG file.');</script>";
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
        <p><strong>Subject:</strong> $subject</p>
        <p><strong>Message:</strong> $message</p>
    </body>
    </html>";

    // Attach the file
    $file = fopen($target_file, 'rb');
    $file_data = fread($file, filesize($target_file));
    fclose($file);
    $file_encoded = base64_encode($file_data);

    $email_message .= "\r\n\r\n--boundary_example\r\n";
    $email_message .= "Content-Type: application/octet-stream; name=\"" . basename($target_file) . "\"\r\n";
    $email_message .= "Content-Transfer-Encoding: base64\r\n";
    $email_message .= "Content-Disposition: attachment; filename=\"" . basename($target_file) . "\"\r\n\r\n";
    $email_message .= chunk_split($file_encoded) . "\r\n";

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
