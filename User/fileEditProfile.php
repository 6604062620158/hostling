<?php
session_start();
echo '<meta charset="utf-8">';
include('../condb.php');
if ($_SESSION['m_level'] != 'admin') {
}

$Id_User = mysqli_real_escape_string($con, $_POST["Id_User"]);

$Name = mysqli_real_escape_string($con, $_POST["Name"]);
$Surname = mysqli_real_escape_string($con, $_POST["Surname"]);
$Age = mysqli_real_escape_string($con, $_POST["Age"]);
$Job = mysqli_real_escape_string($con, $_POST["Job"]);
$address = mysqli_real_escape_string($con, $_POST["Card_Address"]);
$Phone = mysqli_real_escape_string($con, $_POST["Phone"]);
$Gender = mysqli_real_escape_string($con, $_POST["Gender"]);
$Day = mysqli_real_escape_string($con, $_POST["Day"]);
$Month = mysqli_real_escape_string($con, $_POST["Month"]);
$Year = mysqli_real_escape_string($con, $_POST["Year"]);
$user_img = mysqli_real_escape_string($con, $_POST["user_img"]);


$date1 = date("Ymd_His");
$numrand = (mt_rand());
$user_img2 = (isset($_POST['user_imgnew']) ? $_POST['user_imgnew'] : '');
$upload = $_FILES['user_imgnew']['name'];
if ($upload != '') {

	$path = "../user_img/";
	$type = strrchr($_FILES['user_imgnew']['name'], ".");
	$newname = $numrand . $date1 . $type;
	$path_copy = $path . $newname;
	$path_link = "../user_img/" . $newname;
	move_uploaded_file($_FILES['user_imgnew']['tmp_name'], $path_copy);
} else {
	$newname = $user_img;
}

$sql = "UPDATE user SET 

	user_name='$Name',
	Surname='$Surname',
	user_Day='$Day',
	user_Month='$Month',
	user_Year='$Year',
	Job='$Job',
	Card_Address='$address',
	Phone='$Phone',
	Gender='$Gender',
	user_img='$newname'
	WHERE Id_User=$Id_User
	 ";

$result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error());
mysqli_close($con);

if ($result) {
	echo " <script> alert('แก้ไขข้อมูลโปรไฟล์สำเร็จ'); </script> ";
	echo " <script> window.location ='Profile.php'; </script> ";
}
