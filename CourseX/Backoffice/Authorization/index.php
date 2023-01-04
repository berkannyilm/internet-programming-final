<?php
use FFI\Exception;

require_once("../Configuration/Database.php");
require_once("../Configuration/Functions.php");

$accessMethod = array('POST');
$userAccessMethod = $_SERVER['REQUEST_METHOD'];

if (!in_array($userAccessMethod, $accessMethod)) {

    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
    exit();

} else {
    try {

        $GetData = json_decode(file_get_contents("php://input"));
        $GetEmail = strtolower($GetData->managerEmail);
        $GetPassword = $GetData->managerPassword;

        $EmailFilter = filter_var($GetEmail, FILTER_SANITIZE_EMAIL);
        if (!filter_var($EmailFilter, FILTER_VALIDATE_EMAIL)) {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "Hata:";
            $ReturnData["message"] = "Geçersiz bir e-posta adresi tespit edildi! Örn: username@example.com";
            echo json_encode($ReturnData);
            exit();

        }

        if (empty($GetEmail) || empty($GetPassword)) {

            $ReturnData["icon"] = "warning";
            $ReturnData["title"] = "Uyarı";
            $ReturnData["message"] = "Tüm alanları doldurduğunuzdan emin olunuz..";
            echo json_encode($ReturnData);
            exit();
        }
        $GetPassword = sha1(md5(sha1($GetPassword)));
        $GetPassword = substr($GetPassword, 6, 25);
        $UserLoginQuery = $connection->prepare("SELECT * FROM tblmanagers 
        WHERE
        tblManagerEmail= :tblManagerEmail
        AND tblManagerPassword= :tblManagerPassword
        AND tblManagerStatus IN('ACTIVE')
        AND tblManagerPub IN('ADMINISTRATOR', 'MODERATOR')");

        $UserLoginQuery->bindParam(":tblManagerEmail", $GetEmail, PDO::PARAM_STR);
        $UserLoginQuery->bindParam(":tblManagerPassword", $GetPassword, PDO::PARAM_STR);
        $UserLoginQuery->execute();

        if ($UserLoginQuery->rowCount() == 1) {

            $_SESSION["MANAGMENT_USER"] = base64_encode($GetEmail);
            $_SESSION["MANAGMENT_PASSWORD"] = base64_encode($GetPassword);

            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "Sonuç:";
            $ReturnData["message"] = "Giriş işlemi başarıyla yapıldı..";
            $ReturnData["redirectURL"] = "Home";
            echo json_encode($ReturnData);
            exit();

        } else {
            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "Hata:";
            $ReturnData["message"] = "Girilen bilgilere ait bir kullanıcı bulunamadı, sistem yöneticinize danışın..";
            echo json_encode($ReturnData);
            exit();
        }
    } catch (Exception $e) {
        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Hata: ";
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code() . ")";
        echo json_encode($ReturnData);
        exit();
    }
}