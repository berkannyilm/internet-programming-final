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
        $CourseId = xss_clean(securty($GetData->CourseId)); 
        $Price = xss_clean(securty($GetData->Price));


        $CheckCourseInOrders = $connection->prepare("SELECT * FROM tblorders 
        WHERE 
        tblOrderCourseId= :tblOrderCourseId
        AND tblOrderStudentId= :tblOrderStudentId ");
        $CheckCourseInOrders->bindParam(":tblOrderStudentId", $_SESSION["StudentId"], PDO::PARAM_INT); 
        $CheckCourseInOrders->bindParam(":tblOrderCourseId", $CourseId, PDO::PARAM_INT);
        $CheckCourseInOrders->execute();
        if($CheckCourseInOrders->rowCount()>0){

            $ReturnData["icon"] = "info";
            $ReturnData["title"] = "CourseX"; 
            $ReturnData["message"] = "Bu kursu daha önce satın aldınız! (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();
        }

        $AddToCart = $connection->prepare("INSERT INTO tblcarts SET
        tblStudentId= :tblStudentId,
        tblCourseId= :tblCourseId,
        tblCartPrice= :tblCartPrice  ");

        $AddToCart->bindParam(":tblStudentId", $_SESSION["StudentId"], PDO::PARAM_INT); 
        $AddToCart->bindParam(":tblCourseId", $CourseId, PDO::PARAM_INT);  
        $AddToCart->bindParam(":tblCartPrice", $Price, PDO::PARAM_INT);  

        if ($AddToCart->execute()) {
 
            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "CourseX"; 
            $ReturnData["message"] = "Kurs sepete eklendi. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "Kurs sepete eklenmedi. (" . http_response_code(400) . ")";
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