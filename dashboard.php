<?php
session_start();

// check if the user is logged in
if(!isset($_SESSION["id"])) {
  header("Location: login.php"); // redirect to login page if not logged in
  exit;
}

// logout function
function logout() {
  session_destroy(); // destroy session data
  header("Location: login.php"); // redirect to login page after logout
  exit;
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
    <h1 style="margin-top: 20px;">Welcome to Dashboard!</h1><br><br>
    <p>You are logged in as <?php echo $_SESSION["id"]; ?></p><br><br>
    <form method="post">
      <button type="submit" name="logout">Logout</button>
      
    </form>
    <br><br>
    <a href="change_password.php" style="width: 100px;"><button>Change Password</button></a>

    
    
    <?php
    // check if logout button is pressed
    if(isset($_POST["logout"])) {
      logout(); // call the logout function
    }
    ?>
  
</body>
</html>