<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';  // Ensure this path matches your PHPMailer's autoload file.

// Function to send activation email
function sendActivationEmail($email, $name) {
    try {
        // Create the PHPMailer instance
        $mail = new PHPMailer(true);

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'mistyantelope@gmail.com'; // Your SMTP username
        $mail->Password = 'qgam kybv jwqn ahbh'; // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('wmsuccssms@gmail.com', 'WMSU - Student Management System');
        $mail->addAddress($email, $name); // Name and email for the recipient

        // Subject and HTML content of the email
        $mail->isHTML(true);
        $mail->Subject = 'WMSU - Student Management System [Please Activate your Account]';

        // Prepare email content with logos and formatted text
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; text-align: center; padding: 20px; background-color: #f2f2f2; border-radius: 10px;'>
          
              
    
                <!-- Text -->
                <div style='font-size: 24px; color: #2c3e50; font-weight: bold; text-align: center;'>
                    Western Mindanao State University <br> Student Management System
                </div>
    
      
    
            <!-- Main Content -->
            <h1 style='font-size: 24px; color: #2c3e50;'>Hello, $name!</h1>
            <p style='font-size: 18px; color: #34495e;'>Thank you for registering with the <strong>WMSU - Student Management System</strong>.</p>
            <p style='font-size: 18px; color: #34495e;'>Please click the link below to activate your account and complete your registration process:</p>
            <p style='font-size: 18px;'>
                <a href='../activate.php?email=$email' style='font-size: 20px; color: #2980b9; text-decoration: none;'>Activate Account</a>
            </p>
    
            <hr style='border: 1px solid #ddd; width: 80%; margin: 20px auto;'>
            <p style='font-size: 16px; color: #7f8c8d;'>If you have any issues, feel free to contact us at <a href='mailto:support@wmsu.edu.ph' style='color: #2980b9;'>support@wmsu.edu.ph</a></p>
    
            <div style='font-size: 14px; color: #7f8c8d;'>Best regards,<br>The WMSU Student Management System Team</div>
        </div>";
    
    
        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Ensure the required parameters are passed (email and name)
if (isset($_GET['email']) && isset($_GET['name'])) {
    $email = $_GET['email'];
    $name = $_GET['name'];

    // Send activation email
    if (sendActivationEmail($email, $name)) {
        echo "Activation email sent successfully!";
    } else {
        echo "There was an issue sending the activation email. Please try again later.";
    }
} else {
    echo "Missing parameters for email or name.";
}
header('Location: ../index.php')
?>
