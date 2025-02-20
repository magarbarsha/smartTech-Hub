<?php
 include '../includes/config.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="../assets/css/dashboard_style.css">
    <style>
        /* General Reset and Body Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

          
     

        /* Content Area */
        .dashboard-content {
            margin-left: 270px;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ecf0f1;
        }

        /* Add Category Button */
        .add-category-btn {
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
            text-decoration:none;
        }

        .add-category-btn:hover {
            background-color: #2ecc71;
        }

        /* Pagination Styling */
        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #2980b9;
        }

        .pagination a.active {
            background-color: #1abc9c;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .dashboard-content {
                margin-left: 220px;
            }

            .add-category-btn {
                font-size: 16px;
            }
        }
    </style>
   </head>
<body>

 
   <?php include './adminsidenav.php' ?>

    <!-- Dashboard Content Section (Cards) -->
    <div class="dashboard-content">
    <h1>Manage Categories</h1>

<a href="categoryAdd.php" class="add-category-btn">+ Add Category</a>
<form action="" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search Categories" style="padding: 8px; width: 200px; font-size: 16px;">
        <button type="submit" style="padding: 8px 16px; font-size: 16px; background-color: #3498db; color: white; border: none; cursor: pointer;">Search</button>
    </form>
    <table>
        <tr>
        <th>SN</th>
        <th>category_name</th>
        </tr>
    
    <?php
 $records_per_page=1;
 $page = isset($_GET['page']) ? $_GET['page']: 1;
 $offset= ($page - 1 ) * $records_per_page;
 if(isset($_GET['search'])){
    $search=$_GET['search'];
    $total_records_query="SELECT COUNT(*) AS total from category WHERE category_name LIKE '%$search%'";
    $total_records_result=mysqli_query($conn,$total_records_query);
    $total_r = mysqli_fetch_assoc($total_records_result);
    $total_records = $total_r['total'];

    $sql="SELECT * FROM category WHERE category_name LIKE '%$search%' LIMIT $records_per_page OFFSET $offset";
 }else{

$total_records_query="SELECT COUNT(*) AS total from category";
$total_records_result=mysqli_query($conn,$total_records_query);
$total_r = mysqli_fetch_assoc($total_records_result);
$total_records = $total_r['total'];



    $sql="SELECT * FROM category LIMIT $records_per_page OFFSET $offset";
    $counter = $offset;
}
    $res=mysqli_query($conn, $sql);
    $num=mysqli_num_rows($res);
    $counter= 0;
    if($num > 0){
        while($row=mysqli_fetch_assoc($res)){
            ?>
           <tr>
        <td><?php echo ++$counter ?></td>
        <td><?php echo $row['category_name']?></td>
        <td><a href="./categoryedit.php?id=<?php echo $row['id'] ?>">Edit</a>
        <br>
        <a href="./categorydelete.php?id=<?php echo $row['id'] ?>">Delete</a>
        </td>
    </tr> 
      <?php  }
    
    }
    ?>
    </table>
    <div style="margin-top: 20px;">
      <?php
      $total_pages=ceil($total_records / $records_per_page);
      if($total_pages > 1){
      for($i=1;$i<=$total_pages;$i++){
echo "<a href='?page=$i' style='margin-right:5px; padding:5px; border: 1px solid black; text-decoration:none; ";
echo $i==$page ? "background-color: lightgray;" : "";
echo "'>$i</a>";
      }
   }
?>
    </div>


 <script src="../assets/js/dashboard_script.js"></script>
</body>
</html>
