<?php
$con=mysqli_connect("localhost","root","","find")or die("Couldn't connect to server");

$type=$_POST["type"];
$data=new \stdClass();
// $type='updateIMEI';

// ---------------- check vaild login ? ---------------------

    if($type=="signin"){
        $email = $_POST['email'];
        $password=$_POST['password'];
        
        $sql="select * from tbl_login where email='$email' and status=1";
        if($result=mysqli_query($con,$sql)){
            $row=mysqli_fetch_array($result);
            if(mysqli_num_rows($result)==1 && password_verify($password,$row['password'])){
                $data->value="valid";
                $data->login_id=$row['login_id'];
            }
            else{
                $data->value="incorrect";
                $data->login_id="";
            }
        }
        else{
            $data->value="querry error";
            $data->login_id="";
        }
        echo json_encode($data);
    }

// -------------------- registration  ---------------------


    if($type=='register')
    {
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        if(($name!="") && ($email!="") && ($password!="")){
            $password = password_hash($password,PASSWORD_DEFAULT); 
            $sql="select email from tbl_login where email='$email'";
            if(mysqli_num_rows(mysqli_query($con,$sql))==0){
                $sql="insert into tbl_login (email,password) values ('$email','$password')";
                mysqli_query($con,$sql);
                $login_id=mysqli_insert_id($con);
                $sql="insert into tbl_reg (login_id,name) values($login_id,'$name')";
                mysqli_query($con,$sql);
                $data->value="valid";
                $data->login_id="$login_id";
            }
            else{
                $data->value="Email already taken";
                $data->login_id="";
            }
        }
        else{
            $data->value="Fill up all fields !";
            $data->login_id="";
        }
        echo json_encode($data);
    }

// ---------------------- check imei ----------------
    
    if($type=='imeicheck'){
        $login_id=$_POST['login_id'];
        $imei=$_POST['imei'];
        $sql="select * from tbl_device where imei =$imei and login_id=$login_id";
        $res=mysqli_query($con,$sql);
        if(mysqli_num_rows($res)==0){
            $data->value="not_in_use";
        }
        else{
            $data->value="already_in_use";
        }
        echo json_encode($data);
    }

// ---------------------- update imei ----------------
    
if($type=='updateIMEI'){
    $login_id=$_POST['login_id'];
    $name=$_POST['name'];
    $imei=$_POST['imei'];
    $sql="select * from tbl_device where imei =$imei and login_id=$login_id";
    $res=mysqli_query($con,$sql);
    // echo  mysqli_num_rows($res);
    $time=date("h:i:s");
    if(mysqli_num_rows($res)==0){
        $sql="insert into tbl_device (login_id,name,type,imei,state,time,lat,lon) values($login_id,'$name','mobile','$imei','active','$time','0','0')";
        if(mysqli_query($con,$sql)){
            $data->value="done";
        }
        else{
            echo "insertion failed";
        }
    }
    else{
        $data->value="already_in_use";
    }
    echo json_encode($data);
}

// ---------------------- update location ----------------
    
if($type=='updateloc'){
    $login_id=$_POST['login_id'];
    $imei=$_POST['imei'];
    $lon=$_POST['lon'];
    $lat=$_POST['lat'];
    $time=date("h:i:s");
    // $data->value="lost";
    $sql="update tbl_device set lon='$lon',lat='$lat',time='$time' where imei='$imei' and login_id=$login_id";
    if(mysqli_query($con,$sql))
    {
        $sql="select state from tbl_device where imei='$imei' and login_id=$login_id";
        if($resilt=mysqli_query($con,$sql)){
            $row=mysqli_fetch_array($resilt);
            $data->value=$row['state'];
        }
    }
    else{
        $data->value="error";
    }
    echo json_encode($data);
}

?>
