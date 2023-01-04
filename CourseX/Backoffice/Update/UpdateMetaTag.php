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

        $GetMetaTagData = json_decode(file_get_contents("php://input"));
        $MetaTagTitle = xss_clean(securty($GetMetaTagData->MetaTagTitle));
        $MetaTagDescription = xss_clean(securty($GetMetaTagData->MetaTagDescription));
        
        
        $UpdateMetaTag = $connection->prepare("UPDATE tblsettings SET
        tblSettingTitle= :tblSettingTitle,
        tblSettingDescription= :tblSettingDescription
        WHERE tblSettingId=1");

        $UpdateMetaTag->bindParam(":tblSettingTitle", $MetaTagTitle, PDO::PARAM_STR);
        $UpdateMetaTag->bindParam(":tblSettingDescription", $MetaTagDescription, PDO::PARAM_STR);

        if ($UpdateMetaTag->execute()) {

            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "Meta Tag Ayarları"; 
            $ReturnData["message"] = "Meta Tag ayarları güncellendi. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "Meta Tag Ayarları";
            $ReturnData["message"] = "Meta Tag ayarları güncellenmedi. (" . http_response_code(400) . ")";
            echo json_encode($ReturnData); 
            exit();
        }

    } catch (Exception $e) {

        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Meta Tag Ayarları";
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . ". (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>