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
        $newsletterEmail = xss_clean(securty($GetData->newsletterEmail)); 
        
        $newsletterEmail = filter_var($newsletterEmail, FILTER_SANITIZE_EMAIL);
        if (!filter_var($newsletterEmail, FILTER_VALIDATE_EMAIL)) {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "Geçersiz bir e-posta adresi tespit edildi! Örn: username@example.com";
            echo json_encode($ReturnData);
            exit();
        }

        $CheckEmail = $connection->prepare("SELECT * FROM tblnewsletters WHERE tblNewsletterEmail= :tblNewsletterEmail");
        $CheckEmail->bindParam(":tblNewsletterEmail", $newsletterEmail, PDO::PARAM_STR);
        $CheckEmail->execute();
        if ($CheckEmail->rowCount()) {

            $ReturnData["icon"] = "warning";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "Bu e-posta adresi zaten abone edilmiş!";
            echo json_encode($ReturnData);
            exit();
        }
        
        $AddNewsletter = $connection->prepare("INSERT INTO tblnewsletters SET
        tblNewsletterEmail= :tblNewsletterEmail  ");

        $AddNewsletter->bindParam(":tblNewsletterEmail", $newsletterEmail, PDO::PARAM_STR);  

        if ($AddNewsletter->execute()) {
 
            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "CourseX"; 
            $ReturnData["message"] = "Artık tüm yeni kurs ve duyurulardan haberdarsın. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "E-bülten aboneliğin oluşturulamadı. (" . http_response_code(400) . ")";
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