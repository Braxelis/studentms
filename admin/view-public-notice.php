<!-- filepath: c:\xampp\htdocs\Student-Management-System-PHP-V2.0\Student-Management-System-PHP-V2.0\studentms\admin\view-public-notice.php -->
<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['viewid'])) {
        $notice_id = intval($_GET['viewid']);
        $sql = "SELECT * FROM tblpublicnotice WHERE ID = :notice_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':notice_id', $notice_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Public Notice</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container-scroller">
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> View Public Notice </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Public Notice</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Notice Details</h4>
                                    <?php if ($result) { ?>
                                        <p><strong>Title:</strong> <?php echo htmlentities($result->NoticeTitle); ?></p>
                                        <p><strong>Message:</strong> <?php echo htmlentities($result->NoticeMessage); ?></p>
                                        <p><strong>Date:</strong> <?php echo htmlentities($result->CreationDate); ?></p>
                                        <?php if (!empty($result->NoticeImage)) { ?>
                                            <p><strong>Image:</strong></p>
                                            <img src="<?php echo htmlentities($result->NoticeImage); ?>" alt="Notice Image" style="max-width: 100%; height: auto;">
                                        <?php } else { ?>
                                            <p><strong>Image:</strong> No image uploaded.</p>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <p style="color:red;">Notice not found.</p>
                                    <?php } ?>
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
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
</body>
</html>