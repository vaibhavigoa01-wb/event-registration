
<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

function showMessage($title, $message) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Status</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container" style="padding:35px;text-align:center">
            <h1>' . htmlspecialchars($title, ENT_QUOTES, "UTF-8") . '</h1>
            <p style="margin:20px 0">' .
                htmlspecialchars($message, ENT_QUOTES, "UTF-8") .
            '</p>
            <a href="index.php">Back to registration</a>
        </div>
    </body>
    </html>';
}

$name = trim($_POST["full_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$event = trim($_POST["event_name"] ?? "");

$allowedEvents = [
    "Tech Fest",
    "Music Night",
    "Photography Workshop",
    "Entrepreneurship Seminar"
];

// Validate required fields
if ($name === "" || $email === "" ||
    $phone === "" || $event === "") {
    http_response_code(400);
    showMessage("Missing Details", "Please fill in every field.");
    exit;
}

// Validate name
if (strlen($name) > 100 ||
    !preg_match("/^[\p{L}\p{M} .'-]{2,100}$/u", $name)) {
    http_response_code(400);
    showMessage("Invalid Name", "Enter a valid name.");
    exit;
}

// Validate email
if (strlen($email) > 150 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    showMessage("Invalid Email", "Enter a valid email address.");
    exit;
}

// Validate phone number
if (!preg_match("/^[0-9]{10}$/", $phone)) {
    http_response_code(400);
    showMessage("Invalid Phone", "Enter a 10-digit phone number.");
    exit;
}

// Validate event selection on the server
if (!in_array($event, $allowedEvents, true)) {
    http_response_code(400);
    showMessage("Invalid Event", "Please select a valid event.");
    exit;
}

// Insert registration using a prepared statement
$stmt = $conn->prepare(
    "INSERT INTO registrations
    (full_name, email, phone, event_name)
    VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("ssss", $name, $email, $phone, $event);

try {
    $stmt->execute();
    showMessage(
        "Registration Successful!",
        "Thank you, $name. Your registration has been saved."
    );
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        http_response_code(409);
        showMessage(
            "Already Registered",
            "This email is already registered for this event."
        );
    } else {
        error_log($e->getMessage());
        http_response_code(500);
        showMessage(
            "Something Went Wrong",
            "Your registration could not be completed. Please try again."
        );
    }
}

$stmt->close();
$conn->close();
?>
