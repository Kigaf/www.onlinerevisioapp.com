<?php
session_start();
if(!isset($_SESSION['student_id'])){
    header('Location: index.html'); exit;
}

$db = new SQLite3('database.sqlite');
$subject_id = $_GET['subject_id'];
$questions = $db->query("SELECT * FROM questions WHERE subject_id=$subject_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Quiz</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Quiz</h2>
<form action="results.php" method="post">
<input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
<?php $i=1; while($q=$questions->fetchArray()): ?>
    <p><?php echo $i++.'. '.$q['question']; ?></p>
    <input type="radio" name="q<?php echo $q['id']; ?>" value="A" required> <?php echo $q['option_a']; ?><br>
    <input type="radio" name="q<?php echo $q['id']; ?>" value="B"> <?php echo $q['option_b']; ?><br>
    <input type="radio" name="q<?php echo $q['id']; ?>" value="C"> <?php echo $q['option_c']; ?><br>
    <input type="radio" name="q<?php echo $q['id']; ?>" value="D"> <?php echo $q['option_d']; ?><br>
<?php endwhile; ?>
<button type="submit">Submit Quiz</button>
</form>
</body>
</html>
