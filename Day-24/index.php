<?php
include 'db.php';

// Delete record if ID is set in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php"); // Refresh page after delete
    exit();
}

// Get all records
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 40px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this student?")) {
                window.location.href = "index.php?id=" + id;
            }
        }
    </script>
</head>
<body>

    <h2 style="text-align:center;">Student Records</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['email']); ?></td>
            <td><?= htmlspecialchars($row['course']); ?></td>
            <td><button class="delete-btn" onclick="confirmDelete(<?= $row['id']; ?>)">Delete</button></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
