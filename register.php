<?php
$db = new SQLite3('database.sqlite');

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $class = $_POST['class'];

    // Insert student
    $stmt = $db->prepare('INSERT INTO students(username,password,name,class) VALUES(:username,:password,:name,:class)');
    $stmt->bindValue(':username',$username);
    $stmt->bindValue(':password',$password);
    $stmt->bindValue(':name',$name);
    $stmt->bindValue(':class',$class);

    if($stmt->execute()){
        echo "Registration successful! <a href='index.html'>Login here</a>";
    } else {
        echo "Error: Username may already exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - Online Revision App</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Student Registration</h2>
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="text" name="class" placeholder="Class (e.g. Form 1)" required><br>
    <button type="submit">Register</button>
</form>
<a href="index.html">Back to Login</a>
</div>
</body>
</html>
