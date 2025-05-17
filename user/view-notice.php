<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');

// Ensure the database table has the new column for NoticeFile
try {
    $alterQuery = "ALTER TABLE tblnotice ADD COLUMN NoticeFile VARCHAR(255) DEFAULT NULL";
    $dbh->exec($alterQuery);
} catch (PDOException $e) {
    // Handle exception if the column already exists or any other error
}

if (strlen($_SESSION['sturecmsstuid']==0)) {
  header('location:logout.php');
  } else{
   
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>AlumniDocs || View Notice</title>
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
              <h3 class="page-title"> View Notice </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> View Notice</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    
                    <?php
$stuclass = $_SESSION['stuclass'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$limit = 5; // Number of notices per page
$offset = ($page - 1) * $limit; // Calculate offset

// Query to get the total number of notices
$total_query = "SELECT COUNT(*) as total FROM tblnotice WHERE FIND_IN_SET(:stuclass, ClassId)";
$total_stmt = $dbh->prepare($total_query);
$total_stmt->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
$total_stmt->execute();
$total_result = $total_stmt->fetch(PDO::FETCH_OBJ);
$total_notices = $total_result->total;

// Calculate total pages
$total_pages = ceil($total_notices / $limit);

// Query to fetch notices for the current page
$sql = "SELECT * FROM tblnotice WHERE FIND_IN_SET(:stuclass, ClassId) ORDER BY CreationDate DESC LIMIT :limit OFFSET :offset";
$query = $dbh->prepare($sql);
$query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
$query->bindParam(':limit', $limit, PDO::PARAM_INT);
$query->bindParam(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<div class="card-body">
<script>
    // Function to delete a notice from the view
    function deleteNotice(noticeId) {
        const noticeElement = document.getElementById('notice-' + noticeId);
        if (noticeElement) {
            noticeElement.remove(); // Remove the notice element from the DOM
            alert('Notice removed from the view.');
        }
    }
</script>
<style>
    .notice-item {
        cursor: pointer;
    }
</style>
<div class="card-body"></div>
    <?php
    if ($query->rowCount() > 0) {
        foreach ($results as $row) {
    ?>
            <div class="alert alert-info" role="alert" id="notice-<?php echo $row->ID; ?>">
                <h4 class="alert-heading">Notice</h4>
                <p><strong>Notice Announced Date:</strong> <?php echo $row->CreationDate; ?></p>
                <p><strong>Notice Title:</strong> <?php echo $row->NoticeTitle; ?></p>
                <hr>
                <p class="mb-0"><strong>Message:</strong> <?php echo $row->NoticeMsg; ?></p>
                <?php if (!empty($row->NoticeFile)) { ?>
                    <p><strong>Attached File:</strong> <a href="<?php echo htmlentities($row->NoticeFile); ?>" target="_blank">Download</a></p>
                <?php } else { ?>
                    <p><strong>Attached File:</strong> No file uploaded.</p>
                <?php } ?>
                <a href="view-single-notice.php?nid=<?php echo htmlentities($row->ID); ?>" class="btn btn-primary btn-xs">View</a>
                <button onclick="deleteNotice(<?php echo $row->ID; ?>)" class="btn btn-danger btn-xs">Delete</button>
            </div>
    <?php
        }
    } else {
    ?>
        <div class="alert alert-danger" role="alert">
            No Notice Found
        </div>
    <?php } ?>
</div>

<!-- Pagination -->
<nav>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>
<!-- Pagination -->

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