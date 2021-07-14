<?php

use function PHPSTORM_META\type;

$con=mysqli_connect("localhost","root","","find")or die("Couldn't connect to server");

// $type=$_POST["type"];
$data=new \stdClass();
$type='Paringoffline';

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


    if($type=='register'){
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
    
    // if($type=='imeicheck'){
    //     $login_id=$_POST['login_id'];
    //     $imei=$_POST['imei'];
    //     $sql="select * from tbl_device where imei =$imei and login_id=$login_id";
    //     $res=mysqli_query($con,$sql);
    //     if(mysqli_num_rows($res)==0){
    //         $data->value="not_in_use";
            
    //     }
    //     else{
    //         $data->value="already_in_use";
    //     }
    //     echo json_encode($data);
    // }

// ---------------------- update imei ----------------
    
if($type=='updateIMEI'){
    $login_id=$_POST['login_id'];
    $name=$_POST['name'];
    $imei=$_POST['imei'];
    $sql="select * from tbl_device where imei =$imei and login_id=$login_id";
    $res=mysqli_query($con,$sql);
    // echo  mysqli_num_rows($res);
    $time=date("h:i:s y-m-d");
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
    $hash = $_POST['hashcode'];
    $offid = $_POST['offlineID'];
    $time=date("h:i:s y-m-d");
    // $data->value="lost";
    $sql="update tbl_device set lon='$lon',lat='$lat',time='$time' where imei='$imei' and login_id=$login_id";
    if(mysqli_query($con,$sql))
    {
        $sql="select state from tbl_device where imei='$imei' and login_id=$login_id";
        if($resilt=mysqli_query($con,$sql)){
            $row=mysqli_fetch_array($resilt);
            
            $sqlofflinedevice = "select * from tbl_device where hashcode='$hash' or oflineid='$offid'";
            $resiltlistofdevices=mysqli_query($con,$sqlofflinedevice);
            if(mysqli_num_rows($resiltlistofdevices) == 1){
                
                $rowdevices=mysqli_fetch_array($resiltlistofdevices);
                
                $deviceeeId = $rowdevices['device_id'];
                $sqlupdateoter="update tbl_device set lon='$lon',lat='$lat',time='$time' where device_id =$deviceeeId";
                if(mysqli_query($con,$sqlupdateoter)){
                    $data->device="one device found and updated -- ".$rowdevices['name'];
                }
                else{
                    $data->device="one device found updatein error ".$rowdevices['name'];
                }
                
                // $data->device="one device found ".$rowdevices['name'];
            }
            $data->value=$row['state'];
        }
    }
    else{
        $data->value="error";
        $data->device="";
    }
    echo json_encode($data);
}

//--- check email ------ 
if($type=="confirm_email"){
    $email = $_POST["email"];
    $sql="SELECT * FROM tbl_login where email = '$email' ";
    $result=mysqli_query($con,$sql);

    if(mysqli_num_rows($result)>0){
        // $data->value='yes';
        $row=mysqli_fetch_array($result);
        $login=$row['login_id'];
        $sql="SELECT * FROM tbl_otp where login_id = '$login' ";

        $result=mysqli_query($con,$sql);
        $date=date('y-m-d h:i:s');
        $otp_data=rand(100000,999999);

        $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 60) as $k) $rand .= $seed[$k];

        if(mysqli_num_rows($result)>0){
            $sql="update tbl_otp set otp_time='$date',otp_data='$otp_data',otp_random='$rand' where login_id=$login";
        }
        else{
            $sql="insert into tbl_otp (login_id,otp_time,otp_data,otp_random) values ($login,'$date','$otp_data','$rand')";
        }
        mysqli_query($con,$sql);
        $data->value='yes';
        // sentmail($otp_data,$rand,$email);
    }
    else{
        $data->value='no';
    }
    echo json_encode($data);
}


//--------------- register device --------------
if($type == "registerdevice"){
    // echo("regiater deive");
    $loginid=$_POST['loginid'];
    $imei=$_POST['imei'];
    $devicename=$_POST['devicename'];
    $devicetype=$_POST['devicetype'];//mobile
    $lat=$_POST['lat'];
    $lon=$_POST['lon'];
    $datetime =date('h:i:s y-m-d');

    $removedSpecialCharDevicename = str_replace( array( '\'', '"',',' , ';', '<', '>' ), '', $devicename);

    $sql="insert into tbl_device (login_id,name,type,imei,state,time,lat,lon) values('$loginid','$removedSpecialCharDevicename','mobile','$imei','active','$datetime','$lat','$lon')";
    if(mysqli_query($con,$sql)){
        // echo "done";
        $device_id=mysqli_insert_id($con);
        $data->value = "done";
        $data->device_id = $device_id;
    }
    else{
        // echo "failed";
        $data->value = "failed";
        $data->device_id = "";
    }
    echo json_encode($data);

}

//----------------delete device form list when logout from mobile ----------

if($type == "deleteDevice"){
    $device_id=$_POST['deviceId'];
    $sql="delete from tbl_device WHERE device_id=$device_id";
    if(mysqli_query($con,$sql)){
        // echo "deleted";
        $data->value = "deleted";
    }
    else{
        // echo "failed";
        $data->value = "failed";
    }
    echo json_encode($data);
}

//-------------- get user details ----------------
if($type == "userdetails"){
    $login_id = $_POST['login_id'];
    $sql="SELECT * FROM tbl_reg where login_id = $login_id";
    if($result=mysqli_query($con,$sql)){
        $row = mysqli_fetch_array($result);
        $sql="SELECT * FROM tbl_pic where login_id = $login_id";
        if($result=mysqli_query($con,$sql)){
            if(mysqli_num_rows($result)>0){
                $row1=mysqli_fetch_array($result);
                $data->image = $row1['filename'];
            }
            else{$data->image = "user.png";}
        }
        
        $data->value= 'true';
        $data->name = $row['name'];
    }
    else{
        $data->value = 'false';
    }
    echo json_encode($data);
}

// ----------- list all devices and location details --------------

if($type == "listdevice"){
    $login_id=$_POST['loginId'];
    $sql="select * from tbl_device where login_id = $login_id";
    if($result=mysqli_query($con,$sql)){
        if(mysqli_num_rows($result)>0){
            $device = array();
            while($row = mysqli_fetch_array($result)){
               
                $actualTime= new DateTime(date('h:i:s y-m-d'));
                $difference = $actualTime->diff(new DateTime(date($row['time'])));
                $years=$difference->y;
                $month=$difference->m;
                $day=$difference->d;
                $hours=$difference->h;
                $min=$difference->i;

                $datetimeDifference='';
                if($years == 0 && $month == 0 && $day ==0 && $hours ==0 && $min > 0 ){
                    $datetimeDifference = $min." min";
                }
                elseif($years == 0 && $month == 0 && $day ==0 && $hours > 0 ){
                    $datetimeDifference = $hours.':'.$min." hrs";
                }
                elseif($years == 0 && $month == 0 && $day > 0 ){
                    $datetimeDifference = $day.' days '.$hours.' hrs';
                }
                elseif($years == 0 && $month > 0 ){
                    $datetimeDifference = $month.' months '.$day.' day';
                }
                elseif($years > 0 ){
                    $datetimeDifference = $years.' year '.$month.' months';
                }
                else{
                    $datetimeDifference = 'Now';
                }

                $temp=array("deviceID"=>$row['device_id'],"name"=>$row['name'],"type"=>$row['type'],"lat"=>$row['lat'],"lon"=>$row['lon'],"time"=>$datetimeDifference,"state"=>$row['state']);
                array_push($device,$temp);
                // echo $difference->days;

            }

        $data->value = 'devices';
        $data->devices = $device;
        //    echo ($device);  
        }
        else{
            $data->value = 'noDevice';
            $data->devices = '';
            // echo "no devices found!";
        }
    }
    else{
        $data->value = 'Error';
        $data->devices = '';
        // echo 'some error occured';
    }
    echo json_encode($data);
}

// http://localhost/find/web/php/find_api.php?loginid=11&imei=%2212345678901234567891233222222222222123123123123123123123123%22&devicename=%22testdevice%22&type=%22mobile%22&lat=%2212,0000%22&lon=%2213,000%22&status=%22active%22

//-----------------bluetooth paring----------
if($type == "Paringoffline"){
    
    // $hashcode=$_POST['hashcode'];
    // $offlineID=$_POST['offlineID'];
    // $lat=$_POST['lat'];
    // $lon=$_POST['lon'];
    $datetime =date('h:i:s y-m-d');
    $hashcode="";
    $offlineID="jasdkahskjhhhh76817239127398";
    $lat=9.53092978193696;
    $lon=76.73130051859147;

    $sql = "SELECT * FROM tbl_device WHERE state = 'paring'"; //have to set status to paring client
    if($result=mysqli_query($con,$sql)){
        if(mysqli_num_rows($result) > 0){
            while ($row=mysqli_fetch_array($result)){
                $paringtime = $row['paringtime'];
                $lattitude = $row['lat'];
                $longitude = $row['lon'];
                $actualTime = new DateTime(date('h:i:s y-m-d'));
                $difference = $actualTime->diff(new DateTime(date($row['paringtime'])));
                // echo "latitude : ".$lattitude."\nlongitude : ".$longitude;
                
                    // echo "update user location";
                    if ($difference->days == 0 && $difference->h == 0 && $difference->i < 30 && $lattitude - 0.04 < $lat && $lattitude + 0.04 > $lat && $longitude - 0.04 < $lon && $longitude + 0.04 > $lon){
                        
                        $devicee_id=$row['device_id'];
                        $sqlofflinedevice="update tbl_device set lon='$lon',lat='$lat',time='$datetime',state='active',hashcode='$hashcode',oflineid='$offlineID' where device_id='$devicee_id'";
                        if(mysqli_query($con,$sqlofflinedevice)){
                            echo "time correct lattitude correct";
                            echo "updating db";
                        }
                        // echo "time correct lattitude correct";
                        // echo "updating db";

                            // $data->value = 'true';
                            // $data->device = $row['name'];
                            // $data->deviceID = $row['device_id'];

                        // else{
                        //     $data->value = 'false';
                        //     $data->device = $row['name'];
                        //     $data->deviceID = $row['device_id'];
                        // }
                     
                    }
                else{
                    echo "no device<br>";
                    echo date('h:i:s y-m-d');
                    echo "lon: ".$lattitude;
                    echo "\lat: ".$longitude;
                    // $data->value = 'false';
                    // $data->device = '';
                    // $data->deviceID = '';
                }
            }
        
        }
        else{
            // echo "no paring device found";
            $data->value = 'false';
            $data->device = '';
            $data->deviceID = '';
        }
    }
    else{
        echo ('query error');
    }
    echo json_encode($data);
    
}

// ------------- set listning mode --------- 
if($type == "setListningmode"){
    $deviceID=$_POST['deviceID'];
    $datetime =date('h:i:s y-m-d');
    $sql = "update tbl_device set state='paring', paringtime='$datetime' WHERE device_id = $deviceID"; //have to set status to paring client
    if(mysqli_query($con,$sql)){
        $data->value = 'true';
    }
    else{
        $data->value = 'false';
    }
    echo json_encode($data);
}

?>