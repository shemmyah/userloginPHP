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

// Check if the user is already logged in
if (isset($_SESSION['id'])) {
    header("Location: dashboard.php"); // Redirect to the dashboard page if the user is already logged in
    exit();
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the ID and password are correct
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if ($row['password'] === ' ') {
            // Redirect the user to the password change page
            header("Location: change_password.php?id=$id");
            exit();
        } elseif ($row['password'] === $password) {
            // Set the session variables
            $_SESSION['id'] = $row['id'];
            $_SESSION['logged_in'] = true;

            // Redirect to the dashboard page
            header("Location: dashboard.php");
            exit();
        } else {
            // Display an error message
            $error_message = 'Incorrect ID number or password';
        }
    } else {
        // Display an error message
        $error_message = 'Incorrect ID number or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Login</title>
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
    
        <h1 style="margin-top: 20px;">USERLOGIN</h1>
        <form style="margin-top: 35px;" action="login.php" method="POST">
            
                <label for="id">ID Number:</label>
                <input type="text" id="id" name="id">
            <br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            
            <?php if(isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <br><br>
            <button type="submit">Login</button>
            <br><br>
        </form>
        <br><br>
        <a href="register.php"><button type ="register">Register</button></a>
        
        
    
</body>
</html>

<?php
mysqli_close($conn);
?>