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
          
        $Arrangement = xss_clean(securty($_POST["Arrangement"]));   
        $Title = xss_clean(securty($_POST["Title"])); 

        if ($_FILES["CourseFile"]["size"] > 0) {

            //100 MB 
            if ($_FILES['CourseFile']['size'] > 10240000) {

                $ReturnData["icon"] = "warning";
                $ReturnData["title"] = "Kurs İçerik Durumu:";
                $ReturnData["message"] = "Dosya boyutu maksimum 100MB olmalıdır. ";
                echo json_encode($ReturnData);
                exit();

            } else {
                $izinli_uzantilar = array("mp4","avi","pdf");

                $ext = strtolower(substr($_FILES['CourseFile']["name"], strpos($_FILES['CourseFile']["name"], '.') + 1));

                if (in_array($ext, $izinli_uzantilar) === false) {

                    $ReturnData["icon"] = "warning";
                    $ReturnData["title"] = "Kurs İçerik Durumu:";
                    $ReturnData["message"] = "Lütfen geçerli bir dosya seçiniz. İzin verilen dosya uzantıları(JPG,PNG,WEBP) " . " (" . http_response_code(400) . ")";
                    echo json_encode($ReturnData);
                    exit();

                } else {
                   
                    @$tmp_name = $_FILES['CourseFile']["tmp_name"];
                    @$name = seo($_FILES['CourseFile']["name"]);
                    $uploads_dir = '../../cdn/courses';
                    $uniq = seo($Title)."-videos-".uniqid().$_SESSION["CourseID"];
                    $FileUrl = substr($uploads_dir, 6) . "/" . $uniq . "." . $ext;
                    @move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

                    $AddCourseContent = $connection->prepare("INSERT INTO tblcoursedetails SET
                    CourseId= :CourseId, 
                    CourseArrangement= :CourseArrangement,  
                    FileUrl= :FileUrl,  
                    CourseTitle= :CourseTitle  ");

                    $AddCourseContent->bindParam(":CourseId",$_SESSION["CourseID"], PDO::PARAM_INT); 
                    $AddCourseContent->bindParam(":CourseArrangement", $Arrangement, PDO::PARAM_INT); 
                    $AddCourseContent->bindParam(":FileUrl", $FileUrl, PDO::PARAM_STR); 
                    $AddCourseContent->bindParam(":CourseTitle", $Title, PDO::PARAM_STR);  
                    
                    if ($AddCourseContent->execute()) {

                        $ReturnData["icon"] = "success";
                        $ReturnData["title"] = "Kurs İçerik Durumu:";
                        $ReturnData["message"] = "Kurs içeriği başarıyla oluşturuldu! (" . http_response_code() . ")";
                        echo json_encode($ReturnData);
                        exit();

                    } else {

                        $ReturnData["icon"] = "error";
                        $ReturnData["title"] = "Kurs İçerik Durumu:";
                        $ReturnData["message"] = "Kurs içeriği oluşturulamadı! (" . http_response_code(400) . ")";
                        echo json_encode($ReturnData); 
                        exit();
                    }
                }
            }
        }else{
            $ReturnData["icon"] = "warning";
            $ReturnData["title"] = "Kurs İçerik Durumu:";
            $ReturnData["message"] = "Lütfen bir dosya seçiniz! (" . http_response_code(400) . ")";
            echo json_encode($ReturnData); 
            exit();
        }
    } catch (Exception $e) { 
        
        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "Kurs İçerik Durumu:"; 
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . " (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>