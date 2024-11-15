<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Use prepared statement
        $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password_hash"])) {
            header("Location: signedin.html");
            exit;
        }
    }
    
    $is_invalid = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWebsite</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h1 class="grid place-content-center pt-6">ADMIN PORTAL</h1>

    <?php if ($is_invalid): ?>
        <em>Invalid login. Please check your email and password.</em>
    <?php endif; ?>

    <div class="flex place-content-center">
        <div class="mt-10 grid place-content-center bg-slate-500 bg-opacity-30 rounded-lg p-4 shadow-md overflow-hidden">
            <p class="mb-5">LOGIN</p>
            <form method="POST">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="bg-opacity-40 bg-slate-200 border-black overflow-hidden rounded-lg" 
                           value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="bg-opacity-40 bg-slate-200 overflow-hidden rounded-lg" required>
                </div>
                <div class="mt-10 ml-40 text-sm">
                    <a href="./signup.html">CREATE ACCOUNT</a>
                    <button type="submit" class="ml-8">NEXT</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
