<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true||$_SESSION["utype"]!=0){
    header("location: homePage.php");
    exit;
}
require_once "config.php";
$sql="SELECT firstname , middlename , lastname FROM patient_details WHERE id=".$_SESSION['id'].";";
$result=$conn->query($sql);
$row=$result->fetch_assoc();
if($row["middlename"]!=""){
	$name=$row["firstname"]." ".$row["middlename"]." ".$row["lastname"];
}else{
	$name=$row["firstname"]." ".$row["lastname"];
}
$sqlapt="SELECT * FROM appointment_details WHERE p_id=".$_SESSION["id"]." ORDER by apt_date";
$result = $conn->query($sqlapt);
function printclick($nump){
	$_SESSION["printapt"]=$nump;
	header("printAppointmentDetails.php");
	
}
function changeDate($old){
	$arr=explode("-",$old);
	return $arr[2]."-".$arr[1]."-".$arr[0];
}
?>
<html>
<head>
<title>Patient Appointments | Online Appointment | Defence Research & Development Organisation DRDO
</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css_1.css">
<link rel="icon" type="image/png" href="logo-image.png" >
</head>
<body onload="startTime()"> 	
<script src="jquery-3.4.1.js"></script>
<style type="text/css">

	#dashBar{
		
		height:45px;
		width:1220px;
		margin-top:85px;
	}
	.dashButton{
		color:white;
		background-image:linear-gradient(#224775,#1795CC);
		text-decoration:none;
		float:left;
		padding:9px 20px;
		font-family:Arial;
		font-size:20px;
		border-right: 1px solid white;
		width:254px;
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
	#menuButton{
		width:45px;
		border-right:1px solid white;
		padding:0px;
		height:44px;
	}
	#menuDrop{
		position:absolute;
		background-color:#EEEEEE;
		height:500px;
		width:300px;
		border-bottom-left-radius:5px;
		border-bottom-right-radius:5px;
		box-shadow:inset 0px 0px 10px black;
		padding-top:10px;
		display:none;
	}
	.mitem{
		width:260px;
		margin-left:20px;
		margin-right:20px;
		border-top:2px solid #eee1e1;
		float:left;
		font-size:20px;
		font-family:Arial;
		padding-top:10px;
		padding-bottom:10px;
		color:#224775;
		text-decoration:none;
	}
	#patientDetails{
		float:left;
		color:#224775;
		margin:30px;
		font-size:20px;
		font-family:Arial;
	}
	#timer{
		float:right;
		color:#224775;
		margin:30px;
		font-size:20px;
		font-family:Arial;
	}
	#upcommingAppt{
		height:auto;
		padding-bottom:50px;
		width:900px;
		float:center;
		background-color:#FCFCFC;
		border:2px solid #FCF8FC;
		color:#5CACEE;
		border-radius:10px;
		margin-top:100px;
		font-family:Arial;
		box-shadow:1px 0px 20px black;
	}
	#mainBody{
		height:auto;
		padding-bottom:100px;
	}
	#apptButt{
		width:450px;
		height:40px;
		background-image:linear-gradient(#224775,#1795CC);
		color:white;
		border-radius:10px;
		border:none;
		margin-top:70px;
		position:relative;
		left:-60px;
		font-size:20px;
		cursor:pointer;
		box-shadow:1px 0px 20px black;
	}
	table{
		margin-top:20px;
		border:1px solid #1A71B8;
		color:#F74F4F;
		padding:5px;
		border-radius:5px;
	}
	td{
		border-radius:5px;
		border:1px solid #3E89D9;
		padding:5px;
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
				<img src="mod.png" id="logo4" >
			</a>
		</div>
		<div style="padding-top:50px;">
			<div style="margin-right:325px;font-family:Arial;"><h1>Patient Appointments</h1></div>
		</div>
		<div id="dashBar">
			<div class="dashButton" id="menuButton">
				<img src="menuButt.png" style="height:20px ;width:25px; margin-top:12.5px;">
			</div>
			<a href="patientLogin.php" id="homeButton" class="barButton dashButton">Home</a>
			
			<a href="patientAppointments.php" id="myappButton" class="barButton dashButton">My Appointments</a>
			
			<a href="patientEditProfile.php" id="editprofButton" class="barButton dashButton">Edit Profile</a>
			
			<a href="logout.php" id="loutButton" class="barButton dashButton">Logout</a>
			
		</div>
		<div id="menuDrop" align=left>
			<h2 align=center>Menu</h2>
			
			<a class="mitem" href="selectDoctor.php">
				&#9658 Select Doctor
			</a>
			<a class="mitem" href="resetPassword.php">
				&#9658 Change Password
			</a>
		</div>
		<img src="Capture1.png" style="width:100%;height:400px;">
		<div id="patientDetails">
			<div id="pname"><b>Welcome</b> <?php echo $name;?>,</div>
		</div>
		<div id="timer">Time: <span id="txt"></span></div>
		<div id="upcommingAppt">
			<div style="font-size:30px;margin-top:5px;" >All Appointments</div>
			<div >
			<table>
				<?php 
					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
							$sqldocq="SELECT firstname,lastname FROM doctor_details WHERE id='".$row["d_id"]."';";
							$docname = $conn->query($sqldocq);
							$row2 = $docname->fetch_assoc();
							echo "\n <tr><td><b>Department:</b></td><td> ".$row["dname"]."</td><td> <b>Doctor Name: </b></td><td>".$row2["firstname"]." ".$row2["lastname"]." </td><td> <b>Appointment Date: </b></td><td>".changeDate($row["apt_date"])."</td><td><a href='printAppointment.php?apno=".$row["id"]."'><img src='print_cmd.gif'> </a></td></tr>";
						}
					} else {
						echo "<tr><td><h2>No Current Appointments</h2></td></tr>";
					}
				?>
			</table>
			</div>
		</div>
		
		
	</div>
</div>		
<script type="text/javascript">
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
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
	$("#loutButton").css("background-image","linear-gradient(#2979FF,#2979FF)")},
	function(){
	$("#loutButton").css("background-image","linear-gradient(#224775,#1795CC)")}
	)
$("#editprofButton").hover(function(){
	$("#editprofButton").css("background-image","linear-gradient(#2979FF,#2979FF)")},
	function(){
	$("#editprofButton").css("background-image","linear-gradient(#224775,#1795CC)")}
	)
$("#homeButton").hover(function(){
	$("#homeButton").css("background-image","linear-gradient(#2979FF,#2979FF)")},
	function(){
	$("#homeButton").css("background-image","linear-gradient(#224775,#1795CC)")}
	)
$("#myappButton").hover(function(){
	$("#myappButton").css("background-image","linear-gradient(#2979FF,#2979FF)")},
	function(){
	$("#myappButton").css("background-image","linear-gradient(#224775,#1795CC)")}
	)
var mclick= false;
$("#menuButton").click(function(){
		
		if(!mclick){$("#menuDrop").css("display","block")}
		else{$("#menuDrop").css("display","none")}
		mclick=!mclick;
		})
$("#menuDrop").hover(function(){},
	function(){
	$("#menuDrop").css("display","none");
	mclick=!mclick;}
	)

$("#menuButton").hover(function(){
	$("#menuButton").css("background-image","linear-gradient(#2979FF,#2979FF)")},
	function(){
	$("#menuButton").css("background-image","linear-gradient(#224775,#1795CC)")}
	)
</script>
</body>
</html>