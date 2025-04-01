<?php
session_start();
echo '<meta charset="utf-8">';
include('../condb.php');

if ($_SESSION['m_level'] != 'User') {
	header("Location: index.php");
	exit;
}

if (isset($_POST['Id_User'], $_POST['user_name'], $_POST['Surname'], $_POST['Age'], $_POST['Phone']
, $_POST['Id_Booking'], $_POST['Message'], $_POST['rating'])) {
	$Id_User = mysqli_real_escape_string($con, $_POST["Id_User"]);
	$user_name = mysqli_real_escape_string($con, $_POST["user_name"]);
	$Surname = mysqli_real_escape_string($con, $_POST["Surname"]);
	$Age = mysqli_real_escape_string($con, $_POST["Age"]);
	$Phone = mysqli_real_escape_string($con, $_POST["Phone"]);
	$Id_Booking = mysqli_real_escape_string($con, $_POST["Id_Booking"]);
	$Message = mysqli_real_escape_string($con, $_POST["Message"]);
	$rating = mysqli_real_escape_string($con, $_POST["rating"]);

	
	$sql = "INSERT INTO review
	(
	id_user,
	Id_Booking,
	Name,
	Lastname,
	Age,
	Phone,
	Rating,
	Comment
	
	)
	VALUES
	(
	'$Id_User',
	'$Id_Booking',
	'$user_name',
	'$Surname',
	'$Age',
	'$Phone',
	'$rating',
	'$Message'

	)";

	$result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error());
	mysqli_close($con);

	if ($result) {
		echo '<script>';

		echo "window.location='Feedback-write-success.php';";
		echo '</script>';
	} else {
		echo '<script>';
		echo "window.location='index.php';";
		echo '</script>';
	}
} else {
	echo "ข้อมูลไม่ครบถ้วน!";
	exit;
}
