<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true||$_SESSION["utype"]!=1){
    header("location: homePage.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$err = "";
$success_mess = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"&& !empty($_POST["oldpass"])){
	
	//Check old password
	if(empty(trim($_POST["oldpass"]))){
		$err = "Enter Old Password";
	} else{
		if($_SESSION["utype"]==0){
			$sqlPassCheck="SELECT password FROM patient_details WHERE id=".$_SESSION["id"];
			//for patients
		} elseif($_SESSION["utype"]==1){
			$sqlPassCheck="SELECT password FROM doctor_details WHERE id=".$_SESSION["id"];
			//for doctors
		} else{header("location: homePage.php");}
		$result=$conn->query($sqlPassCheck);
		$row=$result->fetch_assoc();
		if($row["password"]!=$_POST["oldpass"]){
			//check oldpass to be true
			$err = "Old Password incorrect";
		}
	}
	
    // Validate new password
    if(empty(trim($_POST["newpass"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["newpass"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim(mysqli_real_escape_string($conn,$_POST["newpass"]));
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confpass"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim(mysqli_real_escape_string($conn,$_POST["confpass"]));
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err) && empty($err)){
        // Prepare an update statement
		
		if($_SESSION["utype"]==0){
			$sql = "UPDATE patient_details SET password ='".$new_password."' WHERE id =".$_SESSION["id"];
			//for patients
		} elseif($_SESSION["utype"]==1){
			$sql = "UPDATE doctor_details SET password ='".$new_password."' WHERE id =".$_SESSION["id"];
			//for doctors
		}
        //run query
		if($conn->query($sql) == TRUE){
			$success_mess="Password Updated Successfully";
		}else $err="Error attempting Query. Please try again";
        
        
    }
}
?>
<html>
<head>
<title>Reset Password | <?php if($_SESSION["utype"]==0){echo "Patient";}else{echo "Doctor";} ?> | Defence Research & Development Organisation DRDO
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
	#monthAppointmentsButton{
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
	#mainBody{
		height:1300px;
		padding-bottom:100px;
	}
	#header1{
		font-family:Arial;
		margin-top:5px;
		margin-left:50px;
		color:#224775;
	}
	.formText{
		font-size:26px;
		margin-left:0px;
		margin-bottom:0px;
		padding-top:50px;
	}
	.name{
		width:350px;
		font-size:24px;
		height:40px;
		border:1px solid #E6E6E6;
		border-radius:5px;
		padding:8px;
		margin-left:0px;
		margin-right:50px;
	}
	#editSubmit{
		width:350px;
		height:40px;
		background-image:linear-gradient(#224775,#1795CC);
		color:white;
		border:1px solid #224775;
		border-radius:5px;
		margin-top:100px;
		font-size:30px;
		cursor:pointer;
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
			<div style="margin-right:325px;font-family:Arial;"><h1>Reset Password</h1></div>
		</div>
		<div id="dashBar">
			<div class="dashButton" id="menuButton">
				<img src="menuButt.png" style="height:20px ;width:25px; margin-top:12.5px;">
			</div>
			<a href="doctorLogin.php" id="homeButton" class="barButton dashButton">Home</a>
			
			<a href="patientAppointments.php" id="monthAppointmentsButton" class="barButton dashButton">Monthly Appointments</a>
			
			<a href="doctorEditProfile.php" id="editprofButton" class="barButton dashButton">Edit Profile</a>
			
			<a href="logout.php" id="loutButton" class="barButton dashButton">Logout</a>
		</div>
		<div id="menuDrop" align=left>
			<h2 align=center>Menu</h2>
			
			<a class="mitem" href="changeLimit.php">
				&#9658 Change Daily Appointment Limit
			</a>
			<a class="mitem" href="resetPasswordDoctor.php">
				&#9658 Change Password
			</a>
		</div>
		
		<div> 
			<img src="Capture1.png" style="width:100%;height:400px;">
		</div>
		<div id="header1" align=left>	<h1> Reset Password here: </h1>
		</div>
		<div style="margin-left:440px;">
			<form align=left style="float:left" method="POST">
				<div>
					<p class="formText"> Enter Old Password:</p>
					<input type="password" class="name" name="oldpass" placeholder="Old Password">
				</div>
				<div>
					<p class="formText"> Enter New Password:</p>
					<input type="password" class="name" name="newpass" placeholder="New Password">
				</div>
				<div>
					<p class="formText"> Re-Enter New Password:</p>
					<input type="password" class="name" name="confpass" placeholder="Re-Enter New Password">
				</div>
				<input type="submit" id="editSubmit" value="Save Changes">
			</form>
		</div>
		<div id="errorDiv">
			<div id="closeErr1">
				<div id="errorTop">
					<a style="position:relative;top:4px;margin-left:20px;"><b><?php if($success_mess!=""){echo "Success!!";}else{ echo "Error!!";}?></b></a>
					<img src="close.png" id="closeErr">
				</div>
				<a style="margin:auto;">
				<?php if($success_mess!=""){echo $success_mess;}else{echo $err."\n".$confirm_password_err."\n".$new_password_err;}?>
				
				</a>
			</div>
		</div>
		
	</div>
</div>		
<script type="text/javascript">

window.onload=errorDiv();
function errorDiv(){
	var val="<?php echo $err.$confirm_password_err.$new_password_err?>";
	var val3="<?php echo $success_mess?>";
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
$("#monthAppointmentsButton").hover(function(){
	$("#monthAppointmentsButton").css("background-image","linear-gradient(#2979FF,#2979FF)")},
	function(){
	$("#monthAppointmentsButton").css("background-image","linear-gradient(#224775,#1795CC)")}
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
