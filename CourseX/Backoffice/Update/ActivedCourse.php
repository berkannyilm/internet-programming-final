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

        $GetCourse = json_decode(file_get_contents("php://input"));
        $CourseId= $GetCourse->CourseId;
         
        $activateCourse=$connection->prepare("UPDATE tblcourses SET 
        tblCourseStatus = 'Active'
        WHERE tblCourseId= :tblCourseId");
        $activateCourse->bindParam(":tblCourseId", $CourseId, PDO::PARAM_INT);
        if ($activateCourse->execute()) {

            $ReturnData["icon"] = "info";
            $ReturnData["title"] = "Kategori Durumu:";
            $ReturnData["message"] = "Seçilen kurs başarıyla aktif edildi. (" . http_response_code(200) . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["error"] = "warning";
            $ReturnData["title"] = "Kategori Durumu:"; 
            $ReturnData["message"] = "Seçilen kurs aktif edilemedi. (" . http_response_code(400) . ")";
            echo json_encode($ReturnData);
            exit();
        }
        
    } catch (Exception $e) {
        
            $ReturnData["title"] = "Hata: "; 
            $ReturnData["message"] = "Bilinmeyen bir hata oluştu: ".$e." (" . http_response_code(500) . ")";
            echo json_encode($ReturnData);
            exit();
    }


}
?>