<?php
    $sql=mysqli_connect("mysql.site4now.net","a7cc8e_dapoet1","123456aA@","db_a7cc8e_dapoet1");
    $status_update;
    if(isset($_REQUEST['status'])){
        $id=$_REQUEST['id'];
        $status_update=$_REQUEST['status'];
        $req="UPDATE don_hang SET tinh_trang='$status_update' WHERE ma_don=$id";
        $sql->query($req);
    }
/****************************************************************************************/ 
header("location: don_hang.php"); 
?>