<?php
require_once("Header2.php");

$CourseId = xss_clean(securty($_GET["CourseId"]));

$GetCourse = $connection -> prepare("SELECT  
tblinstructors.*, tblcoursecategories.*, tblcourses.* FROM tblcourses 
INNER JOIN tblinstructors ON tblcourses.tblInstructorId=tblinstructors.tblInstructorId
INNER JOIN tblcoursecategories ON tblcourses.tblCourseCategoryId=tblcoursecategories.tblCourseCategoryId
WHERE
tblCourseCategoryStatus IN('Active')
AND 
tblInstructorStatus IN('Active')
AND 
tblCourseStatus IN('Active')
AND tblCourseId=?
");
$GetCourse->execute(array($CourseId)); 
if ($GetCourse->rowCount()>0) {
  $GetCourse = $GetCourse->fetch();
}else{
    header("Location:Courses");
    die;
} 
?>


<!-- PAGE HEADER
    ================================================== -->
<div class="position-relative pt-8 pt-xl-11">
    <div class="position-absolute top-0 right-0 left-0 overlay overlay-custom-left d-none d-xl-block">
        <img class="img-fluid" src="assets/img/covers/cover-19.jpg" alt="...">
    </div>
</div>

<!-- COURSE
    ================================================== -->
<div class="container" id="Cart">
    <div class="row mb-8">
        <div class="col-lg-8 mb-6 mb-lg-0 position-relative">
            <div class="course-single-white">
                <h1 class="me-xl-14 text-white">
                    <?php echo $GetCourse["tblCourseTitle"]; ?>
                </h1>
                <p class="me-xl-13 mb-5 text-white"> <?php echo $GetCourse["tblCourseSummary"]; ?></p>

            </div>

            <!-- COURSE META
                ================================================== -->
            <div class="d-md-flex align-items-center mb-5 course-single-white">
                <div class="border rounded-circle d-inline-block mb-4 mb-md-0 me-md-6 me-lg-4 me-xl-6 bg-white">
                    <div class="p-2">
                        <img src="<?php echo $GetCourse["tblInstructorImageUrl"]; ?>" class="rounded-circle" width="68"
                            height="68">
                    </div>
                </div>

                <div class="mb-4 mb-md-0 me-md-8 me-lg-4 me-xl-8">

                    <a href="#"
                        class="font-size-sm text-white"><?php echo $GetCourse["tblInstructorFirstname"]." ".$GetCourse["tblInstructorLastname"]; ?></a>
                    <h6 class="mb-0 text-white">oluşturuldu.</h6>
                </div>

                <div class="mb-4 mb-md-0 me-md-8 me-lg-4 me-xl-8">
                    <h6 class="mb-0 text-white">Kategori</h6>
                    <a href="#" class="font-size-sm text-white"><?php echo $GetCourse["tblCourseCategoryTitle"]; ?></a>
                </div>

            </div>

            <!-- COURSE INFO TAB
                ================================================== -->
            <ul id="pills-tab" class="nav course-tab-v1 border-bottom h4 my-8 pt-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-overview-tab" data-bs-toggle="pill" href="#pills-overview"
                        role="tab" aria-controls="pills-overview" aria-selected="true">Kurs Hakkında</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-curriculum-tab" data-bs-toggle="pill" href="#pills-curriculum"
                        role="tab" aria-controls="pills-curriculum" aria-selected="false">Kurs İçeriği</a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-overview" role="tabpanel"
                    aria-labelledby="pills-overview-tab">
                    <h3 class="">Kurs Açıklaması</h3>
                    <p class="mb-6 line-height-md"><?php echo $GetCourse["tblCourseDetail"]; ?></p>

                </div>

                <div class="tab-pane fade" id="pills-curriculum" role="tabpanel" aria-labelledby="pills-curriculum-tab">
                    <div id="accordionCurriculum">
                        <div class="border rounded shadow mb-6 overflow-hidden">
                            <div class="d-flex align-items-center" id="curriculumheadingOne">
                                <h5 class="mb-0 w-100">
                                    <button
                                        class="d-flex align-items-center p-5 min-height-80 text-dark fw-medium collapse-accordion-toggle line-height-one"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#CurriculumcollapseOne"
                                        aria-expanded="true" aria-controls="CurriculumcollapseOne">
                                        <span class="me-4 text-dark d-flex">
                                            <!-- Icon -->
                                            <svg width="15" height="2" viewbox="0 0 15 2" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect width="15" height="2" fill="currentColor"></rect>
                                            </svg>

                                            <svg width="15" height="16" viewbox="0 0 15 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 7H15V9H0V7Z" fill="currentColor"></path>
                                                <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor"></path>
                                            </svg>

                                        </span>
                                        <?php echo $GetCourse["tblCourseTitle"] ?> kursuna ait dersler listeleniyor.
                                    </button>
                                </h5>
                            </div>

                            <div id="CurriculumcollapseOne" class="collapse show" aria-labelledby="curriculumheadingOne"
                                data-parent="#accordionCurriculum">
                                <?php
                                $GetCourseDetails = $connection->prepare("SELECT * FROM tblcoursedetails 
                               WHERE CourseId =:CourseId 
                               ORDER BY CourseArrangement ASC
                               ");
                                $GetCourseDetails->bindParam(":CourseId", $CourseId, PDO::PARAM_INT);
                                $GetCourseDetails->execute();
                                foreach ($GetCourseDetails->fetchAll() as $CourseDetail) {?>

                                <div class="border-top px-5 py-4 min-height-70 d-md-flex align-items-center">
                                    <div class="d-flex align-items-center me-auto mb-4 mb-md-0">

                                        <div class="ms-4">
                                            <i class="fa fa-angle-right"></i>
                                            <?php echo $CourseDetail["CourseTitle"]; ?>
                                        </div>

                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                        </div>

                    </div>
                </div>




            </div>
        </div>

        <div class="col-lg-4">
            <!-- SIDEBAR FILTER
                ================================================== -->
            <div class="d-block d-block rounded border p-2 shadow mb-6 bg-white">

                <img width="100%" class="rounded shadow-light-lg" src="<?php echo $GetCourse["tblCourseImageUrl"]; ?>">

                <div class="pt-5 pb-4 px-5 px-lg-3 px-xl-5">
                    <div class="d-flex align-items-center mb-2">
                        <ins class="h2 mb-0"><?php echo $GetCourse["tblCoursePrice"]." ₺"; ?></ins>

                    </div>
                    <?php 
                    if(empty($_SESSION["StudentEmail"]) || !isset($_SESSION["StudentEmail"])){?>
                    <a class="btn btn-primary btn-block mb-3" href="Login" name="button">Giriş Yap</a>
                    <?php } else {
                        $CheckCourseInCart = $connection->prepare("SELECT * FROM tblcarts WHERE tblCourseId= :CourseId");
                        $CheckCourseInCart->bindParam(":CourseId", $CourseId, PDO::PARAM_INT);
                        $CheckCourseInCart->execute();
                        if ($CheckCourseInCart->rowCount() > 0) {
                            echo "Bu kurs zaten sepete eklenmiş!";
                        } else { ?>
                    <a class="btn btn-primary btn-block mb-3" @click="addToCart(<?php echo $CourseId; ?>);"
                        name="button">Sepete Ekle</a>
                    <?php }
                    } ?>

                </div>
            </div>
        </div>
    </div>
    <?php
        $RelatedCourse=$connection->prepare("SELECT  
        tblinstructors.*, tblcoursecategories.*, tblcourses.* FROM tblcourses 
        INNER JOIN tblinstructors ON tblcourses.tblInstructorId=tblinstructors.tblInstructorId
        INNER JOIN tblcoursecategories ON tblcourses.tblCourseCategoryId=tblcoursecategories.tblCourseCategoryId
        WHERE
        tblCourseCategoryStatus IN('Active')
        AND 
        tblInstructorStatus IN('Active')
        AND 
        tblCourseStatus IN('Active')
        AND tblCourseId NOT IN('".$CourseId."')");
        $RelatedCourse->execute();

        if($RelatedCourse->rowCount()){?>
    <div class="text-center mb-5 mb-md-8">
        <h1>Önerilen Diğer Kurslar</h1>
        <p class="font-size-lg text-capitalize"><strong><?php echo $GetCourse["tblCourseCategoryTitle"]; ?></strong>
            kategorisine ait diğer kursları senin için listeledik.</strong></p>
    </div>

    <div class="mx-n4 mb-12"
        data-flickity='{"pageDots": true, "prevNextButtons": false, "cellAlign": "left", "wrapAround": true, "imagesLoaded": true}'>



        <?php foreach ($RelatedCourse as $relatedCourse) {?>

        <!-- Card -->
        <div class="card border shadow-dark-hover p-2 sk-fade">
            <!-- Image -->
            <div class="card-zoom position-relative">
                <a href="kurs-<?php echo $relatedCourse["tblCourseSeoUrl"] . "-" . $relatedCourse["tblCourseId"]; ?>"
                    class="card-img sk-thumbnail img-ratio-3 d-block">
                    <img class="rounded shadow-light-lg" src="<?php echo $relatedCourse["tblCourseImageUrl"]; ?>">
                </a>

                <span class="sk-fade-right badge-float bottom-0 right-0 mb-2 me-2">
                    <ins class="h5 mb-0 text-white"><?php echo $relatedCourse["tblCoursePrice"]." ₺"; ?></ins>
                </span>
            </div>

            <!-- Footer -->
            <div class="card-footer px-2 pb-2 mb-1 pt-4 position-relative">
                <!-- Preheading -->
                <a href="kurs-<?php echo $relatedCourse["tblCourseSeoUrl"] . "-" . $relatedCourse["tblCourseId"]; ?>"><span
                        class="mb-1 d-inline-block text-gray-800"><?php echo $relatedCourse["tblCourseTitle"]; ?></span></a>

                <!-- Heading -->
                <div class="position-relative">
                    <a href="kurs-<?php echo $relatedCourse["tblCourseSeoUrl"] . "-" . $relatedCourse["tblCourseId"]; ?>"
                        class="d-block stretched-link">
                        <h5 class="line-clamp-2 h-md-48 h-lg-58 me-md-8 me-lg-10 me-xl-4 mb-2">
                            <?php echo mb_substr($relatedCourse["tblCourseSummary"],0,12,"UTF-8"); ?>..</h5>
                    </a>

                </div>
            </div>
        </div>

        <?php } ?>
    </div>
    <?php } ?>
</div>
</div>
<?php require_once("Footer.php") ?>
<script>
var CartApp = new Vue({
    el: "#Cart",
    data: {
        CourseId: "",
        Price: "<?php echo $GetCourse["tblCoursePrice"]; ?>"
    },
    methods: {
        addToCart(CourseId) {

            axios.post('User/AddToCart', {
                CourseId: CourseId,
                Price: this.Price

            }).then(function(response) {

                Swal.fire({
                    icon: response.data.icon,
                    title: response.data.title,
                    text: response.data.message,
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => {
                    location.reload();
                }, 2000);

            }).catch(function(error) {
                console.error(error);
            });
        }
    }
});
</script>