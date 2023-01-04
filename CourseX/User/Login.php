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
        $Email = xss_clean(securty($GetData->Email)); 
        $Password = xss_clean(securty($GetData->Password)); 
        
        $Password = sha1(md5(sha1($Password)));
        $Password = substr($Password, 7, 18);

        $Email = filter_var($Email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "Geçersiz bir e-posta adresi tespit edildi! Örn: username@example.com";
            echo json_encode($ReturnData);
            exit();
        } 

        $Login = $connection->prepare("SELECT * FROM tblstudents  
        WHERE 
        tblStudentEmail= :tblStudentEmail 
        AND
        tblStudentPassword= :tblStudentPassword
         ");

        
        $Login->bindParam(":tblStudentEmail", $Email, PDO::PARAM_STR); 
        $Login->bindParam(":tblStudentPassword", $Password, PDO::PARAM_STR); 

        if ($Login->execute()) {

            $_SESSION["StudentEmail"] = $Email;

            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "CourseX"; 
            $ReturnData["message"] = "Oturumunuz başarıyla açıldı. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "CourseX güncellenmedi. (" . http_response_code(400) . ")";
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