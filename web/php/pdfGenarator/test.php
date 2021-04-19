<?php
    include("../connection.php");
    $login_id=$_GET['id'];
    $sql="select * from tbl_log where login_id='$login_id' and type='profile' ORDER BY log_id desc";
    $result=mysqli_query($con,$sql);
    while($row=mysqli_fetch_array($result))
    {
        echo "
                <tr> 
                    <td>".$row['date']."</td>
                    <td>".$row['time']."</td>
                    <td>".$row['dis']."<br>&nbsp;</td>
                </tr>
            ";
    }
?>