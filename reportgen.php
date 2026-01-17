<?php
$servername = "localhost";
$username = "root";
$password = "rootfedora!"; 
$dbname = "pandan_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

$sql = "SELECT * FROM Feedback WHERE Feedback_date >= '$from_date' AND Feedback_date <= '$to_date'";
$result = $conn->query($sql);

echo "<!DOCTYPE html><html><head><link rel='stylesheet' href='style.css'>";
echo "<style>
        table { margin: 20px auto; border-collapse: collapse; width: 80%; background: #F6F3EB; }
        th, td { border: 1px solid #2E2E28; padding: 10px; text-align: center; color: #2E2E28; }
        th { background-color: #2E2E28; color: #F6F3EB; }
      </style></head>";
echo "<body style='padding-top: 20px; text-align:center;'>";

echo "<h1>FEEDBACKS RECEIVED BETWEEN $from_date and $to_date</h1>";

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Name</th>
            <th>Emailid</th>
            <th>Phone</th>
            <th>Promtion</th>
            <th>SMS</th>
            <th>WhatsApp</th>
            <th>Email</th>
          </tr>";

    while($row = $result->fetch_assoc()) {
        $ch = $row["Channel"];
        $sms_val = isset($ch[0]) ? $ch[0] : 'N';
        $wa_val  = isset($ch[1]) ? $ch[1] : 'N';
        $em_val  = isset($ch[2]) ? $ch[2] : 'N';

        echo "<tr>
                <td>" . $row["Name"] . "</td>
                <td>" . $row["Emailid"] . "</td>
                <td>" . $row["Phone"] . "</td>
                <td>" . $row["Promotion"] . "</td>
                <td>" . $sms_val . "</td>
                <td>" . $wa_val . "</td>
                <td>" . $em_val . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results found.</p>";
}

echo "<br><br>";
echo "<a href='reportgen.html' style='margin-right:20px; font-weight:bold; color:#2E2E28;'>Regenerate Report</a>";
echo "<a href='index.html' style='font-weight:bold; color:#2E2E28;'>Home</a>";
echo "</body></html>";
$conn->close();
?>