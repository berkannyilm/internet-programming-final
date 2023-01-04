<?php

require_once("../Configuration/Database.php");
require_once("../Configuration/Functions.php");


$accessMethod = array('POST');
$userAccessMethod = $_SERVER['REQUEST_METHOD'];

if (!in_array($userAccessMethod, $accessMethod)) {

    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
    exit();

} else {

    try {
        
 
        $InstructorId = xss_clean(securty($_POST["InstructorId"]));   
        $CategoryId = xss_clean(securty($_POST["CategoryId"]));   
        $Title = xss_clean(securty($_POST["Title"]));   
        $Price = xss_clean(securty($_POST["Price"]));   
        $Summary = xss_clean(securty($_POST["Summary"]));   
        $Detail = xss_clean(securty($_POST["Detail"]));
        $Seourl = seo($Title);
        if ($_FILES["CourseImageUrl"]["size"] > 0) {

            if ($_FILES['CourseImageUrl']['size'] > 1048570) {

                $ReturnData["icon"] = "warning";
                $ReturnData["title"] = "Kurs Oluştur";
                $ReturnData["message"] = "Dosya boyutu maksimum 1MB olmalıdır. ";
                echo json_encode($ReturnData);
                exit();

            } else {
                $izinli_uzantilar = array('jpg', 'webp', 'png');

                $ext = strtolower(substr($_FILES['CourseImageUrl']["name"], strpos($_FILES['CourseImageUrl']["name"], '.') + 1));

                if (in_array($ext, $izinli_uzantilar) === false) {

                    $ReturnData["icon"] = "warning";
                    $ReturnData["title"] = "Kurs Oluştur";
                    $ReturnData["message"] = "Lütfen geçerli bir dosya seçiniz. İzin verilen dosya uzantıları(JPG,PNG,WEBP) " . " (" . http_response_code(400) . ")";
                    echo json_encode($ReturnData);
                    exit();

                } else {
                   
                    @$tmp_name = $_FILES['CourseImageUrl']["tmp_name"];
                    @$name = seo($_FILES['CourseImageUrl']["name"]);
                    $uploads_dir = '../../cdn/images/courses';
                    $uniq = uniqid();
                    $ImageUrl = substr($uploads_dir, 6) . "/" . $uniq . "." . $ext;
                    @move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

                    $AddCourse = $connection->prepare("INSERT INTO tblcourses SET
                    tblCourseCategoryId= :tblCourseCategoryId, 
                    tblInstructorId= :tblInstructorId,  
                    tblCourseImageUrl= :tblCourseImageUrl,  
                    tblCourseTitle= :tblCourseTitle,
                    tblCourseSeoUrl= :tblCourseSeoUrl,
                    tblCourseSummary= :tblCourseSummary,
                    tblCourseDetail= :tblCourseDetail,
                    tblCoursePrice= :tblCoursePrice
                    ");

                    $AddCourse->bindParam(":tblCourseCategoryId", $CategoryId, PDO::PARAM_INT); 
                    $AddCourse->bindParam(":tblInstructorId", $InstructorId, PDO::PARAM_INT); 
                    $AddCourse->bindParam(":tblCourseImageUrl", $ImageUrl, PDO::PARAM_STR); 
                    $AddCourse->bindParam(":tblCourseTitle", $Title, PDO::PARAM_STR); 
                    $AddCourse->bindParam(":tblCourseSeoUrl", $Seourl, PDO::PARAM_STR); 
                    $AddCourse->bindParam(":tblCourseSummary", $Summary, PDO::PARAM_STR); 
                    $AddCourse->bindParam(":tblCourseDetail", $Detail, PDO::PARAM_STR); 
                    $AddCourse->bindParam(":tblCoursePrice", $Price, PDO::PARAM_INT); 
                    
                    if ($AddCourse->execute()) {

                        $ReturnData["icon"] = "success";
                        $ReturnData["title"] = "Kurs Oluştur";
                        $ReturnData["message"] = "Kurs başarıyla eklendi! (" . http_response_code() . ")";
                        echo json_encode($ReturnData);
                        exit();

                    } else {

                        $ReturnData["icon"] = "error";
                        $ReturnData["title"] = "Kurs Oluştur";
                        $ReturnData["message"] = "Kurs oluşturulurken bir sorun oluştu! (" . http_response_code(400) . ")";
                        echo json_encode($ReturnData); 
                        exit();
                    }
                }
            }
        }else{
            $ReturnData["icon"] = "warning";
            $ReturnData["title"] = "Kurs Oluştur";
            $ReturnData["message"] = "Lütfen bir dosya seçiniz! (" . http_response_code(400) . ")";
            echo json_encode($ReturnData); 
            exit();
        }
    } catch (Exception $e) { 
        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Kurs Oluştur"; 
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>