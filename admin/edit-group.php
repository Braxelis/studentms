<!-- filepath: c:\xampp\htdocs\Student-Management-System-PHP-V2.0\Student-Management-System-PHP-V2.0\studentms\admin\edit-group.php -->
<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['update_group'])) {
        $group_id = $_POST['group_id'];
        $group_name = $_POST['group_name'];
        $description = $_POST['description'];

        // Update group details in the database
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Group</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Edit Group</h2>
        <form method="POST">
            <input type="hidden" name="group_id" value="<?php echo htmlentities($result->id); ?>">
            <div class="mb-3">
                <label for="group_name" class="form-label">Group Name:</label>
                <input type="text" class="form-control" name="group_name" id="group_name" value="<?php echo htmlentities($result->name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" name="description" id="description" rows="3"><?php echo htmlentities($result->description); ?></textarea>
            </div>
            <button type="submit" name="update_group" class="btn btn-success">Update Group</button>
            <a href="manage-groups.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php } ?>