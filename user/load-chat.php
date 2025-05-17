<!-- filepath: c:\xampp\htdocs\Student-Management-System-PHP-V2.0\Student-Management-System-PHP-V2.0\studentms\user\load-chat.php -->
<?php
session_start();
include('includes/dbconnection.php');

$sql = "SELECT c.message, c.timestamp, s.StudentName 
        FROM tblchat c 
        JOIN tblstudent s ON c.student_id = s.ID 
        ORDER BY c.timestamp ASC";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $row) {
        echo "<div class='chat-message'>
                <span class='student'>" . htmlentities($row->StudentName) . ":</span>
                <span class='message'>" . htmlentities($row->message) . "</span>
                <span class='timestamp'>(" . htmlentities($row->timestamp) . ")</span>
              </div>";
    }
} else {
    echo "<p>No messages yet.</p>";
}
?>

<script>
console.log('Loading chat...');
loadChat();
</script>