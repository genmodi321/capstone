<?php
require_once 'conn.php'; // Database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';  // PHPMailer's autoload

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    try {
        // Check if the email exists in the database
        $query = "SELECT * FROM students WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate a unique token for password reset
            $token = bin2hex(random_bytes(50)); // You can store this in your database for verification

            // Store the token in the database or session
            $query = "UPDATE students SET reset_token = :token WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':token' => $token, ':email' => $email]);

            // Send the reset password email
            if (sendResetPasswordEmail($email, $token)) {
                $_SESSION['STATUS'] = "RESET_LINK_SENT";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['STATUS'] = "EMAIL_NOT_FOUND";
            header("Location: ../index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Please submit a valid email address.";
}

function sendResetPasswordEmail($email, $token)
{
    try {
        // PHPMailer settings
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'mistyantelope@gmail.com'; // Your SMTP username
        $mail->Password = 'qgam kybv jwqn ahbh'; // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('wmsuccssms@gmail.com', 'WMSU - Student Management System');
        $mail->addAddress($email);

        // Reset link
        $resetLink = "http://localhost/capstone/login/processes/reset_password.php?token=$token";

        // Compose the email content with logos and formatted text
        $mail->isHTML(true);
        $mail->Subject = 'WMSU - Student Management System [Password Reset]';
        $mail->Body = "
    <div style='font-family: Arial, sans-serif; background-color: #f2f2f2; text-align: center; padding: 40px; border-radius: 10px;'>

        <!-- Header Section with WMSU and Student Management System Text -->
        <div style='margin-bottom: 40px;'>
            <h2 style='font-size: 28px; color: #2c3e50; font-weight: bold; margin: 0;'>Western Mindanao State University</h2>
            <h3 style='font-size: 22px; color: #2980b9; font-weight: normal; margin: 5px 0;'>Student Management System</h3>
        </div>

        <!-- Main Content Section with Password Reset -->
        <div style='background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);'>
            <h1 style='font-size: 24px; color: #2c3e50;'>Password Reset Request</h1>
            <p style='font-size: 18px; color: #34495e;'>You requested a password reset for your <strong>WMSU - Student Management System</strong> account.</p>
            <p style='font-size: 18px; color: #34495e;'>Please click the link below to reset your password and regain access to your account:</p>

            <p style='font-size: 20px; margin-top: 20px;'>
                <a href='$resetLink' style='font-size: 20px; color: #ffffff; background-color: #2980b9; text-decoration: none; padding: 12px 25px; border-radius: 5px;'>
                    Reset Password
                </a>
            </p>
            <p style='font-size: 16px; color: #34495e;'>If you did not request this reset, please ignore this email.</p>
        </div>

        <!-- Footer Section with Contact Details -->
        <hr style='border: 1px solid #ddd; width: 80%; margin: 30px auto;'>
        <p style='font-size: 16px; color: #7f8c8d;'>If you have any issues, feel free to contact us at:</p>
        <p style='font-size: 16px; color: #2980b9;'><a href='mailto:support@wmsu.edu.ph' style='color: #2980b9;'>support@wmsu.edu.ph</a></p>

        <div style='font-size: 14px; color: #7f8c8d; margin-top: 30px;'>
            Best regards,<br>The WMSU Student Management System Team
        </div>
    </div>
";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
}
?>