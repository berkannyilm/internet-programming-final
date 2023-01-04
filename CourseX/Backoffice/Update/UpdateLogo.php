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

        if ($_FILES["LogoImageUrl"]["size"] > 0) {

            if ($_FILES['LogoImageUrl']['size'] > 1048570) {

                $ReturnData["icon"] = "warning";
                $ReturnData["title"] = "Logo Ayarları";
                $ReturnData["message"] = "Dosya boyutu maksimum 1MB olmalıdır. ";
                echo json_encode($ReturnData);
                exit();

            } else {
                $izinli_uzantilar = array('jpg', 'webp', 'png');

                $ext = strtolower(substr($_FILES['LogoImageUrl']["name"], strpos($_FILES['LogoImageUrl']["name"], '.') + 1));

                if (in_array($ext, $izinli_uzantilar) === false) {

                    $ReturnData["icon"] = "warning";
                    $ReturnData["title"] = "Logo Ayarları";
                    $ReturnData["message"] = "Lütfen geçerli bir dosya seçiniz. İzin verilen dosya uzantıları(JPG,PNG,WEBP) " . " (" . http_response_code(400) . ")";
                    echo json_encode($ReturnData);
                    exit();

                } else {

                    @$tmp_name = $_FILES['LogoImageUrl']["tmp_name"];
                    @$name = seo($_FILES['LogoImageUrl']["name"]);
                    $uploads_dir = '../../cdn/images/logo';
                    $uniq = uniqid();
                    $refimgyol = substr($uploads_dir, 6) . "/" . $uniq . "." . $ext;
                    @move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

                    $UpdateLogo = $connection->prepare("UPDATE tblsettings SET
                    tblSettingLogoUrl= :tblSettingLogoUrl
                    WHERE tblSettingId=1");
                    $UpdateLogo->bindParam(":tblSettingLogoUrl", $refimgyol, PDO::PARAM_STR);

                    if ($UpdateLogo->execute()) {

                        unlink("../../" . $_SESSION["CurrentSystemLogo"]);
                        $ReturnData["icon"] = "success";
                        $ReturnData["title"] = "Logo Ayarları";
                        $ReturnData["message"] = "Yeni logo başarıyla güncellendi " . " (" . http_response_code(200) . ")";
                        echo json_encode($ReturnData);
                        exit();

                    } else {

                        $ReturnData["icon"] = "error";
                        $ReturnData["title"] = "Logo Ayarları";
                        $ReturnData["message"] = "Yeni logo yüklenmedi. " . " (" . http_response_code(400) . ")";
                        echo json_encode($ReturnData);
                        exit();
                    }
                }
            }
        } else {
            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "Logo Ayarları";
            $ReturnData["message"] = "Lütfen bir dosya seçiniz. " . " (" . http_response_code(400) . ")";
            echo json_encode($ReturnData);
            exit();
        }

    } catch (Exception $e) {

        $ReturnData["title"] = "Hata: ";
        $ReturnData["msgtype"] = "alert alert-danger";
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>