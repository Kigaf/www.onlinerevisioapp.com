<?php
session_start();
if(!isset($_SESSION['student_id'])){
    header('Location: index.html'); exit;
}

$db = new SQLite3('database.sqlite');

if($_SERVER['REQUEST_METHOD']=='POST'){
    $subject_id = $_POST['subject_id'];
    $score = 0;

    foreach($_POST as $key=>$answer){
        if(strpos($key,'q')===0){
            $qid = str_replace('q','',$key);
            $correct = $db->querySingle("SELECT correct_option FROM questions WHERE id=$qid");
            if($answer==$correct) $score++;
        }
    }

    // Store score
    $stmt = $db->prepare('INSERT INTO results(student_id, subject_id, score, date_taken) VALUES(:sid,:sub,:score,:date)');
    $stmt->bindValue(':sid', $_SESSION['student_id']);
    $stmt->bindValue(':sub', $subject_id);
    $stmt->bindValue(':score', $score);
    $stmt->bindValue(':date', date('Y-m-d'));
    $stmt->execute();
} 

// Fetch latest results
$results = $db->query("SELECT subjects.name AS subject, score, date_taken FROM results INNER JOIN subjects ON results.subject_id=subjects.id WHERE student_id=".$_SESSION['student_id']." ORDER BY date_taken DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Quiz Results</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Quiz Results</h2>
<table border="1">
<tr><th>Subject</th><th>Score</th><th>Date Taken</th></tr>
<?php while($r=$results->fetchArray()): ?>
<tr>
<td><?php echo $r['subject']; ?></td>
<td><?php echo $r['score']; ?></td>
<td><?php echo $r['date_taken']; ?></td>
</tr>
<?php endwhile; ?>
</table>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
