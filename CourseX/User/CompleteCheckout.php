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
        $StudentId = xss_clean(securty($GetData->StudentId));

        $GetCartDetail = $connection->prepare("SELECT * FROM tblcarts WHERE tblStudentId= :StudentId");
        $GetCartDetail->bindParam(":StudentId", $StudentId, PDO::PARAM_INT);
        $GetCartDetail->execute();
        foreach ($GetCartDetail->fetchAll(PDO::FETCH_ASSOC) as $GetCart) {
            $CreatedOrder = $connection->prepare("INSERT INTO tblorders SET 
            tblOrderCourseId= :tblOrderCourseId,
            tblOrderStudentId= :tblOrderStudentId,
            tblOrderTotalAmount= :tblOrderTotalAmount            
            ");
            $CreatedOrder->bindParam(":tblOrderCourseId", $GetCart["tblCourseId"], PDO::PARAM_INT);
            $CreatedOrder->bindParam(":tblOrderStudentId", $GetCart["tblStudentId"], PDO::PARAM_INT);
            $CreatedOrder->bindParam(":tblOrderTotalAmount", $GetCart["tblCartPrice"], PDO::PARAM_INT);
            $CreatedOrder->execute();
        }        


        $RemoveCart = $connection->prepare("DELETE FROM tblcarts WHERE tblStudentId = :StudentId "); 
        $RemoveCart->bindParam(":StudentId", $StudentId, PDO::PARAM_INT);  

        if ($RemoveCart->execute()) {
 
            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "CourseX"; 
            $ReturnData["message"] = "Sepetiniz onaylandı, başarılar . (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "Sepetiniz onaylanmadı. (" . http_response_code(400) . ")";
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