<!-- FOOTER
    ================================================== -->
<footer class="pt-8 pt-md-13 pt-xl-15 position-relative bg-light">
    <!-- Shape -->
    <div class="shape shape-blur mb-n-1 shape-top shape-flip-both svg-shim text-white mt-n-1">
        <svg viewbox="0 0 1920 230" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor"
                d="M0,229l1920,0V-0.4c0,25.8-19.6,47.3-45.2,49.8L54.8,223.8C25.4,226.6,0,203.5,0,174V229z">
            </path>
        </svg>

    </div>

    <div class="container">
        <div class="row" id="accordionFooter">
            <div class="col-12 col-md-4 col-lg-4">

                <!-- Brand -->
                <img src="<?php echo $GetSetting["tblSettingLogoUrl"]; ?>"
                    alt="<?php echo $GetSetting["tblSettingTitle"]; ?>" class="footer-brand img-fluid mb-4 h-60p">

                <!-- Text -->
                <p class="text-gray-800 mb-4 font-size-sm-alone">
                    <?php echo $GetSetting["tblSettingAddress"]; ?>,
                    <?php echo $GetSetting["tblSettingDistrict"]."/".$GetSetting["tblSettingCity"]; ?>
                </p>

                <div class="mb-4">
                    <a href="tel:1234567890"
                        class="text-gray-800 font-size-sm-alone"><?php echo $GetSetting["tblSettingPhone"]; ?></a>
                </div>

                <div class="mb-4">
                    <a href="mailto:<?php echo $GetSetting["tblSettingEmail"]; ?>"
                        class="text-gray-800 font-size-sm-alone"><?php echo $GetSetting["tblSettingEmail"]; ?></a>
                </div>
                <div class="mb-4">
                    <a href="mailto:<?php echo $GetSetting["tblSettingSupportEmail"]; ?>"
                        class="text-gray-800 font-size-sm-alone"><?php echo $GetSetting["tblSettingSupportEmail"]; ?></a>
                </div>
                <!-- Social -->
                <ul class="list-unstyled list-inline list-social mb-4 mb-md-0">
                    <li class="list-inline-item list-social-item">
                        <a href="https://facebook.com/<?php echo $GetSetting["tblSettingFacebook"]; ?>"
                            class="text-secondary font-size-sm w-36 h-36 shadow-dark-hover d-flex align-items-center justify-content-center rounded-circle border-hover">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="list-inline-item list-social-item">
                        <a href="https://twitter.com/<?php echo $GetSetting["tblSettingTwitter"]; ?>"
                            class="text-secondary font-size-sm w-36 h-36 shadow-dark-hover d-flex align-items-center justify-content-center rounded-circle border-hover">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li class="list-inline-item list-social-item">
                        <a href="https://instagram.com/<?php echo $GetSetting["tblSettingInstagram"]; ?>"
                            class="text-secondary font-size-sm w-36 h-36 shadow-dark-hover d-flex align-items-center justify-content-center rounded-circle border-hover">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li class="list-inline-item list-social-item">
                        <a href="https://facebook.com/company/<?php echo $GetSetting["tblSettingLinkedin"]; ?>"
                            class="text-secondary font-size-sm w-36 h-36 shadow-dark-hover d-flex align-items-center justify-content-center rounded-circle border-hover">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-4 col-lg-4">
                <div class="mb-5 mb-xl-0 footer-accordion">

                    <!-- Heading -->
                    <div id="widgetOne">
                        <h5 class="mb-5">
                            <button class="text-dark fw-medium footer-accordion-toggle d-flex align-items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#widgetcollapseOne"
                                aria-expanded="true" aria-controls="widgetcollapseOne">
                                Kurumsal Sayfalar
                                <span class="ms-auto text-dark">
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
                            </button>
                        </h5>
                    </div>

                    <div id="widgetcollapseOne" class="collapse show" aria-labelledby="widgetOne"
                        data-parent="#accordionFooter">
                        <!-- List -->
                        <ul class="list-unstyled text-gray-800 font-size-sm-alone mb-6 mb-md-8 mb-lg-0">

                            <?php
                        $GetPages = $connection->prepare("SELECT * FROM tblpages ORDER BY tblPageArrangement ASC");
                        $GetPages->execute();
                        foreach ($GetPages->fetchAll() as $GetPage) { ?>

                            <li class="mb-3">
                                <a href="sayfa-<?php echo $GetPage["tblPageSeoUrl"] . "-" . $GetPage["tblPageId"]; ?>" class="text-reset">
                                  <?php echo $GetPage["tblPageTitle"]; ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 offset-md-4 offset-lg-0 col-lg-4">
                <div class="mb-5 mb-xl-0 footer-accordion">

                    <!-- Heading -->
                    <div id="widgetThree">
                        <h5 class="mb-5">
                            <button class="text-dark fw-medium footer-accordion-toggle d-flex align-items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#widgetcollapseThree"
                                aria-expanded="false" aria-controls="widgetcollapseThree">
                                E-Bülten
                                <span class="ms-auto text-dark">
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
                            </button>
                        </h5>
                    </div>

                    <div id="newsletter" class="collapse" aria-labelledby="widgetThree" data-parent="#accordionFooter">
                        <p class="font-size-sm-alone text-gray-800 line-height-lg mb-5">En güncel kurslardan haberdar
                            olmak için E-Bülten'e Abone Olun !</p>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control rounded-left-xl placeholder-1"
                                    placeholder="E-posta giriniz" aria-label="E-posta giriniz"
                                    aria-describedby="button-addon2" v-model="newsletterEmail">
                                <div class="input-group-append">
                                    <a class="btn btn-dark px-5 rounded-right-xl" @click="addNewsletter()">Abone Ol</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-md-5">
                <div
                    class="border-top pb-6 pt-6 py-md-4 text-center text-xl-start d-flex flex-column d-md-block d-xl-flex flex-xl-row align-items-center">
                    <p
                        class="text-gray-800 font-size-sm-alone d-block mb-0 mb-md-2 mb-xl-0 order-1 order-md-0 px-9 px-md-0">
                        Copyright © 2023 <?php echo $GetSetting["tblSettingCompanyTitle"]; ?>. Tüm Hakları Saklıdır.</p>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</footer>


<!-- JAVASCRIPT
    ================================================== -->
<!-- Libs JS -->
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/%40fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
<script src="assets/libs/aos/dist/aos.js"></script>
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="assets/libs/countup.js/dist/countUp.min.js"></script>
<script src="assets/libs/dropzone/dist/min/dropzone.min.js"></script>
<script src="assets/libs/flickity/dist/flickity.pkgd.min.js"></script>
<script src="assets/libs/flickity-fade/flickity-fade.js"></script>
<script src="assets/libs/highlightjs/highlight.pack.min.js"></script>
<script src="assets/libs/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="assets/libs/isotope-layout/dist/isotope.pkgd.min.js"></script>
<script src="assets/libs/jarallax/dist/jarallax.min.js"></script>
<script src="assets/libs/jarallax/dist/jarallax-video.min.js"></script>
<script src="assets/libs/jarallax/dist/jarallax-element.min.js"></script>
<script src="assets/libs/parallax-js/dist/parallax.min.js"></script>
<script src="assets/libs/quill/dist/quill.min.js"></script>
<script src="assets/libs/smooth-scroll/dist/smooth-scroll.min.js"></script>
<script src="assets/libs/typed.js/lib/typed.min.js"></script>

<!-- Theme JS -->
<script src="assets/js/theme.min.js"></script>
<script src="cdn/js/vue.js"></script>
<script src="cdn/js/axios.min.js"></script>
<script src="assets/js/sweetalet2.min.js"></script>
<script>
var RemoveCart = new Vue({
    el: "#cartModal",
    data: {
        CartId: "",
        StudentId: ""
    },
    methods: {
        removeCart(CartId) {

            axios.post('User/RemoveCart', {
                CartId: CartId

            }).then(function(response) {

                alert(response.data.message);
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }).catch(function(error) {
                console.error(error);
            });
        },
        completeCheckout() {
            axios.post('User/CompleteCheckout', {

                StudentId: <?php echo $_SESSION["StudentId"]; ?>

            }).then(function(response) {

                alert(response.data.message);
                setTimeout(() => {
                    location.reload();
                }, 2000);

            }).catch(function(error) {
                console.error(error);
            });
        }
    }
});

var NewsletterForn = new Vue({
    el: "#newsletter",
    data: {
        newsletterEmail: ""
    },
    methods: {
        addNewsletter() {

            axios.post('User/AddNewsletter', {
                newsletterEmail: this.newsletterEmail

            }).then(function(response) {

                Swal.fire({
                    icon: response.data.icon,
                    title: response.data.title,
                    text: response.data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                this.newsletterEmail = "";

            }).catch(function(error) {
                console.error(error);
            });


        }
    }
});
</script>

</body>

</html>