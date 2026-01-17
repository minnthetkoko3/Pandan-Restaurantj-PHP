<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "rootfedora!";
$dbname = "pandan_db";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $conn = @new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("<h2>Database Connection Failed</h2><p>Error: " . $conn->connect_error . "</p><p>Please check your database password.</p>");
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $feedback = $_POST['message'];
    $promotion = $_POST['promotion'];
    $date = date("Y-m-d");

    $sms = isset($_POST['ch_sms']) ? 'Y' : 'N';
    $wa  = isset($_POST['ch_wa'])  ? 'Y' : 'N';
    $em  = isset($_POST['ch_em'])  ? 'Y' : 'N';
    $channel = $sms . $wa . $em;

    $sql = "INSERT INTO Feedback (Feedback_date, Name, Emailid, Phone, Feedback, Promotion, Channel)
            VALUES ('$date', '$name', '$email', '$phone', '$feedback', '$promotion', '$channel')";

    echo "<!DOCTYPE html><html><head><title>Submission Status</title><link rel='stylesheet' href='style.css'></head>";
    echo "<body style='text-align:center; padding-top:50px; background-color:#CED0C0;'>";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='background:#F6F3EB; padding:30px; display:inline-block; border-radius:10px; border: 2px solid #2E2E28;'>";
        echo "<h1 style='color:green;'>Feedback Submitted!</h1>";
        echo "<p>Thank you, $name.</p>";
        echo "<br><a href='index.html' style='font-weight:bold; color:#2E2E28; font-size:18px;'>Return to Home</a>";
        echo "</div>";
    } else {
        echo "<div style='background:#F6F3EB; padding:30px; display:inline-block; border-radius:10px; border: 2px solid red;'>";
        echo "<h1 style='color:red;'>Error!</h1>";
        echo "<p>Could not save data: " . $conn->error . "</p>";
        echo "</div>";
    }
    echo "</body></html>";
    $conn->close();
} else {
    echo "<h2>Access Denied</h2><p>Please submit the form from the <a href='index.html'>Home Page</a>.</p>";
}
?>