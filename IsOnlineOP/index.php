<?php
session_start();
include("config.php");

if($_POST['submit']){
  $websiteURL = $_POST['websiteURL'];
  $websiteProtocol = $_POST['websiteProtocol'];
  
  $_SESSION['websiteURL'] = $websiteURL;
  $_SESSION['websiteProtocol'] = $websiteProtocol;
  
  getCheck();
  
  $url = $_GET['url'];
$host = $url; 
$port = 80;  
$waitTimeoutInSeconds = 1; 
if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
   $result = "ok"; 
} else {
   $result = "no";
} 
fclose($fp);
