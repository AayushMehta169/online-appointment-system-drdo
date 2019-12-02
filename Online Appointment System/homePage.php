<?php 
	require_once "config.php";
	$err="";
	session_start();
 
	// Check if the user is already logged in, if yes then redirect him to welcome page
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		if($_SESSION["utype"]==0){
			header("location: patientlogin.php");
		}elseif($_SESSION["utype"]==1){
			header("location: doctorLogin.php");
		}
		exit;
	}

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$rusername_err = $rpassword_err = $rconfirm_password_err = "";
$success_mes="";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
	// Validate username
	//2 is set for registration
    if($_POST["checkval"]==2){
		if(!empty(trim($_POST["remail"]))){
			// Prepare a select statement
			$sql = 'SELECT id FROM patient_details WHERE email = "'.mysqli_real_escape_string($conn,$_POST["remail"]).'";';
			
			$result = $conn->query($sql);
			if($result == TRUE)
			{
				if ($result->num_rows == 1) {
					//check if username exists
					$rusername_err = "This Email already exists.";
				} else {
					$username = trim(mysqli_real_escape_string($conn,$_POST["remail"]));
				}
			} else {
				$err=$err."Oops! Something went wrong. Please try again later.";
			}
			 
		
			// Validate password
			if(empty(trim($_POST["rpass1"]))){
				$password_err = "Please enter a password.";     
			} elseif(strlen(trim($_POST["rpass1"])) < 6){
				$rpassword_err = "Password must have atleast 6 characters.";
			} else{
				$password = trim(mysqli_real_escape_string($conn,$_POST["rpass1"]));
			}
		
			// Validate confirm password
			if(empty(trim($_POST["rpass2"]))){
				$rconfirm_password_err = "Please confirm password.";     
			} else{
				$confirm_password = trim(mysqli_real_escape_string($conn,$_POST["rpass2"]));
				if(empty($password_err) && ($password != $confirm_password)){
					$rconfirm_password_err = "Password did not match.";
				}
			}
		
			// Check input errors before inserting in database
			if(empty($rusername_err) && empty($rpassword_err) && empty($rconfirm_password_err)){
				
				// Prepare an insert statement
				$sql = 'INSERT INTO patient_details (firstname, middlename, lastname, contact, email, password, UHID) VALUES ("'.mysqli_real_escape_string($conn,$_POST['fname']).'","'.mysqli_real_escape_string($conn,$_POST['mname']).'","'.mysqli_real_escape_string($conn,$_POST['lname']).'",'.mysqli_real_escape_string($conn,$_POST['rnum']).',"'.$username.'","'.$password.'",'.mysqli_real_escape_string($conn,$_POST['uhid']).');';
				
				if ($conn->query($sql) === TRUE) {
					$success_mes = "Account Created Successfully.";
				} else {
					$err=$err."Error: " . $sql . "<br>" . $conn->error;
				}
			}
		}//end of registration
    }
	//begin P_login
	// Check if username is empty
	//0 is set for patient login
    elseif($_POST["checkval"]==0){
		if(!empty(trim($_POST["pemail"]))){
				// Define variables and initialize with empty values
			$username = $password = "";
			$username_err = $password_err = "";
			$username = trim(mysqli_real_escape_string($conn,$_POST["pemail"]));
		
		
			// Check if password is empty
			if(empty(trim($_POST["ppass"]))){
				$password_err = "Please enter your password.";
			} else{
				$password = trim(mysqli_real_escape_string($conn,$_POST["ppass"]));
			}
		
		// Validate credentials
			if(empty($username_err) && empty($password_err)){
				// Prepare a select statement
				$sql = 'SELECT id, email, password FROM patient_details WHERE email = "'.$username.'";';
				$result = $conn->query($sql);

				if ($result->num_rows == 1) {
					// username exists
					//check password
					$row = $result->fetch_assoc();
					if($row["password"] == $password){
						session_start();
						// Store data in session variables
						
						$_SESSION["loggedin"] = true;
						$_SESSION["id"] = $row["id"];
						$_SESSION["username"] = $username; 
						$_SESSION["utype"] = 0;//0 for patient login
						// Redirect user to welcome page
						header("location: patientLogin.php");
					} else{
						$password_err = "The password you entered was not valid.";
					}
				}
				else {
					$username_err = "No account found with that username.";
				}
				
			}
		}
	}
	//doctor login
	//1 is set for doctor form submission
	elseif($_POST["checkval"]==1){
		if(!empty(trim($_POST["demail"]))){
				// Define variables and initialize with empty values
			$username = $password = "";
			$username_err = $password_err = "";
			$username = trim(mysqli_real_escape_string($conn,$_POST["demail"]));
		
		
			// Check if password is empty
			if(empty(trim($_POST["dpass"]))){
				$password_err = "Please enter your password.";
			} else{
				$password = trim(mysqli_real_escape_string($conn,$_POST["dpass"]));
			}
		
		// Validate credentials
			if(empty($username_err) && empty($password_err)){
				// Prepare a select statement
				$sql = 'SELECT id, email, password FROM doctor_details WHERE email = "'.$username.'";';
				$result = $conn->query($sql);

				if ($result->num_rows == 1) {
					// doctor username exists
					//check password
					$row = $result->fetch_assoc();
					if($row["password"] == $password){
						session_start();
						// Store data in session variables
						echo "check here";
						$_SESSION["loggedin"] = true;
						$_SESSION["id"] = $row["id"];
						$_SESSION["username"] = $username; 
						$_SESSION["utype"] = 1;//1 is for doctor login
						// Redirect doctor to welcome page
						header("location: doctorLogin.php");
					} else{
						$password_err = "The password you entered was not valid.";
					}
				}
				else {
					$username_err = "No account found with that username.";
				}
				
			}
		}
	}
}
?>
<html>
<head><title>Online Appointment | Defence Research & Development Organisation DRDO
</title>
<meta charset="utf-8">
<link rel="icon" type="image/png" href="logo-image.png" >
<link rel="stylesheet" type="text/css" href="css_1.css">
</head>
<body>
<script src="jquery-3.4.1.js"></script>
<style type="text/css">
	
	
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
		<a id="divider1"></a>
		<div style="padding-top:50px;width:100%;text-align:center;position:relative;left:-40px;">
			<h1>Online Appointment System</p>
		</div>
		
		<div id="instructions">
			<div id="textInstructions">
				<h1>Need an appointment?</h1>
				<p>Now do that in just a <br>few quick steps.</p>
			</div>
			<img src="instructions.jpg">
		</div>
		<a id="divider2"></a>
		<div id="login">
		<h1 style="color:#224775; float:left;margin-right:300px;margin-left:25px;"> Login :</h1>
			<div id="userType">
				<div id="pButt">
					Patient
				</div>
				<div id="dButt">
					Doctor
				</div>
			</div>
			<div style="float:left;height:50px;width:400px; "></div>
			<div id="plogin">
			<form id="pform" method="POST">
				<input type="email" class="email" id="pemailID"name="pemail" placeholder="Patient Email ID">
				<input type="password" class="password" id="ppassID"name="ppass" placeholder="Patient Password">
				<input type="submit" id="psubmit" value="Login">
				<input type="number" value="0" name="checkval" style="display:none;">
				
			</form>
			</div>
			<div id="dlogin">
				<form id="dform" method="POST">
					<input type="email" class="email" id="demailID" name="demail" placeholder="Doctor Email ID">
					<input type="password" class="password" id="dpassID" name="dpass" placeholder="Doctor Password">
					<input type="submit" id="dsubmit" value="Login">
					<input type="number" value="1" name="checkval" style="display:none;">
				</form>
			</div>
		</div>
		<div id="errorDiv">
			<div id="closeErr1">
				<div id="errorTop">
					<a style="position:relative;top:4px;margin-left:20px;"><b><?php if($success_mes!=""){echo "Success!!";}else{ echo "Error!!";}?></b></a>
					<img src="close.png" id="closeErr">
				</div>
				<a style="margin:auto;">
				<?php if($success_mes!=""){echo $success_mes;}else{echo $password_err."\n".$username_err;echo $rpassword_err.$err.$rusername_err.$rconfirm_password_err;}?>
				
				</a>
			</div>
		</div>
		
		<div id="divider3"></div>
		
		<div id="register">
			<h1 style="color:#224775; float:left;margin-left:20px;"> Register Here:</h1> 
			<form id="rform" method="POST">
			<div id="registername">
				<input type="text" class="name" name="fname" placeholder="First Name" id="fnameID" >
				<input type="text" class="name" name="mname" placeholder="Middle Name" id="mnameID" >
				<input type="text" class="name" name="lname" placeholder="Last Name" id="lnameID" >
				
			</div>
				<input type="number" id="rnumID" class="formtype1" name="rnum" placeholder="Contact No."  onkeydown="return event.keyCode !== 69">
				<input type="email" class="formtype1" id="remail" name="remail" placeholder="Email ID">
				<input type="password" class="formtype1" id="pass1" name="rpass1" placeholder="Enter Password">
				<input type="password" class="formtype1" id="pass2" name="rpass2" placeholder="Re-Enter Password">
				<input type="number" id="uhidID" class="formtype1" name="uhid" placeholder="UHID Number." onkeydown="return event.keyCode !== 69" >
				<input type="submit" id="rsubmit" value="Register">
				<input type="number" value="2" name="checkval" style="display:none;">
			</form>
			
		</div>
	</div>
	
</div>

<script type="text/javascript">
window.onload=errorDiv();
function errorDiv(){
	var val="<?php echo $password_err.$username_err.$err.$confirm_password_err;?>";
	var val2="<?php echo $rpassword_err.$err.$rusername_err.$rconfirm_password_err;?>";
	var val3="<?php echo $success_mes;?>";
	if(val!=""||val2!=""||val3!=""){
		$("#errorDiv").css("display","inline");
	}
}
$("#closeErr").click(function(){
	$("#errorDiv").css("display","none");
	
})


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
		var currentSizeh1 = $('h1').css('font-size');
		//alert(currentSize);
		if(currentSize>="22px")
		{alert("Woah!! Slow down there Chief!!")}
		else{
		var currentSize = parseFloat(currentSize)*1.2;
		$('p').css('font-size', currentSize);
		var currentSizeh1 = parseFloat(currentSizeh1)*1.1;
		$('h1').css('font-size', currentSizeh1);}
		})
		
$("#decSize").click(function(){
		var currentSize = $('p').css('font-size');
		var currentSizeh1 = $('h1').css('font-size');
		if(currentSize<="10px"){
		alert("Even Senor Chang can't read that.");}
		else{
		var currentSize = parseFloat(currentSize)/1.2;
		$('p').css('font-size', currentSize);
		var currentSizeh1 = parseFloat(currentSizeh1)/1.1;
		$('h1').css('font-size', currentSizeh1);}
		})
$("#resSize").click(function(){
		$('p').css('font-size', "18px");
		$('h1').css('font-size','2em');})
$("#incSize").hover(function(){
	$("#incSize").css("color","#FA925B")},
	function(){
	$("#incSize").css("color","white")}
	)
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
$("#pButt").click(function(){
	$("#dlogin").css("display","none")
	$("#plogin").css("display","inline")
	$("#pButt").css("background-color","#2979FF")
	$("#dButt").css("background-color","#224775")	
})
$("#dButt").click(function(){
	$("#plogin").css("display","none")
	$("#dlogin").css("display","inline")
	$("#pButt").css("background-color","#224775")
	$("#dButt").css("background-color","#2979FF")
	
})

$("#pform").submit(function(){
	var error="";
	if($("#pemailID").val()==""){
		error+="Email field required.\n";
	}
	if($("#ppassID").val()==""){
		error+="Password required. ";
	}
	if(error !=""){
		alert(error);
		return false;
	}
	else return true;

})
$("#dform").submit(function(){
	var error="";
	if($("#demailID").val()==""){
		error+="Email field required.\n";
	}
	if($("#dpassID").val()==""){
		error+="Password required. ";
	}
	if(error !=""){
		alert(error);
		return false;
	}
	else return true;

})
$("#rform").submit(function(){
	var error="";
	if($("#fnameID").val()+$("#mnameID").val()+$("#lnameID").val()==""){
		error+="Name is required.\n";
	}
	if($("#rnumID").val()=="" ||$("#rnumID").val().length<8){
		error+="Complete Number required.\n";
	}
	if($("#remail").val()==""){
		error+="Email field required.\n";
	}
	if($("#pass1").val()==""){
		error+="Password required.\n";
	}
	else if($("#pass1").val()!=$("#pass2").val()){
		error+="Passwords dont match.\n";
	}
	if($("#uhidID").val()==""){
		error+="UHID required.\n";
	}
	if(error !=""){
		alert(error);
		return false;
	}
	else {	
		return true;
	}
})

</script>


</body>
</html>