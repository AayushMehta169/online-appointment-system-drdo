<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true||$_SESSION["utype"]!=0){
    header("location: homePage.php");
    exit;
}
?>
<html>
<head>
<title>Patient Homepage | Online Appointment | Defence Research & Development Organisation DRDO
</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css_1.css">
<link rel="icon" type="image/png" href="logo-image.png" >
</head>
<body> 	
<script src="jquery-3.4.1.js"></script>
<style type="text/css">

	#dashBar{
		background-color:#224775;
		height:45px;
		width:1220px;
		margin-top:85px;
	}
	.dashButton{
		color:white;
		text-decoration:none;
		float:left;
		padding:10px 20px;
		font-family:Arial;
		font-size:20px;
		border-right: 1px solid white;
		width:265.5px;
		cursor:pointer;
	}
	#homeButton{
		padding-top:12px;
		padding-left:20px;
		padding-right:20px;
	}
	#myappButton{
		padding-top:12px;
		padding-left:20px;
		padding-right:20px;
	}
	#editprofButton{
		padding-top:12px;
		padding-left:20px;
		padding-right:20px;
	}
	#loutButton{
		padding-top:12px;
		padding-left:15px;	
		border-right:none;
	}
	.barButton{
		text-decoration:none;
		color:white;
	}
</style>
<div id="toolBar">

<a id="printcmd" href="javascript:window.print()"><img src="print_cmd.gif"></a>
<a class="hovGlow" id="decSize">A-</a>
<a class="hovGlow" id="resSize">A</a>
<a class="hovGlow" id="incSize">A+</a>
<a class="hovGlow" id="contact" href="https://www.drdo.gov.in/drdo/English/index.jsp?pg=contact.jsp">Contact Us</a>
<a class="hovGlow" id="feedback"href="https://www.drdo.gov.in/drdo/English/index.jsp?pg=public.jsp">Feedback</a>

</div>
<div align=center>
	<div id="mainBody" >
		<div id="logobar">
	
			<a id="drdoLogo" href="https://www.drdo.gov.in/drdo/English/index.jsp?pg=homebody.jsp">
				<img src="logo-image.png" id="logo1">
				<img src="drdo-home2.jpg" id="logo2">
				<img src="drdo-home1.jpg" id="logo3">
			</a>

			<a id="modLogo" href="https://mod.gov.in/">
				<img src="mod.png" id="logo4">
			</a>
		</div>
		<div style="padding-top:50px;">
			<div style="margin-right:325px;"><h1>Patient Homepage</h1></div>
		</div>
		<div id="dashBar">
			<div class="dashButton" id="homeButton">
				<a href="welcome.php" class="barButton">Home</a>
			</div>
			<div class="dashButton" id="myappButton">
				My Appointments
			</div>
			<div class="dashButton" id="editprofButton">
				Edit Profile
			</div>
			<div class="dashButton" id="loutButton" >
				<a href="logout.php" class="barButton">Logout</a>
			</div>
		</div>
	</div>
		
	<script type="text/javascript">
$("#incSize").hover(function(){
	$("#incSize").css("color","#FA925B")},
	function(){
	$("#incSize").css("color","white")}
	)
$("#drdoLogo").hover(function(){
	$("#logo2").css("display","none")
	$("#logo3").css("display","inline")
	},
	function(){
	$("#logo2").css("display","inline")
	$("#logo3").css("display","none")
	}
	)
$("#incSize").click(function(){
		var currentSize = $('p').css('font-size');
		//alert(currentSize);
		if(currentSize>="22px")
		{alert("Woah!! Slow down there Chief!!")}
		else{
		var currentSize = parseFloat(currentSize)*1.2;
		$('p').css('font-size', currentSize)};})
		
$("#decSize").click(function(){
		var currentSize = $('p').css('font-size');
		if(currentSize<="10px"){
		alert("Even Senor Chang can't read that.");}
		else{
		var currentSize = parseFloat(currentSize)/1.2;
		$('p').css('font-size', currentSize);}})
$("#resSize").click(function(){
		$('p').css('font-size', "18px");})
$("#decSize").hover(function(){
	$("#decSize").css("color","#FA925B")},
	function(){
	$("#decSize").css("color","white")}
	)
$("#resSize").hover(function(){
	$("#resSize").css("color","#FA925B")},
	function(){
	$("#resSize").css("color","white")}
	)
$("#contact").hover(function(){
	$("#contact").css("color","#FA925B")},
	function(){
	$("#contact").css("color","white")}
	)
$("#feedback").hover(function(){
	$("#feedback").css("color","#FA925B")},
	function(){
	$("#feedback").css("color","white")}
	)
$("#loutButton").hover(function(){
	$("#loutButton").css("background-color","#2979FF")},
	function(){
	$("#loutButton").css("background-color","#224775")}
	)
$("#editprofButton").hover(function(){
	$("#editprofButton").css("background-color","#2979FF")},
	function(){
	$("#editprofButton").css("background-color","#224775")}
	)
$("#homeButton").hover(function(){
	$("#homeButton").css("background-color","#2979FF")},
	function(){
	$("#homeButton").css("background-color","#224775")}
	)
$("#myappButton").hover(function(){
	$("#myappButton").css("background-color","#2979FF")},
	function(){
	$("#myappButton").css("background-color","#224775")}
	)
</script>
</body>
</html>