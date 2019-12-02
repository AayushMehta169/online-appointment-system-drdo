<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true||$_SESSION["utype"]!=0){
    header("location: homePage.php");
    exit;
}
require_once "config.php";
$pd_err=$date_err=$doctor_available_err="";
$success_mess="";
function revdate($var){
	$ar1=explode("-",$var);
	$ar2=$ar1[0]."-".$ar1[1]."-".$ar1[2];
	return $ar2;
}

function limitdat($var){
	$ar1=explode("-",$var);
	$ar2=[];
	$ar2[0]=intval($ar1[0]);
	$ar2[2]=intval($ar1[2]);
	$ar2[1]=intval($ar1[1]);
	
	if($ar2[1]==12){
		$ar2[1]=1;
		$ar2[0]=$ar2[0]+1;
	}elseif($ar2[1]==1&&$ar2[2]>28){
		$ar2[1]=3;
		$ar2[2]=1;
	}else{$ar2[1]=$ar2[1]+1;}
	$ans=strval($ar2[0])."-".strval($ar2[1])."-".strval($ar2[2]);
	return $ans;
}
$curdate=date("Y-m-d");
$limdate=limitdat($curdate);
if($_SERVER["REQUEST_METHOD"] == "POST"){
	//check if patient_doctor record exists
	$sql1="SELECT * FROM patient_doctor WHERE p_id=".$_SESSION["id"]." AND dname='".$_POST["Department"]."';";
	$result=$conn->query($sql1);
	if($result == TRUE){
		if($result->num_rows ==1){
			$row=$result->fetch_assoc();
			
			//Check if date selected is correct or not 
			$date=$_POST["appDate"];
			$d1=revdate($date);
			if($d1<$curdate||$d1>$limdate){
				$date_err="Invalid Date Selected";
			}else{
				//check if doctor available or not
				$sqlcheck="SELECT * FROM appointment_details where d_id=".$row["d_id"]." AND apt_date='".$d1."';";
				$sqldoc="SELECT dlimit FROM doctor_details where id=".$row["d_id"];
				$result2=$conn->query($sqlcheck);
				$result3=$conn->query($sqldoc);
				$row3=$result3->fetch_assoc();
				if($result2->num_rows<$row3["dlimit"])
				{
					//update appointment table
					$sqlfinal="INSERT INTO appointment_details(p_id, d_id,dname,apt_date) VALUES (".$_SESSION["id"].",".$row["d_id"].",'".$row["dname"]."','".$_POST["appDate"]."');";
					if($resultfinal=$conn->query($sqlfinal)){
						$success_mess="Appointment Made Successfully.";
					}
					
				}else{$doctor_available_err="Doctor is not available for that day.";}
				
			}
		}
		else{
			$pd_err="You Must First Select Your Doctor For This Department.";
		}
	}
	
	//check if doctor is available in that date
	
	
}

?>
<html>
<head>
<title>Make Appointment | Patient | Defence Research & Development Organisation DRDO
</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css_1.css">
<link rel="icon" type="image/png" href="logo-image.png" >
</head>
<body> 	
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
	.bookingSect{
	
	font-family: Arial;
	width:1220px;
	

	}
	#selDep{
	font-family:Arial;
	font-size:25px;
	float:left;
	margin-left:170px;

	}
	#selDate{
	font-family:Arial;
	font-size:25px;
	float:left ;
	margin-left:110px;

	}
	#depDrop{
	height:25px;
	font-size:20px;
	border: 1px solid grey;
	border-radius:5px;
	}
	#checkAvail{
		width:450px;
		height:40px;
		background-image:linear-gradient(to bottom, #224775,#1795CC);
		color:white;
		border:none;
		margin-top:20px;
		font-size:20px;
		position:relative;
		left:0px;
	}
	[type="date"] {
	background:#fff url(calendar.png)  97% 50% no-repeat ;
    }
	[type="date"]::-webkit-inner-spin-button {
	display: none;
		}
	[type="date"]::-webkit-calendar-picker-indicator {
	opacity: 0;
	}
	input {
	border: 1px solid #c4c4c4;
	border-radius: 5px;
	background-color: #fff;
	padding: 3px 5px;
	box-shadow: inset 0 3px 6px rgba(0,0,0,0.1);
	width: 190px;
	}
	#inmasImg{
	height:400px;
	width:1220px;
	}
	#mainBody{
		height:auto;
		padding-bottom:150px;
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
			<div style="margin-right:325px; font-family:Arial;"><h1>Make Appointment</h1></div>
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
			
			<a class="mitem" href="selectDept.php">
				&#9658 Select Doctor
			</a>
			<a class="mitem" href="resetPassword.php">
				&#9658 Change Password
			</a>
		</div>
		<div> 
			<img src="Capture1.png" id="inmasImg">
		</div>
		<div class=" bookingSect">
			<h1 style="margin-top:50px; margin-left:50px;">Book An Appointment:</h1><br><br>
			<form method="POST">
				<div id="selDep"><b>Select Department:</b> 
					<select name="Department" id="depDrop">
						<option value="Thyroid-Clinic">Thyroid Clinic</option>
						<option value="NMR-Center">NMR Centre</option>
						<option value="dep3">Department 3</option>
						<option value="dep4">Department 4</option>
					</select>
				</div>
				<div id="selDate">
					<b>Select Date:</b> 
					<input type="date" style="height:25px; font-size:20px;" name="appDate">
					
					<p style="color:red;"><br>*Appointment date should be <br>within a month of booking date</p>
				</div>
				<input type="submit" id="checkAvail" value="Check Availibility">
			</form>
		</div>
		
		<div id="errorDiv">
			<div id="closeErr1">
				<div id="errorTop">
					<a style="position:relative;top:4px;margin-left:20px;"><b><?php if($success_mess!=""){echo "Success!!";}else{ echo "Error!!";}?></b></a>
					<img src="close.png" id="closeErr">
				</div>
				<a style="margin:auto;">
				<?php if($success_mess!=""){echo $success_mess;}else{echo $date_err."\n".$pd_err."\n".$doctor_available_err;}?>
				
				</a>
			</div>
		</div>
		
	</div>
</div>		
<script type="text/javascript">
	
window.onload=errorDiv();
function errorDiv(){
	var val="<?php echo $date_err.$pd_err.$doctor_available_err;?>";
	var val3="<?php echo $success_mess;?>";
	if(val!=""||val3!=""){
		$("#errorDiv").css("display","inline");
	}
}
$("#closeErr").click(function(){
	$("#errorDiv").css("display","none");
	
})	
	
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