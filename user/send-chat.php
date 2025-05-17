<!-- filepath: c:\xampp\htdocs\Student-Management-System-PHP-V2.0\Student-Management-System-PHP-V2.0\studentms\user\send-chat.php -->
<?php
session_start();
include('includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_SESSION['sturecmsstuid'];
    $message = $_POST['message'];

    if (!empty($message)) {
        $sql = "INSERT INTO tblchat (student_id, message) VALUES (:student_id, :message)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $query->bindParam(':message', $message, PDO::PARAM_STR);

        if ($query->execute()) {
            echo "Message sent successfully.";
        } else {
            echo "Failed to send message.";
        }
    } else {
        echo "Message cannot be empty.";
    }
}
?>

<script>
fetch('send-chat.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `message=${encodeURIComponent(message)}`
}).then(response => response.text())
  .then(data => {
      console.log(data); // Check if "Message sent successfully." is logged
      document.getElementById('message').value = '';
      loadChat();
  });
</script>