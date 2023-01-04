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
        
 
        $InputFirstname = xss_clean(securty($_POST["InputFirstname"]));   
        $InputLastname = xss_clean(securty($_POST["InputLastname"]));   
        $InputEmail = xss_clean(securty($_POST["InputEmail"]));   
        $InputPassword = xss_clean(securty($_POST["InputPassword"]));   
        $InputPhone = xss_clean(securty($_POST["InputPhone"]));   
        $InputDetail = xss_clean(securty($_POST["InputDetail"]));

        if ($_FILES["ProfileImageUrl"]["size"] > 0) {

            if ($_FILES['ProfileImageUrl']['size'] > 1048570) {

                $ReturnData["icon"] = "warning";
                $ReturnData["title"] = "Eğitmen Ekle";
                $ReturnData["message"] = "Dosya boyutu maksimum 1MB olmalıdır. ";
                echo json_encode($ReturnData);
                exit();

            } else {
                $izinli_uzantilar = array('jpg', 'webp', 'png');

                $ext = strtolower(substr($_FILES['ProfileImageUrl']["name"], strpos($_FILES['ProfileImageUrl']["name"], '.') + 1));

                if (in_array($ext, $izinli_uzantilar) === false) {

                    $ReturnData["icon"] = "warning";
                    $ReturnData["title"] = "Eğitmen Ekle";
                    $ReturnData["message"] = "Lütfen geçerli bir dosya seçiniz. İzin verilen dosya uzantıları(JPG,PNG,WEBP) " . " (" . http_response_code(400) . ")";
                    echo json_encode($ReturnData);
                    exit();

                } else {
                    $InputPassword = sha1(md5(sha1($InputPassword)));
                    $InputPassword = substr($InputPassword, 7, 18);

                    $InputEmail = filter_var($InputEmail, FILTER_SANITIZE_EMAIL);
                    if (!filter_var($InputEmail, FILTER_VALIDATE_EMAIL)) {

                        $ReturnData["icon"] = "error";
                        $ReturnData["title"] = "Eğitmen Ekle";
                        $ReturnData["message"] = "Geçersiz bir e-posta adresi tespit edildi! Örn: username@example.com";
                        echo json_encode($ReturnData);
                        exit();
                    }

                    $CheckInstructor = $connection->prepare("SELECT * FROM tblinstructors WHERE tblInstructorEmail= :tblInstructorEmail");
                    $CheckInstructor->bindParam(":tblInstructorEmail", $InputEmail, PDO::PARAM_STR);
                    $CheckInstructor->execute();
                    if ($CheckInstructor->rowCount()) {

                        $ReturnData["icon"] = "warning";
                        $ReturnData["title"] = "Eğitmen Ekle";
                        $ReturnData["message"] = "Bu e-posta adresi zaten kullanılmış!";
                        echo json_encode($ReturnData);
                        exit();
                    }

                    @$tmp_name = $_FILES['ProfileImageUrl']["tmp_name"];
                    @$name = seo($_FILES['ProfileImageUrl']["name"]);
                    $uploads_dir = '../../cdn/images/instructors';
                    $uniq = uniqid();
                    $ImageUrl = substr($uploads_dir, 6) . "/" . $uniq . "." . $ext;
                    @move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

                    $AddInstructor = $connection->prepare("INSERT INTO tblinstructors SET
                    tblInstructorFirstname= :tblInstructorFirstname, 
                    tblInstructorLastname= :tblInstructorLastname,  
                    tblInstructorEmail= :tblInstructorEmail,  
                    tblInstructorPassword= :tblInstructorPassword,
                    tblInstructorDetail= :tblInstructorDetail,
                    tblInstructorPhone= :tblInstructorPhone,
                    tblInstructorImageUrl= :tblInstructorImageUrl
                    ");

                    $AddInstructor->bindParam(":tblInstructorImageUrl", $ImageUrl, PDO::PARAM_STR);
                    $AddInstructor->bindParam(":tblInstructorPhone", $InputPhone, PDO::PARAM_STR);
                    $AddInstructor->bindParam(":tblInstructorDetail", $InputDetail, PDO::PARAM_STR);
                    $AddInstructor->bindParam(":tblInstructorFirstname", $InputFirstname, PDO::PARAM_STR);
                    $AddInstructor->bindParam(":tblInstructorLastname", $InputLastname, PDO::PARAM_STR);
                    $AddInstructor->bindParam(":tblInstructorEmail", $InputEmail, PDO::PARAM_STR);
                    $AddInstructor->bindParam(":tblInstructorPassword", $InputPassword, PDO::PARAM_STR);

                    if ($AddInstructor->execute()) {

                        $ReturnData["icon"] = "success";
                        $ReturnData["title"] = "Eğitmen Ekle";
                        $ReturnData["message"] = "Eğitmen başarıyla eklendi! (" . http_response_code() . ")";
                        echo json_encode($ReturnData);
                        exit();

                    } else {

                        $ReturnData["icon"] = "error";
                        $ReturnData["title"] = "Eğitmen Ekle";
                        $ReturnData["message"] = "Eğitmen eklenirken bir sorun oluştu! (" . http_response_code(400) . ")";
                        echo json_encode($ReturnData); 
                        exit();
                    }
                }
            }
        }else{
            $ReturnData["icon"] = "warning";
            $ReturnData["title"] = "Eğitmen Ekle";
            $ReturnData["message"] = "Lütfen bir dosya seçiniz! (" . http_response_code(400) . ")";
            echo json_encode($ReturnData); 
            exit();
        }
    } catch (Exception $e) { 
        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Eğitmen Ekle"; 
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>