<?php
require_once("Configuration/Connection.php");
require_once("Configuration/Functions.php");

$GetStudent = $connection->prepare("SELECT * FROM tblstudents WHERE tblStudentEmail= :tblStudentEmail");
$GetStudent->bindParam(":tblStudentEmail", $_SESSION["StudentEmail"], PDO::PARAM_STR);
$GetStudent->execute();
$GetStudent = $GetStudent->fetch();

$_SESSION["StudentId"] = $GetStudent["tblStudentId"];

$DefaultId = 1 ;
$GetSettings = $connection->prepare("SELECT * FROM tblsettings WHERE tblSettingId = :Id");
$GetSettings->bindParam(":Id", $DefaultId, PDO::PARAM_INT);
$GetSettings->execute();
$GetSetting=$GetSettings->fetch(PDO::FETCH_ASSOC);


$GetCourses = $connection->prepare("SELECT  
tblinstructors.*, tblcoursecategories.*, tblcourses.* FROM tblcourses 
INNER JOIN tblinstructors ON tblcourses.tblInstructorId=tblinstructors.tblInstructorId
INNER JOIN tblcoursecategories ON tblcourses.tblCourseCategoryId=tblcoursecategories.tblCourseCategoryId
WHERE
tblCourseCategoryStatus IN('Active')
AND 
tblInstructorStatus IN('Active')
AND 
tblCourseStatus IN('Active')
ORDER BY tblCourseCreatedDate DESC");
$GetCourses->execute();

$GetCategories = $connection->prepare("SELECT * FROM tblcoursecategories WHERE tblCourseCategoryStatus IN('Active') ORDER BY tblCourseCategoryStatus ASC");
$GetCategories->execute();

$GetInstructors = $connection->prepare("SELECT * FROM tblinstructors WHERE tblInstructorStatus IN('Active')");
$GetInstructors->execute();


$GetCart = $connection->prepare("SELECT * FROM tblcarts
INNER JOIN tblcourses ON tblcarts.tblCourseId= tblcourses.tblCourseId
WHERE tblcarts.tblStudentId= :tblStudentId
");
$GetCart->bindParam(":tblStudentId", $_SESSION["StudentId"]);
$GetCart->execute();
$CartTotal = 0;

?>