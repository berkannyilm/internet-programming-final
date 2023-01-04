<?php require_once("Header2.php");

$PageId = xss_clean(securty(intval($_GET["PageId"])));

$GetPage = $connection->prepare("SELECT * FROM tblpages WHERE tblPageId= :tblPageId");
$GetPage->bindParam(":tblPageId", $PageId, PDO::PARAM_INT);
$GetPage->execute();
if ($GetPage->rowCount()>0) {
    $GetPage = $GetPage->fetch();
  }else{
      header("Location:Home");
      die;
  } 
?>

    <!-- PAGE TITLE
    ================================================== -->
    <header class="py-8 py-md-4" style="background-image: none;">
        <div class="container text-center py-xl-2">
            <h1 class="display-4 fw-semi-bold mb-0"><?php echo $GetPage["tblPageTitle"]; ?></h1> 
            
        </div> 
    </header>
 
    <!-- ABOUT V1
    ================================================== -->
    <div class="container pb-4 pb-xl-7">
        <div class="text-center mb-md-6 mb-4">
         
            <p class="w-xl-80 mx-auto line-height-md">
            <?php echo $GetPage["tblPageDetail"]; ?>
            </p>
        </div> 
    </div>
  
<?php require_once("Footer.php"); ?>