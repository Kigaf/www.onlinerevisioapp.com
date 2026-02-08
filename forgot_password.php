<?php
$db = new SQLite3('database.sqlite');

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username'];

    // Check if username exists
    $stmt = $db->prepare('SELECT * FROM students WHERE username=:username');
    $stmt->bindValue(':username',$username);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if($result){
        echo "Your password is: <strong>".$result['password']."</strong><br>";
        echo "<a href='index.html'>Back to Login</a>";
    } else {
        echo "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password - Online Revision App</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Forgot Password</h2>
<form method="post">
    <input type="text" name="username" placeholder="Enter Username" required><br>
    <button type="submit">Retrieve Password</button>
</form>
<a href="index.html">Back to Login</a>
</div>
</body>
</html>
