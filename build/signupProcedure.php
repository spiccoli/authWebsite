<?php
if ( empty($_POST["name"])) {   
    die ("Invalid Name");
}
if(! filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
    die ("Invalid email");
}
if(strlen($_POST["password"]) < 3){
    die ("password must be greater than 3 characters");
};
if (!preg_match("/[a-z]/i",$_POST["password"])||!preg_match("/[0-1]/",$_POST["password"])) {
    die("password must contain at least one letter and one number");  
};
if ($_POST["password"] !== $_POST["confirmed-password"]) {
    die ("passwords must match");
};

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash
);
try {                 
if ($stmt->execute()) {
    header("Location: signedin.html");
    exit;
} 
} catch (mysqli_sql_exception $e) {
        echo "Oops! The email address is already in use. Please choose a different one.";
    }

