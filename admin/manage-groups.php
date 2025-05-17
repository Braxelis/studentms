<!-- filepath: c:\xampp\htdocs\Student-Management-System-PHP-V2.0\Student-Management-System-PHP-V2.0\studentms\admin\manage-groups.php -->
<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['add_group'])) {
        $group_name = $_POST['group_name'];
        $description = $_POST['description'];

        $sql = "INSERT INTO groups (name, description) VALUES (:group_name, :description)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':group_name', $group_name, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->execute();

        echo "<script>alert('Group added successfully');</script>";
    }

    if (isset($_POST['update_group'])) {
        $group_id = $_POST['group_id'];
        $group_name = $_POST['group_name'];
        $description = $_POST['description'];

        $sql = "UPDATE groups SET name = :group_name, description = :description WHERE id = :group_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':group_name', $group_name, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':group_id', $group_id, PDO::PARAM_INT);
        $query->execute();

        echo "<script>alert('Group updated successfully');</script>";
        echo "<script>window.location.href='manage-groups.php';</script>";
    }

    if (isset($_GET['id'])) {
        $group_id = intval($_GET['id']);
        $sql = "SELECT * FROM groups WHERE id = :group_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':group_id', $group_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
    }

    if (isset($_POST['assign_student'])) {
        $group_id = $_POST['group_id'];
        $student_id = $_POST['student_id'];

        // Check if the student exists
        $checkStudent = "SELECT ID FROM tblstudent WHERE ID = :student_id";
        $checkQuery = $dbh->prepare($checkStudent);
        $checkQuery->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $checkQuery->execute();

        if ($checkQuery->rowCount() > 0) {
            // Insert into group_students table
            $sql = "INSERT INTO group_students (group_id, student_id) VALUES (:group_id, :student_id)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':group_id', $group_id, PDO::PARAM_INT);
            $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);

            if ($query->execute()) {
                echo "<script>alert('Student assigned to group successfully');</script>";
            } else {
                echo "<script>alert('Failed to assign student to group');</script>";
            }
        } else {
            echo "<script>alert('Invalid student selected');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Groups</title>
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
                        <h3 class="page-title"> Manage Groups </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Groups</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Add Group Form -->
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Add Group</h4>
                                    <form method="POST" class="forms-sample">
                                        <div class="form-group">
                                            <label for="group_name">Group Name</label>
                                            <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Enter Group Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="4" placeholder="Enter Description"></textarea>
                                        </div>
                                        <button type="submit" name="add_group" class="btn btn-primary mr-2">Add Group</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Assign Student to Group Form -->
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Assign Student to Group</h4>
                                    <form method="POST" class="forms-sample">
                                        <!-- Select Group -->
                                        <div class="form-group">
                                            <label for="group_id">Select Group</label>
                                            <select class="form-control" name="group_id" id="group_id" required>
                                                <option value="">Select Group</option>
                                                <?php
                                                $sql = "SELECT id, name FROM groups";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $groups = $query->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($groups as $group) {
                                                    echo "<option value='" . htmlentities($group->id) . "'>" . htmlentities($group->name) . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Select Student -->
                                        <div class="form-group">
                                            <label for="student_id">Select Student</label>
                                            <select class="form-control" name="student_id" id="student_id" required>
                                                <option value="">Select Student</option>
                                                <?php
                                                $sql = "SELECT ID, StudentName FROM tblstudent";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $students = $query->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($students as $student) {
                                                    echo "<option value='" . htmlentities($student->ID) . "'>" . htmlentities($student->StudentName) . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" name="assign_student" class="btn btn-primary mr-2">Assign Student</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Existing Groups Table -->
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Existing Groups</h4>
                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Group Name</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM groups";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                        echo "<tr>
                                                            <td>" . htmlentities($cnt) . "</td>
                                                            <td>" . htmlentities($row->name) . "</td>
                                                            <td>" . htmlentities($row->description) . "</td>
                                                            <td>
                                                                <a href='edit-group.php?id=" . htmlentities($row->id) . "' class='btn btn-info btn-xs'>Edit</a>
                                                                <a href='delete-group.php?id=" . htmlentities($row->id) . "' onclick=\"return confirm('Do you really want to delete this group?');\" class='btn btn-danger btn-xs'>Delete</a>
                                                            </td>
                                                        </tr>";
                                                        $cnt++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4' style='color:red;'>No Record Found</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Students in Groups Table -->
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Students in Groups</h4>
                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Group Name</th>
                                                    <th>Student Name</th>
                                                    <th>Student Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT 
                                                            gs.id AS group_student_id,
                                                            g.name AS group_name,
                                                            s.StudentName AS student_name,
                                                            s.StudentEmail AS student_email
                                                        FROM 
                                                            group_students gs
                                                        JOIN 
                                                            groups g ON gs.group_id = g.id
                                                        JOIN 
                                                            tblstudent s ON gs.student_id = s.ID";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                        echo "<tr>
                                                            <td>" . htmlentities($cnt) . "</td>
                                                            <td>" . htmlentities($row->group_name) . "</td>
                                                            <td>" . htmlentities($row->student_name) . "</td>
                                                            <td>" . htmlentities($row->student_email) . "</td>
                                                        </tr>";
                                                        $cnt++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4' style='color:red;'>No Record Found</td></tr>";
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
<?php } ?>