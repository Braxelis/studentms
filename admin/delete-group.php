<!-- filepath: c:\xampp\htdocs\Student-Management-System-PHP-V2.0\Student-Management-System-PHP-V2.0\studentms\admin\delete-group.php -->
<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['id'])) {
        $group_id = intval($_GET['id']);

        // Delete the group from the database
        $sql = "DELETE FROM groups WHERE id = :group_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':group_id', $group_id, PDO::PARAM_INT);

        if ($query->execute()) {
            echo "<script>alert('Group deleted successfully');</script>";
        } else {
            echo "<script>alert('Failed to delete the group');</script>";
        }

        echo "<script>window.location.href='manage-groups.php';</script>";
    }
}
?>

<script>
    // jQuery for delete confirmation
    $(document).on('click', '.delete-btn', function () {
        const groupId = $(this).data('id');
        if (confirm('Are you sure you want to delete this group?')) {
            window.location.href = 'delete-group.php?id=' + groupId;
        }
    });
</script>