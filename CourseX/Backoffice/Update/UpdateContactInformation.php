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

        $GetContactInformationData = json_decode(file_get_contents("php://input"));
        $InputCompanyTitle = xss_clean(securty($GetContactInformationData->InputCompanyTitle)); 
        $InputCorporateEmail = xss_clean(securty($GetContactInformationData->InputCorporateEmail)); 
        $InputCorporateSupportEmail = xss_clean(securty($GetContactInformationData->InputCorporateSupportEmail)); 
        $InputPhone = xss_clean(securty($GetContactInformationData->InputPhone)); 
        $InputGsmPhone = xss_clean(securty($GetContactInformationData->InputGsmPhone)); 
        $InputAddres = xss_clean(securty($GetContactInformationData->InputAddres)); 
        $InputCity = xss_clean(securty($GetContactInformationData->SelectedCity)); 
        $InputDistrict = xss_clean(securty($GetContactInformationData->SelectedNeighbourhood)); 
        
        $UpdateContactInformation = $connection->prepare("UPDATE tblsettings SET
        tblSettingCompanyTitle= :tblSettingCompanyTitle,
        tblSettingEmail= :tblSettingEmail,
        tblSettingSupportEmail= :tblSettingSupportEmail,
        tblSettingPhone= :tblSettingPhone,
        tblSettingGsm= :tblSettingGsm,
        tblSettingAddress= :tblSettingAddress,
        tblSettingCity= :tblSettingCity,
        tblSettingDistrict= :tblSettingDistrict
        WHERE tblSettingId=1");

        $UpdateContactInformation->bindParam(":tblSettingCompanyTitle", $InputCompanyTitle, PDO::PARAM_STR);  
        $UpdateContactInformation->bindParam(":tblSettingEmail", $InputCorporateEmail, PDO::PARAM_STR);  
        $UpdateContactInformation->bindParam(":tblSettingSupportEmail", $InputCorporateSupportEmail, PDO::PARAM_STR);  
        $UpdateContactInformation->bindParam(":tblSettingPhone", $InputPhone, PDO::PARAM_STR);  
        $UpdateContactInformation->bindParam(":tblSettingGsm", $InputGsmPhone, PDO::PARAM_STR);  
        $UpdateContactInformation->bindParam(":tblSettingAddress", $InputAddres, PDO::PARAM_STR);  
        $UpdateContactInformation->bindParam(":tblSettingCity", $InputCity, PDO::PARAM_STR);  
        $UpdateContactInformation->bindParam(":tblSettingDistrict", $InputDistrict, PDO::PARAM_STR);  

        if ($UpdateContactInformation->execute()) {

            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "İletişim Bilgileri"; 
            $ReturnData["message"] = "İletişim bilgileri başarıyla güncellendi. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "İletişim Bilgileri"; 
            $ReturnData["message"] = "İletişim bilgileri güncellenmedi. (" . http_response_code(400) . ")";
            echo json_encode($ReturnData);

            exit();
        }

    } catch (Exception $e) {

        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "İletişim Bilgileri"; 
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>