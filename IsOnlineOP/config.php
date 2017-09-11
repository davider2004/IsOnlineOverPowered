<?php
$serverIP = "isonline.ramondettidavide.com"; // insert here your server url

// SOME FUNCTIONS -- DO NOT TOUCH //
function getCheck(){
  if($_SESSION['websiteURL'] && $_SESSION['websiteProtocol'] && $serverIP){
    continue;
  }else{
    exit("<h1><font color=red><b>ERROR</b></font></h1>");
  }
}
