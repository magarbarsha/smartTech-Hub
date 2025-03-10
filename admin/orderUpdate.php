<?php
include '../includes/config.php';
if(isset($_POST['update'])){
    $order_id = $_POST['order_id'];
 $order_status = $_POST['order_status'];
 $sql="UPDATE orders1 SET order_status='$order_status' WHERE id=$order_id";
 $res=mysqli_query($conn, $sql);
 if($res){
    echo "<script>alert('updated successfully'); window.location.href='./orders.php'</script>";
 }
 else{
    echo "<script>alert('update failed'); window.location.href='./orders.php'</script>";
 }
}
?>