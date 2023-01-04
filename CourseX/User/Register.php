<?php

require_once("../Configuration/Connection.php");
require_once("../Configuration/Functions.php");

$accessMethod = array('POST');
$userAccessMethod = $_SERVER['REQUEST_METHOD'];

if (!in_array($userAccessMethod, $accessMethod)) {

    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
    exit();

} else {

    try {

        $GetData = json_decode(file_get_contents("php://input"));
        $Firstname = xss_clean(securty($GetData->Firstname)); 
        $Lastname = xss_clean(securty($GetData->Lastname)); 
        $Email = xss_clean(securty($GetData->Email)); 
        $Password = xss_clean(securty($GetData->Password)); 
        
        $Password = sha1(md5(sha1($Password)));
        $Password = substr($Password, 7, 18);

        $Email = filter_var($Email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "Geçersiz bir e-posta adresi tespit edildi! Örn: username@example.com";
            echo json_encode($ReturnData);
            exit();
        }

        $CheckStudent = $connection->prepare("SELECT * FROM tblstudents WHERE tblStudentEmail= :tblStudentEmail");
        $CheckStudent->bindParam(":tblStudentEmail", $Email, PDO::PARAM_STR);
        $CheckStudent->execute();
        if ($CheckStudent->rowCount()) {

            $ReturnData["icon"] = "warning";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "Bu e-posta adresi zaten kullanılmış!";
            echo json_encode($ReturnData);
            exit();
        }

        $Register = $connection->prepare("INSERT INTO tblstudents SET
        tblStudentFirstname= :tblStudentFirstname,
        tblStudentLastname= :tblStudentLastname,
        tblStudentEmail= :tblStudentEmail,
        tblStudentPassword= :tblStudentPassword
         ");

        $Register->bindParam(":tblStudentFirstname", $Firstname, PDO::PARAM_STR); 
        $Register->bindParam(":tblStudentLastname", $Lastname, PDO::PARAM_STR); 
        $Register->bindParam(":tblStudentEmail", $Email, PDO::PARAM_STR); 
        $Register->bindParam(":tblStudentPassword", $Password, PDO::PARAM_STR); 

        if ($Register->execute()) {

            $_SESSION["StudentEmail"] = $Email;
            $ReturnData["icon"] = "success";
            $ReturnData["title"] = "CourseX";
            $ReturnData["Url"] = "Courses";
            $ReturnData["status"] = 1;
            $ReturnData["message"] = "Üyeliğiniz başarıyla oluşturuldu. (" . http_response_code() . ")";
            echo json_encode($ReturnData);
            exit();

        } else {

            $ReturnData["icon"] = "error";
            $ReturnData["title"] = "CourseX";
            $ReturnData["message"] = "CourseX güncellenmedi. (" . http_response_code(400) . ")";
            echo json_encode($ReturnData); 
            exit();
        }

    } catch (Exception $e) {

        $ReturnData["icon"] = "error";
        $ReturnData["title"] = "CourseX";
        $ReturnData["message"] = "Bilinmeyen bir hata oluştu: " . $e . ". (" . http_response_code(400) . ")";
        echo json_encode($ReturnData);
        exit();
    }


}
?>