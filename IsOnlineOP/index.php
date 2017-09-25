<!doctype html>
<html>
<head>
    <title>IsOnline OverPowered v2</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
    body {
        background-color: #f0f0f2;
        margin: 0;
        padding: 0;
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        
    }
    div {
        width: 600px;
        margin: 5em auto;
        padding: 50px;
        background-color: #fff;
        border-radius: 1em;
    }
    a:link, a:visited {
        color: #38488f;
        text-decoration: none;
    }
    @media (max-width: 700px) {
        body {
            background-color: #fff;
        }
        div {
            width: auto;
            margin: 0 auto;
            border-radius: 0;
            padding: 1em;
        }
    }
    </style>    
</head>

<body>
<div>
    <center>
		<?php
session_start();
include("config.php");

if($_POST['submit']){
  $websiteURL = $_POST['websiteURL'];
  $websiteProtocol = $_POST['websiteProtocol'];
  
  $_SESSION['websiteURL'] = $websiteURL;
  $_SESSION['websiteProtocol'] = $websiteProtocol;
  
  $link = $websiteProtocol.".//".$websiteURL;
  
    if(getCheck()){
	  continue;
  }else{
	  exit();
  }
  
    echo "<h1>IsOnlineOP v1 - Testing...</h1>"
  echo "<p>We are testing the website <b>". $websiteURL ."</b>... Please wait for a while...";
  echo "<img src=img/loading.gif>";
  
  // FIRST TEST - FSOCKET
	fSocket( $websiteURL, $host, $port, $waitTimeoutInSeconds );

  // SECOND TEST - CURL
       if (isDomainAvailible($link)){ 
               $curl = "ok";
       }else{
               $curl = "no";
       }
       //returns true, if domain is availible, false if not
		// function isDomainAvaible() is in config.php file. To get the decrypted string contact me.
    // THIRD TEST - VISIT
$ch = curl_init();
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
curl_close($ch);
if ($output) {
  $visit="ok";
}else{
  $visit="no";
		// FOURTH TEST - SOCKET
		$url = $websiteURL;
  $host = $url; 
  $port = 80;  
  $waitTimeoutInSeconds = 1; 
  if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
     $socket = "ok"; 
  } else {
   $socket = "no";
  } 
  fclose($fp);
  
  $_SESSION['testfin'] = "true";
  $_SESSION['fsocket'] = $fsocket;
  $_SESSION['curl'] = $curl;
  $_SESSION['visit'] = $visit;
  $_SESSION['socket'] = $socket;
  
  header("Refresh: 5.5; URL=?t=1");
}
}
	
if ($_SESSION['testfin'] == "true"){
	// GET BACK ALL THE INFORMATIONS FROM THE SESSIONS
	$fsocket = $_SESSION['fsocket'];
	$curl = $_SESSION['curl'];
	$visit = $_SESSION['visit'];
	$socket = $_SESSION['socket'];
	
	// WEBSITE IS ONLINE OR NOT? LET'S CALCULATE!
	$online_point = 0;
	$offline_point = 0;
	
	if ($fsocket == "ok"){
		$online_point = $online_point+1;
	}else{
		$offline_point = $offline_point+1;
	}
	
	if ($curl == "ok"){
		$online_point = $online_point+1;
	}else{
		$offline_point = $offline_point+1;
	}
	
	if ($visit == "ok"){
		$online_point = $online_point+1;
	}else{
		$offline_point = $offline_point+1;
	}
	
	if ($socket == "ok"){
		$online_point = $online_point+1;
	}else{
		$offline_point = $offline_point+1;
	}
	
	if ($offline_point > $online_point){
		$status = "offline";
	}else{
		$status = "online";
	}
	
	$messages = array(
		"offline" => "<font color=red><b>OFFLINE</b></font>",
		"online" => "<font color=green><b>ONLINE</b></font>",
		"ok" => "<font color=green><b>OK</b></font>",
		"no" => "<font color=red><b>FAILED</b></font>"
	);
	
	echo "<h1>IsOnlineOP - Test Result</h1>";
	echo "<p>Here are the results for the test of <b>". $_SESSION['websiteURL'] ."</b>";
	echo "<br>"
	echo "<h6>Test results</h6>";
	echo "<p>FSocket: <b>". $messages[$fsocket] ."</b></p>";
	echo "<p>CURL: <b>". $messages[$curl] ."</b></p>";
	echo "<p>Visit: <b>". $messages[$visit] ."</b></p>";
	echo "<p>Socket: <b>". $messages[$socket] ."</b></p>";
	echo "<br>";
	echo "<h6>Whois</h6>";
	whois($_SESSION['websiteURL']);
	echo "(<a href=http://who.is/whois/". $_SESSION['websiteURL'] ." target=_blank>Full whois</a>)";
	echo "<br>"
	echo "<h2>YOUR WEBSITE IS ". $messages[$status] ."</h2>";
	echo "<br>";
	echo "<script src=js/printfriendly.js></script>";
	
	unset($_SESSION['testfin']);
}

if (!$_POST['submit'] and !$_SESSION['testfin']) {
	echo "<h1>IsOnlineOP - Start test</h1>";
	echo "<form method=post action=?a=1>";
	echo "<p>Website protocol (HTTPS or HTTP): <input type=text name=websiteProtocol id=websiteProtocol></p>";
	echo "<p>Website URL (eg. ramondettidavide.com): <input type=text name=websiteURL id=websiteURL></p>";
	echo "<p><input type=submit value=Test it! name=submit id=submit></p>";
}
?>
	<br>
	<p><i>Created by <a href="http://ramondettidavide.com/" target="_blank">RamondettiDavide</a></i></p>
	<p><i><a href="https://github.com/davider2004/IsOnlineOverPowered" target="_blank">View on Github</a></i></p>
    </center>
</div>
</body>
</html>

