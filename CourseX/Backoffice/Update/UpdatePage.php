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

        $GetPage = json_decode(file_get_contents("php://input"));
        $PageArrangement = xss_clean(securty($GetPage->PageArrangement));
        $PageTitle = xss_clean(securty($GetPage->PageTitle));
        $PageDetail = xss_clean(securty($GetPage->PageDetail));
        $Seourl = seo($PageTitle);
         
        $UpdatePage = $connection->prepare("UPDATE tblpages SET
        tblPageTitle= :tblPageTitle,
        tblPageSeoUrl= :tblPageSeoUrl,
        tblPageDetail= :tblPageDetail,
        tblPageArrangement= :tblPageArrangement 
        WHERE tblPageId= :tblPageId ");

        $UpdatePage->bindParam(":tblPageId", $_SESSION["tblPageId"], PDO::PARAM_INT);
        $UpdatePage->bindParam(":tblPageTitle", $PageTitle, PDO::PARAM_STR);
        $UpdatePage->bindParam(":tblPageSeoUrl", $Seourl, PDO::PARAM_STR);
        $UpdatePage->bindParam(":tblPageDetail", $PageDetail, PDO::PARAM_STR);
        $UpdatePage->bindParam(":tblPageArrangement", $PageArrangement, PDO::PARAM_INT);

        if ($UpdatePage->execute()) {

            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "Kurumsal Sayfa:"; 
            $ReturnData["message"] = "Sayfa güncellendi. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "Kurumsal Sayfa:";
            $ReturnData["message"] = "Sayfa güncellendi. (" . http_response_code(400) . ")";
            echo json_encode($ReturnData); 
            exit();
        }

    } catch (Exception $e) {

        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Kurumsal Sayfa:";
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . ". (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>