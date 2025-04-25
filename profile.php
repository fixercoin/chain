 <?php
session_start();
if (!isset($_SESSION['account_loggedin']) || $_SESSION['account_loggedin'] !== TRUE) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['account_id']);

// Set parameters and execute
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $email);
$stmt->fetch();

echo "Welcome, " . htmlspecialchars($username, ENT_QUOTES) . "!<br>";
echo "Email: " . htmlspecialchars($email, ENT_QUOTES) . "<br>";
echo "<a href='logout.php'>Logout</a>";

$stmt->close();
$conn->close();
?>
