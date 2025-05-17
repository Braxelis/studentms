<!-- filepath: c:\xampp\htdocs\Student-Management-System-PHP-V2.0\Student-Management-System-PHP-V2.0\studentms\user\chat.php -->
<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid'] == 0)) {
    header('location:logout.php');
} else {
    $student_id = $_SESSION['sturecmsstuid'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Chat</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .chat-box {
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message .student {
            font-weight: bold;
        }
        .chat-message .timestamp {
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Student Chat </h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="chat-box" id="chat-box">
                                        <!-- Chat messages will be loaded here -->
                                    </div>
                                    <form id="chat-form">
                                        <div class="form-group">
                                            <textarea class="form-control" id="message" placeholder="Type your message..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script>
        // Load chat messages
        function loadChat() {
            fetch('load-chat.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('chat-box').innerHTML = data;
                    document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
                })
                .catch(error => console.error('Error loading chat:', error));
        }

        // Send chat message
        document.getElementById('chat-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const message = document.getElementById('message').value;
            fetch('send-chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `message=${encodeURIComponent(message)}`
            }).then(() => {
                document.getElementById('message').value = '';
                loadChat();
            });
        });

        // Refresh chat every 2 seconds
        setInterval(loadChat, 2000);
        loadChat();
    </script>
</body>
</html>