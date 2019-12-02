<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true||$_SESSION["utype"]!=0){
    header("location: homePage.php");
    exit;
}
require_once "config.php";
$sql="SELECT * FROM patient_details WHERE id=".$_SESSION['id'].";";
$result=$conn->query($sql);
$row=$result->fetch_assoc();
if($row["middlename"]!=""){
	$name=$row["firstname"]." ".$row["middlename"]." ".$row["lastname"];
}else{
	$name=$row["firstname"]." ".$row["lastname"];
}
$sqlapt="SELECT * FROM appointment_details WHERE (p_id=".$_SESSION["id"].") AND (id =".$_GET["apno"]." )";
$result2 = $conn->query($sqlapt);

if($result2->num_rows > 0){
	$row2=$result2->fetch_assoc();
}else{
	header("location:patientAppointments.php");
}

$sqldocq="SELECT firstname,lastname FROM doctor_details WHERE id='".$row2["d_id"]."';";
$docname = $conn->query($sqldocq);
$row3 = $docname->fetch_assoc();
$regdate=explode(" ",$row2["reg_date"]);

function changeDate($old){
	$arr=explode("-",$old);
	return $arr[2]."-".$arr[1]."-".$arr[0];
}

?>

<html>
<head>
<title>Print Appointment Details | Online Appointment | Defence Research & Development Organisation DRDO
</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css_1.css">
<link rel="icon" type="image/png" href="logo-image.png" >
</head>
<body > 	
<script src="jquery-3.4.1.js"></script>
<style type="text/css">

	body{
		-webkit-print-color-adjust: exact;
	}
	#dashBar{
		
		height:45px;
		width:1220px;
		margin-top:95px;
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
		width:199px;
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
		height:500px;
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
		height:1400px;
		width:1000px;
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
		padding:5px;
	}
	td{
		padding:20px;
		padding-left:0px;
		padding-right:100px;
		border-bottom:1px solid grey;
		font-family:Arial;
	}
	
	#aptdata{
		margin:75px;
		
	}
	#printrec{
		background-image:linear-gradient(to bottom, #224775,#1795CC);
		border-radius:5px;
		border:1px solid #224775;
		text-decoration:none;
		padding:0px 21px;
		font-size:20px;
		color:white;
		
	}
	#cancelrec{
		background-image:linear-gradient(to bottom, grey,#E6E6E6);
		border:1px solid grey;
		border-radius:5px;
		text-decoration:none;
		padding:0px 12.5px;
		font-size:20px;
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
				<img src="mod.png" id="logo4" >
			</a>
		</div>
		<div style="padding-top:50px;">
			<div style="margin-right:325px;font-family:Arial;"><h2>Print Appointment Details</h2></div>
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
		<div id="aptdata" align=center>
			<h3> Appointment Reciept</h3>
			<table>
			
			<tr><td>Appointment Number:</td><td>INMAS-<?php echo $row2["id"]?></td></tr>
			<tr><td>Patient Name:</td><td><?php echo $name?></td></tr>
			<tr><td>Patient Contact No.:</td><td><?php echo $row["contact"]?></td></tr>
			<tr><td>Patient Email:</td><td><?php echo $row["email"]?></td></tr>
			<tr><td>Patient UHID:</td><td><?php echo $row["UHID"]?></td></tr>
			<tr><td>Date Of Transcript</td><td><?php echo changeDate($regdate[0])?></td></tr>
			<tr><td>Doctor Name:</td><td><?php echo "Dr. ".$row3["firstname"]." ".$row3["lastname"]?></td></tr>
			<tr><td>Department Name:</td><td><?php echo $row2["dname"]?></td></tr>
			<tr><td>Date Of Appointment:</td><td><?php echo changeDate($row2["apt_date"])?></td></tr>
			<?php if($row["dob"]!=""){
				echo "<tr><td>Date Of Birth:</td><td>".changeDate($row['dob'])."</td></tr>";
			}
			if($row["bloodgroup"]!=""){
				echo "<tr><td>Blood Group :</td><td>".$row['bloodgroup']."</td></tr>";
			}
				
			?>
			
			</table>		
		</div>
		<div align=center>
			<a id="cancelrec" href="patientAppointments.php" style="margin-top:50px;" >Cancel</a>
			<a id="printrec" href="javascript:window.print()" style="margin-top:50px;" >Print</a>
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