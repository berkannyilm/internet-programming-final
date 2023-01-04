<?php

//Create Instructor api
$Instructors = array();
$GetInstructors = $connection->prepare("SELECT * FROM tblinstructors ORDER BY tblInstructorStatus ASC");
$GetInstructors->execute();
foreach ($GetInstructors->fetchAll(PDO::FETCH_ASSOC) as $Instructor) {
    
    $Instructors[] = array(
        "Id"=>$Instructor["tblInstructorId"],
        "Firstname"=>$Instructor["tblInstructorFirstname"],
        "Lastname"=> $Instructor["tblInstructorLastname"],
        "ProfileImageUrl"=>$Instructor["tblInstructorImageUrl"],
        "Rating"=>$Instructor["tblInstructorRating"],
        "CreatedDate"=>$Instructor["tblInstructorCreatedDate"],
        "Status"=>$Instructor["tblInstructorStatus"]
    );
}

$instructor_file_name = "../Api/instructors.json";
$EncodedInstructors = json_encode($Instructors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents($instructor_file_name, $EncodedInstructors);


//Create Course Categories api
$Categories = array();
$GetCategories = $connection->prepare("SELECT * FROM tblcoursecategories ORDER BY tblCourseCategoryStatus ASC");
$GetCategories->execute();
foreach ($GetCategories->fetchAll(PDO::FETCH_ASSOC) as $Category) {

    $Categories[] = array(
        "Id" => $Category["tblCourseCategoryId"],
        "Title" => $Category["tblCourseCategoryTitle"],
        "SeoUrl" => $Category["tblCourseCategorySeoUrl"],
        "CreatedDate" => $Category["tblCourseCategoryCreatedDate"],
        "Status" => $Category["tblCourseCategoryStatus"] 
    );
}

$categories_file_name = "../Api/categories.json";
$EncodedCategories = json_encode($Categories, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents($categories_file_name, $EncodedCategories);


//Create courses api
$Courses = array();
$GetCourses = $connection->prepare("SELECT  
tblinstructors.*, tblcoursecategories.*, tblcourses.* FROM tblcourses 
INNER JOIN tblinstructors ON tblcourses.tblInstructorId=tblinstructors.tblInstructorId
INNER JOIN tblcoursecategories ON tblcourses.tblCourseCategoryId=tblcoursecategories.tblCourseCategoryId
ORDER BY tblCourseCreatedDate DESC");
$GetCourses->execute();
foreach ($GetCourses->fetchAll(PDO::FETCH_ASSOC) as $Course) {

    $Courses[] = array(
         "Id"=>$Course["tblCourseId"],
         "ImageUrl"=>$Course["tblCourseImageUrl"],
         "Title"=>$Course["tblCourseTitle"],
         "Rating"=>$Course["tblCourseRating"],
         "SeoUrl"=>$Course["tblCourseSeoUrl"],
         "CategoryTitle"=>$Course["tblCourseCategoryTitle"],
         "IProfileImageUrl"=>$Course["tblInstructorImageUrl"],
         "IFirstnameAndLastname"=>$Course["tblInstructorFirstname"]." ".$Course["tblInstructorLastname"],
         "CreatedDate"=>$Course["tblCourseCreatedDate"],
         "Status" =>$Course["tblCourseStatus"],
    );
}

$Courses_file_name = "../Api/courses.json";
$EncodedCourses = json_encode($Courses, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents($Courses_file_name, $EncodedCourses);

$Students = array();
$GetStudents = $connection->prepare("SELECT * FROM tblstudents ORDER BY tblStudentCreatedDate DESC");
$GetStudents->execute();
foreach ($GetStudents->fetchAll(PDO::FETCH_ASSOC) as $Student) {

$Students[] = array(
"Id"=>$Student["tblStudentId"],
"Firstname"=>$Student["tblStudentFirstname"],
"Lastname"=> $Student["tblStudentLastname"],
"CreatedDate"=> $Student["tblStudentCreatedDate"],
"Status"=>$Student["tblStudentStatus"]
);
}

$Student_file_name = "../Api/students.json";
$EncodedStudents = json_encode($Students, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents($Student_file_name, $EncodedStudents);

$Newsletters = array();
$GetNewsletters = $connection->prepare("SELECT * FROM tblnewsletters ORDER BY tblNewsletterCreatedDate DESC");
$GetNewsletters->execute();
foreach ($GetNewsletters->fetchAll(PDO::FETCH_ASSOC) as $Newsletter) {

$Newsletters[] = array(
"Id"=>$Newsletter["tblNewsletterId"],
"Email"=>$Newsletter["tblNewsletterEmail"], 
"CreatedDate"=> $Newsletter["tblNewsletterCreatedDate"], 
);
}

$Newsletter_file_name = "../Api/newsletters.json";
$EncodedNewsletters = json_encode($Newsletters, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents($Newsletter_file_name, $EncodedNewsletters);

$Pages = array();
$GetPages = $connection->prepare("SELECT * FROM tblpages ORDER BY tblPageArrangement ASC");
$GetPages->execute();
foreach ($GetPages->fetchAll(PDO::FETCH_ASSOC) as $Page) {

$Pages[] = array(
    "Id"=>$Page["tblPageId"],
    "Title"=>$Page["tblPageTitle"],
    "SeoUrl"=>$Page["tblPageSeoUrl"], 
    "Detail"=>$Page["tblPageDetail"], 
    "Arrangement"=>$Page["tblPageArrangement"], 
    "CreatedDate"=> $Page["tblPageCreatedDate"], 
    );
}

$Page_file_name = "../Api/pages.json";
$EncodedPages = json_encode($Pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
file_put_contents($Page_file_name, $EncodedPages);
?>