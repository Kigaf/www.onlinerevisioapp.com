<?php
session_start();
$db = new SQLite3('database.sqlite');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare('SELECT * FROM students WHERE username=:username AND password=:password');
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if($result){
        $_SESSION['student_id'] = $result['id'];
        $_SESSION['name'] = $result['name'];
    } else {
        echo "Invalid login!";
        exit;
    }
} elseif(!isset($_SESSION['student_id'])){
    header('Location: index.html');
    exit;
}

// Fetch subjects
$subjects = $db->query('SELECT * FROM subjects');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Welcome, <?php echo $_SESSION['name']; ?></h2>
<h3>Select a subject to start revision:</h3>
<ul>
<?php while($sub = $subjects->fetchArray()): ?>
    <li><a href="quiz.php?subject_id=<?php echo $sub['id']; ?>"><?php echo $sub['name']; ?></a></li>
<?php endwhile; ?>
</ul>
<a href="results.php">View My Results</a>
</body>
</html>
