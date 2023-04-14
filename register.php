<?php
session_start();

// Connect to the database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "userlogin";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if the passwords match
    if ($password === $confirm_password) {
        // Check if the ID is already in use
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 0) {
            // Insert the user into the database
            $sql = "INSERT INTO users (id, password) VALUES ('$id', '$password')";
            mysqli_query($conn, $sql);

            // Redirect to the login page
            $error_message = 'Registered Successfuly!';
            
            
        } else {
            // Display an error message
            $error_message = 'ID already in use!';
        }
    } else {
        // Display an error message
        $error_message = 'Passwords do not match!';
    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&family=Ubuntu&display=swap" rel="stylesheet">

    <!--css style sheet--> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-rrT2eJ/jfT+tydZW0fc+aYyH9XxO1JjzF+8J0WUZJ6LwP6RmLcM/X+IwlO9XzGVatxmvQ2Qr+NCqic+rWyG7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <h1 style="margin-top: 20px;">Register</h1>
    <?php if (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form style="margin-top: 35px;" method="POST">
        <label>ID:</label>
        <input type="text" name="id" required>
        <br>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <br>
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <br>
        <br>
        <button type="submit">Register</button>
    </form>
    
    <p style="margin-top: 5%; text-align:center;">Already have an account? <a href="login.php">Log in here</a></p>
</body>
</html>

<?php
mysqli_close($conn);
?>