<!--

  __  __      _      _   _       _    __     __                        _      ____          _   _  U _____ u   ____    U _____ u 
U|' \/ '|uU  /"\  u | \ |"|  U  /"\  u\ \   /"/u      __        __ U  /"\  u / __"| u      |'| |'| \| ___"|/U |  _"\ u \| ___"|/ 
\| |\/| |/ \/ _ \/ <|  \| |>  \/ _ \/  \ \ / //       \"\      /"/  \/ _ \/ <\___ \/      /| |_| |\ |  _|"   \| |_) |/  |  _|"   
 | |  | |  / ___ \ U| |\  |u  / ___ \  /\ V /_,-.     /\ \ /\ / /\  / ___ \  u___) |      U|  _  |u | |___    |  _ <    | |___   
 |_|  |_| /_/   \_\ |_| \_|  /_/   \_\U  \_/-(_/     U  \ V  V /  U/_/   \_\ |____/>>      |_| |_|  |_____|   |_| \_\   |_____|  
<<,-,,-.   \\    >> ||   \\,-.\\    >>  //           .-,_\ /\ /_,-. \\    >>  )(  (__)     //   \\  <<   >>   //   \\_  <<   >>  
 (./  \.) (__)  (__)(_")  (_/(__)  (__)(__)           \_)-'  '-(_/ (__)  (__)(__)         (_") ("_)(__) (__) (__)  (__)(__) (__) 

-->

<!DOCTYPE html>
<html lang="en">
<head>
	<title>RMIT Cloud Computing Application 1</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#424242">

	<script src="https://kit.fontawesome.com/0db8c7f53e.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/app.css">

	<link rel="shortcut icon" href="https://img.icons8.com/material-outlined/48/000000/winter.png">

</head>
<body>

<div id="container">
	<?php
		if (isset($_REQUEST['showMessage']) && $_REQUEST['showMessage'] != '') {
			echo "<div class='php-message'>" . htmlspecialchars($_REQUEST['showMessage']) . "</div>";
		}
	?>