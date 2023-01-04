<?php require_once("Header2.php"); ?>
<!-- PAGE TITLE
    ================================================== -->
<header class="py-8 py-md-4" style="background-image: none;">
    <div class="container text-center py-xl-2">
        <h1 class="display-4 fw-semi-bold mb-0">Tüm Kurslar</h1>
        </h1>
    </div>
    <!-- Img -->
    <img class="d-none img-fluid" src="..." alt="...">
</header>

<!-- COURSE LIST V2
    ================================================== -->
<div class="container">
    <div class="row">


        <div class="col-xl-12">

            <div class="row row-cols-md-2 mb-3 ">
                <?php

                @$GetCategoryId = xss_clean(xss_clean(securty(intval($_GET["CategoryId"]))));

                if($GetCategoryId){
                    
                    $CourseListenerByCategory = $connection->prepare("SELECT  
                    tblinstructors.*, tblcoursecategories.*, tblcourses.* FROM tblcourses 
                    INNER JOIN tblinstructors ON tblcourses.tblInstructorId=tblinstructors.tblInstructorId
                    INNER JOIN tblcoursecategories ON tblcourses.tblCourseCategoryId=tblcoursecategories.tblCourseCategoryId
                    WHERE
                    tblCourseCategoryStatus IN('Active')
                    AND 
                    tblInstructorStatus IN('Active')
                    AND 
                    tblCourseStatus IN('Active')
                    AND 
                    tblcourses.tblCourseCategoryId= :tblCourseCategoryId
                    ORDER BY tblCourseCreatedDate DESC");
                    $CourseListenerByCategory->bindParam(":tblCourseCategoryId", $GetCategoryId, PDO::PARAM_INT);
                    $CourseListenerByCategory->execute();
                
                    $GetCourses = $CourseListenerByCategory->fetchAll();
                }else{

                    $GetCourses = $GetCourses->fetchAll();
                }
                



                $sayfada = 2;
                $CoursesPaginateLimit = $connection->prepare("SELECT  
                tblinstructors.*, tblcoursecategories.*, tblcourses.* FROM tblcourses 
                INNER JOIN tblinstructors ON tblcourses.tblInstructorId=tblinstructors.tblInstructorId
                INNER JOIN tblcoursecategories ON tblcourses.tblCourseCategoryId=tblcoursecategories.tblCourseCategoryId
                WHERE
                tblCourseCategoryStatus IN('Active')
                AND 
                tblInstructorStatus IN('Active')
                AND 
                tblCourseStatus IN('Active')
                ORDER BY tblCourseCreatedDate DESC "); 

                $CoursesPaginateLimit->execute();
                if($GetCategoryId){
                    
                    $toplam_icerik = $CourseListenerByCategory->rowCount();
                }
                $toplam_icerik = $CoursesPaginateLimit->rowCount();

                $toplam_sayfa = ceil($toplam_icerik / $sayfada);

                $sayfa = isset($_GET['page']) ? (int) $_GET['page'] : 1;

                if ($sayfa < 1) $sayfa = 1;

                if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;

                $limit = ($sayfa - 1) * $sayfada;

                    foreach ($GetCourses as $Course) { ?>

                <div class="col-md pb-4 pb-md-7">
                    <!-- Card -->
                    <div class="card border shadow p-2 lift sk-fade">
                        <!-- Image -->
                        <div class="card-zoom position-relative">

                            <a href="kurs-<?php echo $Course["tblCourseSeoUrl"] . "-" . $Course["tblCourseId"]; ?>"
                                class="card-img sk-thumbnail d-block">
                                <img class="rounded shadow-light-lg" src="<?php echo $Course["tblCourseImageUrl"]; ?>"
                                    alt="<?php echo $Course["tblCourseTitle"]; ?>">
                            </a>
                        </div>

                        <!-- Footer -->
                        <div class=" card-footer px-2 pb-2 mb-1 pt-4 position-relative">
                            <a href="kurs-<?php echo $Course["tblCourseSeoUrl"] . "-" . $Course["tblCourseId"]; ?>"
                                class="d-block">
                                <div
                                    class="avatar sk-fade-right avatar-xl badge-float position-absolute top-0 right-0 mt-n6 me-5 rounded-circle shadow border border-white border-w-lg">
                                    <img src="<?php echo $Course["tblInstructorImageUrl"]; ?>"
                                        alt="<?php echo $Course["tblInstructorFirstname"]." ".$Course["tblInstructorLastname"]; ?>"
                                        class="avatar-img rounded-circle">
                                </div>
                            </a>

                            <!-- Preheading -->
                            <a href="kurs-<?php echo $Course["tblCourseSeoUrl"] . "-" . $Course["tblCourseId"]; ?>"><span
                                    class="mb-1 d-inline-block text-gray-800"><?php echo $Course["tblCourseCategoryTitle"]; ?></span></a>

                            <!-- Heading -->
                            <div class="position-relative">
                                <a href="kurs-<?php echo $Course["tblCourseSeoUrl"] . "-" . $Course["tblCourseId"]; ?>"
                                    class="d-block stretched-link">
                                    <h4 class="line-clamp-2 h-md-48 h-lg-58 me-md-6 me-lg-10 me-xl-4 mb-2">
                                        <?php echo $Course["tblCourseTitle"]; ?></h4>
                                </a>

                                <div class="d-lg-flex align-items-end flex-wrap mb-n1">
                                    <div class="star-rating mb-2 mb-lg-0 me-lg-3">
                                        <div class="rating" style="width:<?php echo $Course["tblCourseRating"]; ?>%;">
                                        </div>
                                        (<?php echo $Course["tblCourseRating"]; ?>)
                                    </div>

                                </div>

                                <div class="row mx-n2 align-items-end">
                                    <div class="col px-2">
                                        <ul class="nav mx-n3">

                                        </ul>
                                    </div>

                                    <div class="col-auto px-2 text-right">

                                        <ins
                                            class="h4 mb-0 d-block mb-lg-n1"><?php echo $Course["tblCoursePrice"]." ₺"; ?></ins>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- PAGINATION
                ================================================== -->
            <nav class="mb-11" aria-label="Page navigationa">
                <ul class="pagination justify-content-center">
                    <?php
                    if($GetCategoryId){
                       $FullUrl = explode("/",$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                       if ($sayfa > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo $FullUrl[2].'?page=' . ($sayfa - 1) . ''; ?>"
                            aria-label="Previous">
                            <span aria-hidden="true"><i class="fas fa-arrow-left"></i></span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php
                        for ($i = 1; $i <= $toplam_sayfa; $i++) {
                            if ($i == $sayfa) {
                                echo '<li class="page-item"><a href="'.$FullUrl[2].'?page=' . $i . '" class="page-link active">' . $i . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a href="'.$FullUrl[2].'?page=' . $i . '" class="page-link">' . $i . '</a></li>';
                            }
                        }
    
                        if ($toplam_sayfa > $sayfa) { ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo ''.$FullUrl[2].'?page=' . ($sayfa + 1) . ''; ?>"
                            aria-label="Previous">
                            <span aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    </li>
                    <?php }
                    } else {
                        if ($sayfa > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'Courses?page=' . ($sayfa - 1) . ''; ?>"
                            aria-label="Previous">
                            <span aria-hidden="true"><i class="fas fa-arrow-left"></i></span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php
                    for ($i = 1; $i <= $toplam_sayfa; $i++) {
                        if ($i == $sayfa) {
                            echo '<li class="page-item"><a href="Courses?page=' . $i . '" class="page-link active">' . $i . '</a></li>';
                        } else {
                            echo '<li class="page-item"><a href="Courses?page=' . $i . '" class="page-link">' . $i . '</a></li>';
                        }
                    }

                    if ($toplam_sayfa > $sayfa) { ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'Courses?page=' . ($sayfa + 1) . ''; ?>"
                            aria-label="Previous">
                            <span aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    </li>
                    <?php }
                    }?>

                </ul>
            </nav>

        </div>
    </div>
</div>
<?php require_once("Footer.php"); ?>