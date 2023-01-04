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
         
        $deactivateCourse=$connection->prepare("UPDATE tblcourses SET 
        tblCourseStatus = 'InActive'
        WHERE tblCourseId= :tblCourseId");
        $deactivateCourse->bindParam(":tblCourseId", $CourseId, PDO::PARAM_INT);
        if ($deactivateCourse->execute()) {

            $ReturnData["icon"] = "info";
            $ReturnData["title"] = "Kurs Durumu:";
            $ReturnData["message"] = "Seçilen kurs başarıyla pasif edildi. (" . http_response_code(200) . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["error"] = "warning";
            $ReturnData["title"] = "Kurs Durumu:"; 
            $ReturnData["message"] = "Seçilen kurs pasif edilemedi. (" . http_response_code(400) . ")";
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