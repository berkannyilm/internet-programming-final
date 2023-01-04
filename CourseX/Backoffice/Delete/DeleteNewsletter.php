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

        $GetStudent = json_decode(file_get_contents("php://input"));
        $NewsletterId= $GetStudent->NewsletterId;
         
        $DeleteNewsletter=$connection->prepare("DELETE FROM tblnewsletters 
        WHERE tblNewsletterId= :tblNewsletterId");
        $DeleteNewsletter->bindParam(":tblNewsletterId", $NewsletterId, PDO::PARAM_INT);
        if ($DeleteNewsletter->execute()) {

            $ReturnData["icon"] = "info";
            $ReturnData["title"] = "Hesap Durumu:";
            $ReturnData["message"] = "Seçilen abonelik başarıyla silindi. (" . http_response_code(200) . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["error"] = "warning";
            $ReturnData["title"] = "Hesap Durumu:"; 
            $ReturnData["message"] = "Seçilen abonelik silinemedi. (" . http_response_code(400) . ")";
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