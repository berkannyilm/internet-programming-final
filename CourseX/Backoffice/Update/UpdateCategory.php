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

        $GetCategory = json_decode(file_get_contents("php://input"));
        $CategoryTitle = xss_clean(securty($GetCategory->CategoryTitle));
        $CategorySeoUrl = seo($CategoryTitle);
        $CategoryId = xss_clean(securty($GetCategory->CategoryId));
         
        $UpdateCategory = $connection->prepare("UPDATE tblcoursecategories SET
        tblCourseCategoryTitle= :tblCourseCategoryTitle,
        tblCourseCategorySeoUrl= :tblCourseCategorySeoUrl
        WHERE tblCourseCategoryId= :tblCourseCategoryId ");

        $UpdateCategory->bindParam(":tblCourseCategoryId", $CategoryId, PDO::PARAM_INT);
        $UpdateCategory->bindParam(":tblCourseCategoryTitle", $CategoryTitle, PDO::PARAM_STR);
        $UpdateCategory->bindParam(":tblCourseCategorySeoUrl", $CategorySeoUrl, PDO::PARAM_STR);

        if ($UpdateCategory->execute()) {

            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "Kategori:"; 
            $ReturnData["message"] = "Seçili kategori başarıyla güncellendi. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "Kategori:";
            $ReturnData["message"] = "Seçili kategori güncellenemedi. (" . http_response_code(400) . ")";
            echo json_encode($ReturnData); 
            exit();
        }

    } catch (Exception $e) {

        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Kategori:";
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . ". (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>