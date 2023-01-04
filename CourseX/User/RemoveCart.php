<?php

require_once("../Configuration/Connection.php");
require_once("../Configuration/Functions.php");

$accessMethod = array('POST');
$userAccessMethod = $_SERVER['REQUEST_METHOD'];

if (!in_array($userAccessMethod, $accessMethod)) {

    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
    exit();

} else {

    try {

        $GetData = json_decode(file_get_contents("php://input"));
        $CartId = xss_clean(securty($GetData->CartId));   
        
        $RemoveCart = $connection->prepare("DELETE FROM tblcarts WHERE tblCartId = :tblCartId "); 
        $RemoveCart->bindParam(":tblCartId", $CartId, PDO::PARAM_INT);  

        if ($RemoveCart->execute()) {
 
            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "CourseX"; 
            $ReturnData["message"] = "Kurs sepetten çıkarıldı. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "Kurs sepetten çıkarılamadı. (" . http_response_code(400) . ")";
            echo json_encode($ReturnData); 
            exit();
        }

    } catch (Exception $e) {

        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "CourseX";
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . ". (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>