<?php 
	$host="localhost";
	$user="root";
	$password="";
	$lmess="";
$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "CREATE DATABASE TEST1";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully ";
} 
$query ="USE TEST1";
if ($conn->query($query) == TRUE)
{	echo "Database Selected ";
} else {	echo "Error" . $conn->error;}

/*$sql34="DROP TABLE doctor_details;";
if ($conn->query($sql34) === TRUE) {
    echo "doctor_details dropped successfully";
} else {
    echo "Error dropping table: " . $conn->error;
}*/	

$sql1 = "CREATE TABLE patient_details (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
firstname VARCHAR(30) NOT NULL,
middlename VARCHAR(30) ,
lastname VARCHAR(30) ,
contact INT(10) UNSIGNED,
email VARCHAR(50),
password VARCHAR(30),
UHID INT(15) UNSIGNED,
dob date,
bloodgroup VARCHAR(5),
d_id INT(10) UNSIGNED,
reg_date TIMESTAMP
)";

if ($conn->query($sql1) === TRUE) {
    echo "patient_details created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}	


$sql2 = "CREATE TABLE doctor_details (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) ,
contact INT(10) UNSIGNED,
email VARCHAR(50),
password VARCHAR(30),
dept VARCHAR(20),
dlimit int(3) DEFAULT 30,
reg_date TIMESTAMP
)";

if ($conn->query($sql2) === TRUE) {
    echo "doctor_details created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}	
$sql99="SELECT * from doctor_details;";
$result = $conn->query($sql99);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo " id: " . $row["id"]. " - Name: " . $row["email"]. " " . $row["password"]. $row["dept"]."<br>";
    }
} else {
    echo "0 results";
}
/*$sqld='insert into doctor_details(firstname,lastname,contact, email, password, dept) VALUES ("Tej Pratap","Singh",8765432200,"doctoremail2@example.com","DoctorPassword1","Thyroid-Clinic")';
if ($conn->query($sqld) === TRUE) {
    echo "doctor added successfully";
} else {
    echo "Error adding doctor: " . $conn->error;
}*/

/*
$sql34="DROP TABLE appointment_details;";
if ($conn->query($sql34) === TRUE) {
    echo "APPOINTMENT_details dropped successfully";
} else {
    echo "Error dropping table: " . $conn->error;
}	*/

/*$sqldp="ALTER TABLE patient_details ADD dob DATE ;";
if ($conn->query($sqldp) === TRUE) {
    echo "patient_details altered successfully";
} else {
    echo "Error altering table: " . $conn->error;
}

*/

$sqlapt="CREATE TABLE appointment_details (
id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
p_id INT(6) ,
d_id INT(6) ,
dname VARCHAR(30),
reg_date TIMESTAMP,
apt_date DATE);";
if ($conn->query($sqlapt) === TRUE) {
    echo "appointment_details created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}	
/*$sqld='insert into appointment_details(p_id,d_id,dname, apt_date) VALUES (1,1,"gyna","2019-01-04")';
if ($conn->query($sqld) === TRUE) {
    echo "apt added successfully";
} else {
    echo "Error adding apt: " . $conn->error;
}*/

/*$sqldp="ALTER TABLE doctor_details ADD dlimit int(3) DEFAULT 30;";
if ($conn->query($sqldp) === TRUE) {
    echo "doctor_details altered successfully";
} else {
    echo "Error altering table: " . $conn->error;
}	*/
/*$sql34="DROP TABLE patient_doctor;";
if ($conn->query($sql34) === TRUE) {
    echo "patient_doctor dropped successfully";
} else {
    echo "Error dropping table: " . $conn->error;
}*/
$sqlapt="CREATE TABLE patient_doctor (
id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
p_id INT(6) ,
d_id INT(6) ,
dname VARCHAR(30));";
if ($conn->query($sqlapt) === TRUE) {
    echo "patient_doctor created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}	

?>