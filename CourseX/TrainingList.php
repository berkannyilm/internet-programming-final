<?php require_once("Header2.php");

$GetMyTrainingList = $connection->prepare("SELECT * FROM 
tblorders 
INNER JOIN tblcourses ON tblorders.tblOrderCourseId=tblcourses.tblCourseId
WHERE 
tblOrderStudentId = :tblOrderStudentId");
$GetMyTrainingList->bindParam(":tblOrderStudentId", $_SESSION["StudentId"], PDO::PARAM_INT);
$GetMyTrainingList->execute();

if(!$GetMyTrainingList->rowCount()){
    header("Location:Courses");
}
?>
<!-- PAGE TITLE
    ================================================== -->
<header class="py-8 py-md-4" style="background-image: none;">
    <div class="container text-center py-xl-2">
        <h1 class="display-4 fw-semi-bold mb-0">Öğrenim İçeriğim</h1>

    </div>
    <!-- Img -->
    <img class="d-none img-fluid" src="..." alt="...">
</header>


<!-- SHOP CART
    ================================================== -->
<div class="container pb-6 pb-xl-6">
    <div class="row">
        <div id="primary" class="content-area">
            <main id="main" class="site-main ">
                <div class="page type-page status-publish hentry">
                    <!-- .entry-header -->
                    <div class="entry-content">
                        <div class="woocommerce bg_primary">
                            <form class="woocommerce-cart-form table-responsive" action="#" method="post">
                                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
                                    <thead class="bg_primary">
                                        <tr>
                                            <th class="product-name text-center">Kurs</th>
                                            </th>
                                            <th class="product-name text-center">Satın Alınma Tarihi</th>
                                            </th>
                                            <th class="product-quantity text-center">Seçenek</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                        foreach ($GetMyTrainingList->fetchAll() as $TrainingList) { ?>

                                        <tr class="woocommerce-cart-form__cart-item cart_item">
                                            <td class="product-name text-center" data-title="Product">
                                                <img src="<?php echo $TrainingList["tblCourseImageUrl"] ?>"
                                                    alt="<?php echo $TrainingList["tblCourseTitle"] ?>">
                                            </td>

                                            <td class="product-price text-center" data-title="Price">
                                                <?php echo $TrainingList["tblOrderCreatedDate"] ?>
                                            </td>

                                            <td class="product-price text-center" data-title="Price">
                                              <a class="btn btn-primary" href="kurs-izle-<?php echo $TrainingList["tblCourseSeoUrl"]."-".$TrainingList["tblCourseId"] ?>"><i class="fa fa-play"></i></a>
                                            </td>


                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <!-- .entry-content -->
                </div>
            </main>
        </div>
    </div>
</div>
<?php require_once("Footer.php"); ?>