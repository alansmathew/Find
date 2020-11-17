<?php
session_start();
if(isset($_SESSION['id'])){
    $login_id=$_SESSION['id'];
    include("connection.php");

    $image0=$_FILES['propic']["name"];
    $file_path0='../images/'.$image0;
    move_uploaded_file($_FILES['propic']["tmp_name"],$file_path0);
    

    $sql="select * from tbl_pic where login_id=$login_id";
    $result=mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==0){
        $sql="insert into tbl_pic (login_id,filename) VALUES ($login_id,'$image0')";
        mysqli_query($con,$sql);
        header("Location:mapview.php?message=Upload sucess");
    }
    else{
        $sql="update tbl_pic set filename='$image0' where login_id=$login_id";
        mysqli_query($con,$sql);
        header("Location:mapview.php?message=Upload sucess");
    }
}
else{
    header("location:../index.php");
}


?>