<?php
session_start();
if(isset($_SESSION['id'])){
    $login_id=$_SESSION['id'];
    include("connection.php");
    include("log/log.php");

    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    $image0=$_FILES['propic']["name"];
    if($image0!=''){
        $file_path0='../images/'.$image0;
        move_uploaded_file($_FILES['propic']["tmp_name"],$file_path0);
        

        $sql="select * from tbl_pic where login_id=$login_id";
        $result=mysqli_query($con,$sql);
        if(mysqli_num_rows($result)==0){
            $sql="insert into tbl_pic (login_id,filename) VALUES ($login_id,'$image0')";
            mysqli_query($con,$sql);
            log_activity($con,$login_id,'profile','Profile image updated');// log data
            header("Location:mapview.php?message=Upload sucess");
        }
        else{
            $sql="update tbl_pic set filename='$image0' where login_id=$login_id";
            mysqli_query($con,$sql);
            log_activity($con,$login_id,'profile','Profile image updated');// log data
            header("Location:mapview.php?message=Update sucess");
        }
    }
    if($name!=''){
        $sql="update tbl_reg set name='$name' where login_id=$login_id";
        mysqli_query($con,$sql);
        log_activity($con,$login_id,'profile','Profile name changed');// log data
        header("Location:mapview.php?message=Update sucess");
        // header("Location:mapview.php?message=nill");
    }
    if($email!=''){
        $sql="update tbl_login set email='$email' where login_id=$login_id";
        mysqli_query($con,$sql);
        log_activity($con,$login_id,'profile','Profile Email changed');// log data
        header("Location:mapview.php?message=Update sucess");
        // header("Location:mapview.php?message=nill");
    }
    if($password!=''){
        $password=password_hash($password,PASSWORD_DEFAULT);
        $sql="update tbl_login set password='$password' where login_id=$login_id";
        log_activity($con,$login_id,'profile','Profile password changed using profile updation settings');// log data
        mysqli_query($con,$sql);
        header("Location:logout.php");
        // header("Location:mapview.php?message=nill");
    }

}
else{
    header("location:../index.php");
}


?>