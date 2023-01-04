 <?php 
 require_once("Header.php");
 ?>

 <!-- HERO
    ================================================== -->
 <section class="py-15 pt-xl-14 mt-n14 pb-lg-15 bg-dark bg-cover position-relative">
     <!-- Cursor position parallax -->
     <div class="position-absolute right-0 left-0 top-0 bottom-0">
         <div class="cs-parallax">
             <div class="cs-parallax-layer" data-depth="0.1">
                 <img class="img-fluid" src="assets/img/parallax/layer-01.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.3">
                 <img class="img-fluid" src="assets/img/parallax/layer-02.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.2">
                 <img class="img-fluid" src="assets/img/parallax/layer-03.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.2">
                 <img class="img-fluid" src="assets/img/parallax/layer-04.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.4">
                 <img class="img-fluid" src="assets/img/parallax/layer-05.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.3">
                 <img class="img-fluid" src="assets/img/parallax/layer-06.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.2">
                 <img class="img-fluid" src="assets/img/parallax/layer-07.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.2">
                 <img class="img-fluid" src="assets/img/parallax/layer-08.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.4">
                 <img class="img-fluid" src="assets/img/parallax/layer-09.svg" alt="Layer">
             </div>
             <div class="cs-parallax-layer" data-depth="0.3">
                 <img class="img-fluid" src="assets/img/parallax/layer-10.svg" alt="Layer">
             </div>
         </div>
     </div>

     <div class="container">
         <div class="row align-items-center">
             <div class="col-12 col-md-5 col-lg-6 order-md-2" data-aos="fade-in">

                 <!-- Image -->
                 <img src="assets/img/illustrations/illustration-4.png"
                     class="img-fluid ms-xl-5 mw-md-150 mw-lg-130 mb-6 mb-md-0" alt="...">

             </div>
             <div class="col-12 col-md-7 col-lg-6 order-md-1">
                 <!-- Heading -->
                 <h1 class="display-2 text-white mb-6" data-aos="fade-left" data-aos-duration="150">
                  Toplam <strong><?php echo $GetCourses->rowCount(); ?></strong> <br>
                   <span class="display-1 text-orange fw-bold">Online Kurs</span>
                   <br> Seni Bekliyor !
                 </h1>
                 <!-- Text -->
                 <p class="text-white text-capitalize" data-aos="fade-up" data-aos-duration="200">
                    Kendini geliştirebileceğin kurslar <?php echo $GetSetting["tblSettingCompanyTitle"]; ?>'te seni bekliyor!
                 </p>
             </div>
         </div> <!-- / .row -->
     </div> <!-- / .container -->
     <!-- Shape -->
     <div class="shape shape-blur mb-n-1 shape-bottom shape-fluid-x svg-shim text-white-ice">
         <svg viewbox="0 0 1920 230" fill="none" xmlns="http://www.w3.org/2000/svg">
             <path fill="currentColor"
                 d="M0,229l1920,0V-0.4c0,25.8-19.6,47.3-45.2,49.8L54.8,223.8C25.4,226.6,0,203.5,0,174V229z"></path>
         </svg>

     </div>
 </section>
 <?php require_once("Footer.php"); ?>