<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   if(isset($_POST['submit']))
  {
 $hwtitle=$_POST['homeworkTitle'];
 $classid=$_POST['classid'];
 $hwdescription=$_POST['homeworkdescription'];
 $ldsubmission=$_POST['ldsubmission'];
 $hwid=intval($_GET['hwid']);
$sql="update  tblhomework set homeworkTitle=:hwtitle,classId=:classid,homeworkDescription=:hwdescription,lastDateofSubmission=:ldsubmission where id=:hwid";
$query=$dbh->prepare($sql);
$query->bindParam(':hwtitle',$hwtitle,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query->bindParam(':hwdescription',$hwdescription,PDO::PARAM_STR);
$query->bindParam(':ldsubmission',$ldsubmission,PDO::PARAM_STR);
$query->bindParam(':hwid',$hwid,PDO::PARAM_STR);
 $query->execute();

    echo '<script>alert("Homework has been added.")</script>';
echo "<script>window.location.href ='manage-homeworks.php'</script>";

}
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>AlumniDocs|| Add Documents</title>
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
              <h3 class="page-title">Edit Documents </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Edit Documents</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Edit Documents</h4>
<?php $hwid=intval($_GET['hwid']);
  $sql="SELECT tblclass.ID,tblclass.ClassName,tblclass.Section,tblhomework.homeworkTitle,tblhomework.postingDate,tblhomework.lastDateofSubmission,tblhomework.id as hwid,homeworkDescription,lastDateofSubmission from tblhomework join tblclass on tblclass.ID=tblhomework.classId where tblhomework.id=:hwid";
$query = $dbh -> prepare($sql);
$query->bindParam(':hwid',$hwid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
foreach($results as $row)
{               ?>  
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Documents Title</label>
                        <input type="text" name="homeworkTitle" value="<?php echo htmlentities($row->homeworkTitle);?>" class="form-control" required='true'>
                      </div>
                     
                      <div class="form-group">
                        <label for="exampleInputEmail3">Documents For</label>
                        <select  name="classid" class="form-control" required='true'>
                        <option value="<?php echo htmlentities($row->ID);?>"><?php echo htmlentities($row->ClassName);?> <?php echo htmlentities($row->Section);?></option>
                         <?php 

$sql2 = "SELECT * from    tblclass ";
$query2 = $dbh -> prepare($sql2);
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
                        <label for="exampleInputName1">Documents Description</label>
                        <textarea name="homeworkdescription"  class="form-control" required='true' rows="8"><?php echo htmlentities($row->homeworkDescription);?></textarea>
                      </div>
                   
      <div class="form-group">
                        <label for="exampleInputName1">Last Date of Submission</label>
                        <input type="date" name="ldsubmission" value="<?php echo htmlentities($row->lastDateofSubmission);?>" class="form-control" required='true'>
                      </div>
<?php } ?>

                      <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                     
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