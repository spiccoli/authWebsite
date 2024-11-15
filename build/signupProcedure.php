<?php
$is_invalid = false;

// Validate name
if (empty($_POST["name"])) {
    $is_invalid = true;
    $error_message = "Invalid name. Please provide a valid name.";
}

// Validate email
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $is_invalid = true;
    $error_message = "Invalid email. Please provide a valid email address.";
}

// Validate password length
if (strlen($_POST["password"]) < 8) {
    $is_invalid = true;
    $error_message = "Password must be greater than 8 characters.";
}

// Validate password content
if (!preg_match("/[a-z]/i", $_POST["password"]) || !preg_match("/[0-9]/", $_POST["password"])) {
    $is_invalid = true;
    $error_message = "Password must contain at least one letter and one number.";
}

// Confirm password match
if ($_POST["password"] !== $_POST["confirmed-password"]) {
    $is_invalid = true;
    $error_message = "Passwords must match.";
}

// If there are any validation errors, exit
if ($is_invalid) {
    echo $error_message;
    exit;
}

// Hash the password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Database connection
$mysqli = require __DIR__ . "/database.php";

// SQL query
$sql = "INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)";

// Prepare statement
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

try {
    if ($stmt->execute()) {
        header("Location: signedin.html");
        exit;
    } else {
        throw new mysqli_sql_exception("Execution failed");
    }
} catch (mysqli_sql_exception $e) {
    echo "Oops! The email address is already in use. Please choose a different one.";
}
?>
