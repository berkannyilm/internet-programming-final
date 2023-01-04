<?php require_once("Header2.php");
@$CourseId = xss_clean(securty(intval($_GET["CourseId"])));
$WatchCourse = $connection->prepare("SELECT * FROM  
tblcoursedetails
WHERE CourseId= :CourseId ");
$WatchCourse->bindParam(":CourseId", $CourseId , PDO::PARAM_INT);
$WatchCourse->execute();

if(!$WatchCourse->rowCount()){
    header("Location:Courses");
}

$GetCourseImage = $connection->prepare("SELECT tblCourseImageUrl FROM tblcourses WHERE tblCourseId= :tblCourseId");
$GetCourseImage->bindParam(":tblCourseId", $CourseId, PDO::PARAM_INT);
$GetCourseImage->execute();
$CourseImage = $GetCourseImage->fetch();
?>




<div class="container" id="watchCourse">
    <div class="row pt-8">
        <a href="" id="videoUrl" class="d-block sk-thumbnail rounded mb-8" >
            <div
                class="h-90p w-90p rounded-circle bg-white size-30-all d-inline-flex align-items-center justify-content-center position-absolute center z-index-1">
                <!-- Icon -->
                <svg width="14" height="16" viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.8704 6.15374L3.42038 0.328572C2.73669 -0.0923355 1.9101 -0.109836 1.20919 0.281759C0.508282 0.673291 0.0898438 1.38645 0.0898438 2.18929V13.7866C0.0898438 15.0005 1.06797 15.9934 2.27016 16C2.27344 16 2.27672 16 2.27994 16C2.65563 16 3.04713 15.8822 3.41279 15.6591C3.70694 15.4796 3.79991 15.0957 3.62044 14.8016C3.44098 14.5074 3.05697 14.4144 2.76291 14.5939C2.59188 14.6982 2.42485 14.7522 2.27688 14.7522C1.82328 14.7497 1.33763 14.3611 1.33763 13.7866V2.18933C1.33763 1.84492 1.51713 1.53907 1.81775 1.3711C2.11841 1.20314 2.47294 1.21064 2.76585 1.39098L12.2159 7.21615C12.4999 7.39102 12.6625 7.68262 12.6618 8.01618C12.6611 8.34971 12.4974 8.64065 12.2118 8.81493L5.37935 12.9983C5.08548 13.1783 4.9931 13.5623 5.17304 13.8562C5.35295 14.1501 5.73704 14.2424 6.03092 14.0625L12.8625 9.87962C13.5166 9.48059 13.9081 8.78496 13.9096 8.01868C13.9112 7.25249 13.5226 6.55524 12.8704 6.15374Z"
                        fill="currentColor"></path>
                </svg>

            </div>
            <img class="rounded shadow-light-lg" src="<?php echo $CourseImage["tblCourseImageUrl"]; ?>">
        </a>
        <div class="col-lg-10 col-xl-8 mx-lg-auto">

            <div class="mb-8">
                <h3 class="mb-5">İzlemeye Başla</h3>

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
                                    Konular
                                </button>
                            </h5>
                        </div>

                        <div id="CurriculumcollapseOne" class="collapse show" aria-labelledby="curriculumheadingOne"
                            data-parent="#accordionCurriculum">
                            <?php
                            foreach ($WatchCourse as $Watch) { ?>

                            <div class="border-top px-5 py-4 min-height-70 d-md-flex align-items-center">
                                <div class="d-flex align-items-center me-auto mb-4 mb-md-0">
                                    <a href="javascript:;" @click="watchCourse('<?php echo $Watch["FileUrl"]; ?>')"
                                        class="text-secondary d-flex">
                                        <!-- Icon -->
                                        <svg width="14" height="16" viewBox="0 0 14 16"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.8704 6.15374L3.42038 0.328572C2.73669 -0.0923355 1.9101 -0.109836 1.20919 0.281759C0.508282 0.673291 0.0898438 1.38645 0.0898438 2.18929V13.7866C0.0898438 15.0005 1.06797 15.9934 2.27016 16C2.27344 16 2.27672 16 2.27994 16C2.65563 16 3.04713 15.8822 3.41279 15.6591C3.70694 15.4796 3.79991 15.0957 3.62044 14.8016C3.44098 14.5074 3.05697 14.4144 2.76291 14.5939C2.59188 14.6982 2.42485 14.7522 2.27688 14.7522C1.82328 14.7497 1.33763 14.3611 1.33763 13.7866V2.18933C1.33763 1.84492 1.51713 1.53907 1.81775 1.3711C2.11841 1.20314 2.47294 1.21064 2.76585 1.39098L12.2159 7.21615C12.4999 7.39102 12.6625 7.68262 12.6618 8.01618C12.6611 8.34971 12.4974 8.64065 12.2118 8.81493L5.37935 12.9983C5.08548 13.1783 4.9931 13.5623 5.17304 13.8562C5.35295 14.1501 5.73704 14.2424 6.03092 14.0625L12.8625 9.87962C13.5166 9.48059 13.9081 8.78496 13.9096 8.01868C13.9112 7.25249 13.5226 6.55524 12.8704 6.15374Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </a>
                                    <div class="ms-4">
                                        <?php echo $Watch["CourseTitle"]; ?>
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
</div>
</div>
<?php require_once("Footer.php"); ?>
<script>
var watchCourseApp = new Vue({
    el: "#watchCourse",
    data: {},
    methods: {
        watchCourse(videoLocation) {

            $('#videoUrl').attr('href', videoLocation); 
            $('#videoUrl').attr("data-fancybox","");
             
        }
    }
});
</script>