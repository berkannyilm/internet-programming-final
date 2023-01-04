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
         
        $AddCategory = $connection->prepare("INSERT INTO tblcoursecategories SET
        tblCourseCategoryTitle= :tblCourseCategoryTitle,
        tblCourseCategorySeoUrl= :tblCourseCategorySeoUrl ");

        $AddCategory->bindParam(":tblCourseCategoryTitle", $CategoryTitle, PDO::PARAM_STR);
        $AddCategory->bindParam(":tblCourseCategorySeoUrl", $CategorySeoUrl, PDO::PARAM_STR);

        if ($AddCategory->execute()) {

            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "Kategori:"; 
            $ReturnData["message"] = "Kategori oluşturuldu. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "Kategori:";
            $ReturnData["message"] = "Kategori oluşturulamadı. (" . http_response_code(400) . ")";
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