<?php
session_start();
include '../includes/config.php';

// Check if the admin is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Access denied! Please log in as an admin.'); window.location.href='../login.php';</script>";
    exit();
}

// Fetch contact messages
$sql = "SELECT * FROM contact ORDER BY id DESC";
$res = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Feedback Messages</title>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.admin-container {
    width: 90%;
    max-width: 1000px;
    margin: 50px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

thead {
    background-color: #2575fc;
    color: white;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

td {
    color: #444;
}

.delete-btn {
    background-color: #ff4757;
    color: white;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.delete-btn:hover {
    background-color: #e84118;
}

@media (max-width: 768px) {
    .admin-container {
        width: 95%;
        padding: 15px;
    }
}
</style>
</head>
<body>

<?php include 'adminsidenav.php'; ?>

<div class="admin-container">
    <h2>Feedback Messages</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                <td>
                    <form action="feedbackdelete.php" method="post">
                        <input type="hidden" name="message_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="delete-btn" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="../assets/js/dashboard_script.js"></script>

</body>
</html>
