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
        $InputPassword = xss_clean(securty($_POST["InputPassword"]));   
        $InputPhone = xss_clean(securty($_POST["InputPhone"]));   
        $InputDetail = $_POST["InputDetail"];
        $UpdatedDate = date("yyyy-MM-dd H:is");
        
        if ($_FILES) {

            if ($_FILES['ProfileImageUrl']['size'] > 1048570) {

                $ReturnData["icon"] = "warning";
                $ReturnData["title"] = "Eğitmen Bilgi Güncelleme Durumu:";
                $ReturnData["message"] = "Dosya boyutu maksimum 1MB olmalıdır. ";
                echo json_encode($ReturnData);
                exit();

            } else {
                $izinli_uzantilar = array('jpg', 'webp', 'png');

                $ext = strtolower(substr($_FILES['ProfileImageUrl']["name"], strpos($_FILES['ProfileImageUrl']["name"], '.') + 1));

                if (in_array($ext, $izinli_uzantilar) === false) {

                    $ReturnData["icon"] = "warning";
                    $ReturnData["title"] = "Eğitmen Bilgi Güncelleme Durumu:";
                    $ReturnData["message"] = "Lütfen geçerli bir dosya seçiniz. İzin verilen dosya uzantıları(JPG,PNG,WEBP) " . " (" . http_response_code(400) . ")";
                    echo json_encode($ReturnData);
                    exit();

                } else {
                    $InputPassword = sha1(md5(sha1($InputPassword)));
                    $InputPassword = substr($InputPassword, 7, 18);
 
                    @$tmp_name = $_FILES['ProfileImageUrl']["tmp_name"];
                    @$name = seo($_FILES['ProfileImageUrl']["name"]);
                    $uploads_dir = '../../cdn/images/instructors';
                    $uniq = uniqid();
                    $ImageUrl = substr($uploads_dir, 6) . "/" . $uniq . "." . $ext;
                    @move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

                    $UpdateInstructor = $connection->prepare("UPDATE tblinstructors SET
                    tblInstructorFirstname= :tblInstructorFirstname, 
                    tblInstructorLastname= :tblInstructorLastname,   
                    tblInstructorPassword= :tblInstructorPassword,
                    tblInstructorDetail= :tblInstructorDetail,
                    tblInstructorPhone= :tblInstructorPhone, 
                    tblInstructorLastUpdatedDate= :tblInstructorLastUpdatedDate,
                    tblInstructorImageUrl= :tblInstructorImageUrl
                    WHERE tblInstructorId= :tblInstructorId ");

                    $UpdateInstructor->bindParam(":tblInstructorId", $_SESSION["InstructorId"], PDO::PARAM_INT);
                    $UpdateInstructor->bindParam(":tblInstructorImageUrl", $ImageUrl, PDO::PARAM_STR); 
                    $UpdateInstructor->bindParam(":tblInstructorLastUpdatedDate", $UpdatedDate, PDO::PARAM_STR);
                    $UpdateInstructor->bindParam(":tblInstructorPhone", $InputPhone, PDO::PARAM_STR);
                    $UpdateInstructor->bindParam(":tblInstructorDetail", $InputDetail, PDO::PARAM_STR);
                    $UpdateInstructor->bindParam(":tblInstructorFirstname", $InputFirstname, PDO::PARAM_STR);
                    $UpdateInstructor->bindParam(":tblInstructorLastname", $InputLastname, PDO::PARAM_STR); 
                    $UpdateInstructor->bindParam(":tblInstructorPassword", $InputPassword, PDO::PARAM_STR);

                    if ($UpdateInstructor->execute()) {
                        unlink("../../" . $_SESSION["ImageUrl"]);
                        $ReturnData["icon"] = "success";
                        $ReturnData["title"] = "Eğitmen Bilgi Güncelleme Durumu:";
                        $ReturnData["message"] = "Eğitmen bilgileri başarıyla güncellendi! (" . http_response_code() . ")";
                        echo json_encode($ReturnData);
                        exit();

                    } else {

                        $ReturnData["icon"] = "error";
                        $ReturnData["title"] = "Eğitmen Bilgi Güncelleme Durumu:";
                        $ReturnData["message"] = "Eğitmen bilgileri güncellenmedi (" . http_response_code(400) . ")";
                        echo json_encode($ReturnData); 
                        exit();
                    }
                }
            }
        }else{

            $UpdateInstructor = $connection->prepare("UPDATE tblinstructors SET
            tblInstructorFirstname= :tblInstructorFirstname, 
            tblInstructorLastname= :tblInstructorLastname, 
            tblInstructorPassword= :tblInstructorPassword,
            tblInstructorDetail= :tblInstructorDetail,
            tblInstructorPhone= :tblInstructorPhone,
            tblInstructorLastUpdatedDate= :tblInstructorLastUpdatedDate
            WHERE tblInstructorId= :tblInstructorId ");

            $UpdateInstructor->bindParam(":tblInstructorId", $_SESSION["InstructorId"], PDO::PARAM_INT); 
            $UpdateInstructor->bindParam(":tblInstructorPhone", $InputPhone, PDO::PARAM_STR);
            $UpdateInstructor->bindParam(":tblInstructorDetail", $InputDetail, PDO::PARAM_STR);
            $UpdateInstructor->bindParam(":tblInstructorLastUpdatedDate", $UpdatedDate, PDO::PARAM_STR); 
            $UpdateInstructor->bindParam(":tblInstructorFirstname", $InputFirstname, PDO::PARAM_STR);
            $UpdateInstructor->bindParam(":tblInstructorLastname", $InputLastname, PDO::PARAM_STR);
            $UpdateInstructor->bindParam(":tblInstructorPassword", $InputPassword, PDO::PARAM_STR);


            if ($UpdateInstructor->execute()) { 

                $ReturnData["icon"] = "success";
                $ReturnData["title"] = "Eğitmen Bilgi Güncelleme Durumu:";
                $ReturnData["message"] = "Eğitmen bilgileri başarıyla güncellendi! (" . http_response_code() . ")";
                echo json_encode($ReturnData);
                exit();

            } else {

                $ReturnData["icon"] = "error";
                $ReturnData["title"] = "Eğitmen Bilgi Güncelleme Durumu:";
                $ReturnData["message"] = "Eğitmen bilgileri güncellenmedi (" . http_response_code(400) . ")";
                echo json_encode($ReturnData); 
                exit();
            }
        }
    } catch (Exception $e) { 
        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Eğitmen Bilgi Güncelleme Durumu:"; 
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code(500) . ")";
        echo json_encode($ReturnData);
        exit();
    } 
}
?>