<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $your_name = $_POST["your_name"] ?? '';
    $email = $_POST["email"] ?? '';
    $message = $_POST["message"] ?? '';

    // Validate form data
    if (!empty($your_name) && !empty($email) && !empty($message)) {
        // Create connection
        $conn = new mysqli("localhost:3306", "root", "", "contact us");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Escape special characters to prevent SQL injection
        $your_name = $conn->real_escape_string($your_name);
        $email = $conn->real_escape_string($email);
        $message = $conn->real_escape_string($message);

        // Insert data into the database
        $sql = "INSERT INTO form (your_name, email, message) VALUES ('$your_name', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            // Display a success message
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Success</title>
                <link rel='stylesheet' href='styles.css'>
            </head>
            <body>
                <div style='text-align: center; margin-top: 50px;'>
                    <h1>Message Sent Successfully!</h1>
                    <p>Thank you, $your_name. We will get back to you soon!</p>
                    <a href='index.html'>Go Back</a>
                </div>
            </body>
            </html>
            ";
        } else {
            // Display an error message
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Error</title>
                <link rel='stylesheet' href='styles.css'>
            </head>
            <body>
                <div style='text-align: center; margin-top: 50px;'>
                    <h1>Error</h1>
                    <p>There was an issue submitting your message. Please try again later.</p>
                    <a href='index.html'>Go Back</a>
                </div>
            </body>
            </html>
            ";
        }

        // Close connection
        $conn->close();
    } else {
        // Display validation error message
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Validation Error</title>
            <link rel='stylesheet' href='styles.css'>
        </head>
        <body>
            <div style='text-align: center; margin-top: 50px;'>
                <h1>Validation Error</h1>
                <p>Please fill in all the required fields.</p>
                <a href='index.html'>Go Back</a>
            </div>
        </body>
        </html>
        ";
    }
}
?>
