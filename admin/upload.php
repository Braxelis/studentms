<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['upload'])) {
    // Directory to store uploaded files
    $target_dir = "uploads/";
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;

    // Check if the file is valid
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        // Save file URL to the database
        $file_url = $target_file;
        $sql = "INSERT INTO uploaded_files (file_name, file_url) VALUES (:file_name, :file_url)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':file_name', $file_name, PDO::PARAM_STR);
        $query->bindParam(':file_url', $file_url, PDO::PARAM_STR);

        if ($query->execute()) {
            echo "<script>alert('File uploaded successfully');</script>";
        } else {
            echo "<script>alert('Failed to save file URL to the database');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload file');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload File</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container-scroller">
        <!-- Include Header -->
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <!-- Include Sidebar -->
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h3 class="page-title"> Upload File </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Upload File</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Upload Form -->
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Upload a File</h4>
                                    <form action="upload.php" method="POST" enctype="multipart/form-data" class="forms-sample">
                                        <div class="form-group">
                                            <label for="file">Choose File</label>
                                            <input type="file" class="form-control" name="file" id="file" required>
                                        </div>
                                        <button type="submit" name="upload" class="btn btn-primary mr-2">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Uploaded Files Table -->
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Uploaded Files</h4>
                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>File Name</th>
                                                    <th>File URL</th>
                                                    <th>Upload Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM uploaded_files ORDER BY upload_date DESC";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                        echo "<tr>
                                                                <td>" . htmlentities($cnt) . "</td>
                                                                <td>" . htmlentities($row->file_name) . "</td>
                                                                <td><a href='" . htmlentities($row->file_url) . "' target='_blank'>View File</a></td>
                                                                <td>" . htmlentities($row->upload_date) . "</td>
                                                              </tr>";
                                                        $cnt++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4' style='color:red;'>No files uploaded yet.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Include Footer -->
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="./vendors/chart.js/Chart.min.js"></script>
    <script src="./vendors/moment/moment.min.js"></script>
    <script src="./vendors/daterangepicker/daterangepicker.js"></script>
    <script src="./vendors/chartist/chartist.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="./js/dashboard.js"></script>
</body>
</html>