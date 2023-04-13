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
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if the old password is correct
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if ($row['password'] === $old_password) {
            // Check if the new password and the confirm password match
            if ($new_password === $confirm_password) {
                // Update the password in the database
                $sql = "UPDATE users SET password='$new_password' WHERE id='$id'";
                mysqli_query($conn, $sql);

                // Display a success message
                $success_message = 'Password changed successfully';
            } else {
                // Display an error message
                $error_message = 'New password and confirm password do not match';
            }
        } else {
            // Display an error message
            $error_message = 'Incorrect old password';
        }
    } else {
        // Display an error message
        $error_message = 'User not found';
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Change Password</title>

    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&family=Ubuntu&display=swap" rel="stylesheet">

    <!--css style sheet--> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-rrT2eJ/jfT+tydZW0fc+aYyH9XxO1JjzF+8J0WUZJ6LwP6RmLcM/X+IwlO9XzGVatxmvQ2Qr+NCqic+rWyG7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <h1 style="margin-top: 20px;">Change Password</h1>
    <?php if (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>
    
    <?php if (isset($success_message)): ?>
        <p class="success-message"><?php echo $success_message; ?></p>
                <div class="center">
            <button type="button" onclick="location.href='dashboard.php'">Go to Dashboard</button>
        </div>
    <?php endif; ?>
    <form style="margin-top: 35px;" method="POST">
        <label>ID number:</label>
        <input type="text" name="id" required>
        <br>
        <label>Old Password:</label>
        <input type="password" name="old_password" required>
        <br>
        <label>New Password:</label>
        <input type="password" name="new_password" required>
        <br>
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <br>
        <button type="submit">Change Password</button>
    </form>
</body>
</html>

<?php
mysqli_close($conn);
?>