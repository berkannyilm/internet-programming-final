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

        if ($_FILES) {

            if ($_FILES['CourseImageUrl']['size'] > 1048570) {

                $ReturnData["icon"] = "warning";
                $ReturnData["title"] = "Kurs";
                $ReturnData["message"] = "Dosya boyutu maksimum 1MB olmalıdır. ";
                echo json_encode($ReturnData);
                exit();

            } else {
                $izinli_uzantilar = array('jpg', 'webp', 'png');

                $ext = strtolower(substr($_FILES['CourseImageUrl']["name"], strpos($_FILES['CourseImageUrl']["name"], '.') + 1));

                if (in_array($ext, $izinli_uzantilar) === false) {

                    $ReturnData["icon"] = "warning";
                    $ReturnData["title"] = "Kurs";
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

                    $UpdateCourse = $connection->prepare("UPDATE tblcourses SET
                    tblCourseCategoryId= :tblCourseCategoryId, 
                    tblInstructorId= :tblInstructorId,  
                    tblCourseImageUrl= :tblCourseImageUrl,  
                    tblCourseTitle= :tblCourseTitle,
                    tblCourseSeoUrl= :tblCourseSeoUrl,
                    tblCourseSummary= :tblCourseSummary,
                    tblCourseDetail= :tblCourseDetail,
                    tblCoursePrice= :tblCoursePrice

                    WHERE tblCourseId= :tblCourseId
                    ");

                    $UpdateCourse->bindParam(":tblCourseId", $_SESSION["CourseId"], PDO::PARAM_INT); 
                    $UpdateCourse->bindParam(":tblCourseCategoryId", $CategoryId, PDO::PARAM_INT); 
                    $UpdateCourse->bindParam(":tblInstructorId", $InstructorId, PDO::PARAM_INT); 
                    $UpdateCourse->bindParam(":tblCourseImageUrl", $ImageUrl, PDO::PARAM_STR); 
                    $UpdateCourse->bindParam(":tblCourseTitle", $Title, PDO::PARAM_STR); 
                    $UpdateCourse->bindParam(":tblCourseSeoUrl", $Seourl, PDO::PARAM_STR); 
                    $UpdateCourse->bindParam(":tblCourseSummary", $Summary, PDO::PARAM_STR); 
                    $UpdateCourse->bindParam(":tblCourseDetail", $Detail, PDO::PARAM_STR); 
                    $UpdateCourse->bindParam(":tblCoursePrice", $Price, PDO::PARAM_INT); 
                    
                    if ($UpdateCourse->execute()) {
                        unlink("../../" . $_SESSION["CourseImageUrl"]);
                        $ReturnData["icon"] = "success";
                        $ReturnData["title"] = "Kurs";
                        $ReturnData["message"] = "Kurs başarıyla güncellendi! (" . http_response_code() . ")";
                        echo json_encode($ReturnData);
                        exit();

                    } else {

                        $ReturnData["icon"] = "error";
                        $ReturnData["title"] = "Kurs";
                        $ReturnData["message"] = "Kurs güncellenirken bir sorun oluştu! (" . http_response_code(400) . ")";
                        echo json_encode($ReturnData); 
                        exit();
                    }
                }
            }
        }else{
            $UpdateCourse = $connection->prepare("UPDATE tblcourses SET
            tblCourseCategoryId= :tblCourseCategoryId, 
            tblInstructorId= :tblInstructorId,     
            tblCourseTitle= :tblCourseTitle,
            tblCourseSeoUrl= :tblCourseSeoUrl,
            tblCourseSummary= :tblCourseSummary,
            tblCourseDetail= :tblCourseDetail,
            tblCoursePrice= :tblCoursePrice
            WHERE tblCourseId= :tblCourseId ");

            $UpdateCourse->bindParam(":tblCourseId", $_SESSION["CourseId"], PDO::PARAM_INT); 
            $UpdateCourse->bindParam(":tblCourseCategoryId", $CategoryId, PDO::PARAM_INT); 
            $UpdateCourse->bindParam(":tblInstructorId", $InstructorId, PDO::PARAM_INT);  
            $UpdateCourse->bindParam(":tblCourseTitle", $Title, PDO::PARAM_STR); 
            $UpdateCourse->bindParam(":tblCourseSeoUrl", $Seourl, PDO::PARAM_STR); 
            $UpdateCourse->bindParam(":tblCourseSummary", $Summary, PDO::PARAM_STR); 
            $UpdateCourse->bindParam(":tblCourseDetail", $Detail, PDO::PARAM_STR); 
            $UpdateCourse->bindParam(":tblCoursePrice", $Price, PDO::PARAM_INT); 
            
            if ($UpdateCourse->execute()) {

                $ReturnData["icon"] = "success";
                $ReturnData["title"] = "Kurs";
                $ReturnData["message"] = "Kurs başarıyla güncellendi! (" . http_response_code() . ")";
                echo json_encode($ReturnData);
                exit();

            } else {

                $ReturnData["icon"] = "error";
                $ReturnData["title"] = "Kurs";
                $ReturnData["message"] = "Kurs güncellenirken bir sorun oluştu! (" . http_response_code(400) . ")";
                echo json_encode($ReturnData); 
                exit();
            }
        }
    } catch (Exception $e) { 
        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Kurs"; 
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>