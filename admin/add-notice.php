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
 $classids=implode(',', $_POST['classid']); // Convert array to comma-separated string
 $notmsg=$_POST['notmsg'];
 // Handle file upload
 $file_path = null;
 if (!empty($_FILES['noticefile']['name'])) {
    $target_dir = "uploads/notices/";
    $file_name = time() . "_" . basename($_FILES["noticefile"]["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allow only image file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo '<script>alert("Only JPG, JPEG, PNG, and GIF files are allowed.");</script>';
        exit;
    }

    // Create the directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Move the uploaded file
    if (move_uploaded_file($_FILES["noticefile"]["tmp_name"], $target_file)) {
        $file_path = $target_file;
    } else {
        echo '<script>alert("Failed to upload file.");</script>';
        exit;
    }
 }

 // Insert notice into the database
 $sql = "INSERT INTO tblnotice (NoticeTitle, ClassId, NoticeMsg, NoticeFile) VALUES (:nottitle, :classids, :notmsg, :file_path)";
 $query = $dbh->prepare($sql);
 $query->bindParam(':nottitle', $nottitle, PDO::PARAM_STR);
 $query->bindParam(':classids', $classids, PDO::PARAM_STR);
 $query->bindParam(':notmsg', $notmsg, PDO::PARAM_STR);
 $query->bindParam(':file_path', $file_path, PDO::PARAM_STR);
 $query->execute();

 echo '<script>alert("Notice has been added for the selected classes.")</script>';
 echo "<script>window.location.href ='add-notice.php'</script>";
}
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>AlumniDocs || Add Notice</title>
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
                        <label for="exampleInputName1">Notice Title</label>
                        <input type="text" name="nottitle" value="" class="form-control" required='true'>
                      </div>
                     
                      <div class="form-group">
                        <label for="exampleInputEmail3">Notice For</label>
                        <select name="classid[]" class="form-control select2" multiple="multiple" required>
                          <option value="">Select Class</option>
                         <?php 

$sql2 = "SELECT * FROM tblclass";
$query2 = $dbh->prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->ID);?>"><?php echo htmlentities($row1->ClassName);?> <?php echo htmlentities($row1->Section);?></option>
 <?php } ?> 
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Notice Message</label>
                        <textarea name="notmsg" value="" class="form-control" required='true'></textarea>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputFile">Attach File (Image or PDF)</label>
                        <input type="file" name="noticefile" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                      </div>
                   
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                     
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <!-- End custom js for this page -->
  </body>
</html><?php }  ?>