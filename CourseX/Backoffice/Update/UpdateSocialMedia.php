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

        $GetSocialMediaData = json_decode(file_get_contents("php://input"));
        $InputFacebook = xss_clean(securty($GetSocialMediaData->InputFacebook));  
        $InputInstagram = xss_clean(securty($GetSocialMediaData->InputInstagram));  
        $InputTwitter = xss_clean(securty($GetSocialMediaData->InputTwitter));  
        $InputLinkedin = xss_clean(securty($GetSocialMediaData->InputLinkedin));  
        $InputYoutube = xss_clean(securty($GetSocialMediaData->InputYoutube));  
        
        $UpdateSocialMedia = $connection->prepare("UPDATE tblsettings SET
        tblSettingFacebook= :tblSettingFacebook,
        tblSettingInstagram= :tblSettingInstagram,
        tblSettingTwitter= :tblSettingTwitter,
        tblSettingLinkedin= :tblSettingLinkedin,
        tblSettingYoutube= :tblSettingYoutube
        WHERE tblSettingId=1");

        $UpdateSocialMedia->bindParam(":tblSettingFacebook", $InputFacebook, PDO::PARAM_STR); 
        $UpdateSocialMedia->bindParam(":tblSettingInstagram", $InputInstagram, PDO::PARAM_STR); 
        $UpdateSocialMedia->bindParam(":tblSettingTwitter", $InputTwitter, PDO::PARAM_STR); 
        $UpdateSocialMedia->bindParam(":tblSettingLinkedin", $InputLinkedin, PDO::PARAM_STR); 
        $UpdateSocialMedia->bindParam(":tblSettingYoutube", $InputYoutube, PDO::PARAM_STR); 

        if ($UpdateSocialMedia->execute()) {

            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "Sosyal Medya Hesap Ayarları"; 
            $ReturnData["message"] = "Sosyal Medya hesapları başarıyla güncellendi. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "Sosyal Medya Hesap Ayarları"; 
            $ReturnData["message"] = "Sosyal Medya hesapları güncellenmedi. (" . http_response_code(400) . ")";
            echo json_encode($ReturnData);

            exit();
        }

    } catch (Exception $e) { 
        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Sosyal Medya Hesap Ayarları"; 
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>