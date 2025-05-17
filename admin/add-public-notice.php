<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   if(isset($_POST['submit']))
  {
 $nottitle=$_POST['nottitle'];

 $notmsg=$_POST['notmsg'];
 
 // Handle image upload
 $image_path = null;
 if (!empty($_FILES['noticeimage']['name'])) {
     $target_dir = "uploads/notices/";
     $image_name = basename($_FILES["noticeimage"]["name"]);
     $target_file = $target_dir . time() . "_" . $image_name; // Add timestamp to avoid duplicate names

     // Create the directory if it doesn't exist
     if (!is_dir($target_dir)) {
         mkdir($target_dir, 0755, true);
     }

     // Move the uploaded file
     if (move_uploaded_file($_FILES["noticeimage"]["tmp_name"], $target_file)) {
         $image_path = $target_file;
     } else {
         echo '<script>alert("Failed to upload image.");</script>';
     }
 }

 // Insert notice into the database
 $sql = "INSERT INTO tblpublicnotice (NoticeTitle, NoticeMessage, NoticeImage) VALUES (:nottitle, :notmsg, :noticeimage)";
 $query = $dbh->prepare($sql);
 $query->bindParam(':nottitle', $nottitle, PDO::PARAM_STR);
 $query->bindParam(':notmsg', $notmsg, PDO::PARAM_STR);
 $query->bindParam(':noticeimage', $image_path, PDO::PARAM_STR);

 if ($query->execute()) {
     echo '<script>alert("Notice has been added.");</script>';
     echo "<script>window.location.href ='add-public-notice.php'</script>";
 } else {
     echo '<script>alert("Something went wrong. Please try again.");</script>';
 }
}
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|| Add Notice</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
    
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Add Notice </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Add Notice</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Add Notice</h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="nottitle">Notice Title</label>
                        <input type="text" name="nottitle" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label for="notmsg">Notice Message</label>
                        <textarea name="notmsg" class="form-control" required></textarea>
                      </div>
                      <div class="form-group">
                        <label for="noticeimage">Upload Image</label>
                        <input type="file" name="noticeimage" class="form-control" accept=".jpg,.jpeg,.png">
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add Notice</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         <?php include_once('includes/footer.php');?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html><?php }  ?>