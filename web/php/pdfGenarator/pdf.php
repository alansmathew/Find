<?php
session_start();
require __DIR__.'/pdf/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
if(isset($_SESSION['id'])){
    include("../connection.php");
    $login_id=$_SESSION['id'];

    $html2pdf = new Html2Pdf();

    $c = curl_init("http://localhost/Find/web/php/pdfGenarator/test.php?id=$login_id");
    // $c = curl_init("https://alansmathew.000webhostapp.com/php/pdfGenarator/test.php?id=$login_id");
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($c);

    if (curl_error($c))
        die(curl_error($c));

    curl_close($c);

$html2pdf->writeHTML($html);
if($_GET['from']=='view'){
    $html2pdf->output("Find_log.pdf");
}
elseif($_GET['from']=='download'){
    $html2pdf->output("Find_log.pdf","D");
}
// $html2pdf->output("Find_log.pdf","D");// to download pdf 
//$html2pdf->output("Find_log.pdf"); //to view in next page as pdf 

}
else{
    header("location:../../index.php");
}
?>