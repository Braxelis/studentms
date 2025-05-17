<!-- filepath: c:\xampp\htdocs\Student-Management-System-PHP-V2.0\Student-Management-System-PHP-V2.0\studentms\admin\gestion-groupes.php -->
<form method="POST" action="">
    <label for="group_name">Group Name:</label>
    <input type="text" id="group_name" name="group_name" required>
    
    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>
    
    <button type="submit" name="create_group">Create Group</button>
</form>

<?php
if (isset($_POST['create_group'])) {
    $group_name = $_POST['group_name'];
    $description = $_POST['description'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "etudiant");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert group into database
    $stmt = $conn->prepare("INSERT INTO groups (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $group_name, $description);

    if ($stmt->execute()) {
        echo "Group created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<form method="POST" action="">
    <label for="group_id">Select Group:</label>
    <select id="group_id" name="group_id">
        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "student_management_system");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch groups from the database
        $result = $conn->query("SELECT id, name FROM groups");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select>

    <label for="student_id">Select Student:</label>
    <select id="student_id" name="student_id">
        <?php
        // Fetch students from the database
        $result = $conn->query("SELECT id, name FROM students");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        $conn->close();
        ?>
    </select>

    <button type="submit" name="assign_student">Assign Student</button>
</form>

<?php
if (isset($_POST['assign_student'])) {
    $group_id = $_POST['group_id'];
    $student_id = $_POST['student_id'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "student_management_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO group_students (group_id, student_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $group_id, $student_id);

    if ($stmt->execute()) {
        echo "Student assigned to group successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

