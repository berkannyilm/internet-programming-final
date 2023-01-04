<?php 
require_once("Queries.php");
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.png">

    <!-- Libs CSS -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/fontawesome.css">
    <link rel="stylesheet" href="assets/libs/%40fancyapps/fancybox/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="assets/libs/aos/dist/aos.css">
    <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="assets/libs/flickity-fade/flickity-fade.css">
    <link rel="stylesheet" href="assets/libs/flickity/dist/flickity.min.css">
    <link rel="stylesheet" href="assets/libs/highlightjs/styles/vs2015.css">
    <link rel="stylesheet" href="assets/libs/jarallax/dist/jarallax.css">
    <link rel="stylesheet" href="assets/libs/quill/dist/quill.core.css">

    <link rel="stylesheet" href="assets/css/sweetalert2.min.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/css/theme.min.css">

    <title><?php echo $GetSetting["tblSettingCompanyTitle"]; ?></title>
    <meta name="author" content="Bytecth">
    <link rel="canonical" href="https://www.bytecth.com/">
    <meta name="og:title" content="<?php echo $GetSetting["tblSettingCompanyTitle"]; ?> Üye Ol" />
    <meta name="og:site_name" content="Bytecth" />
    <meta name="og:url" content="https://www.bytecth.com" />
    <meta name="og:type" content="website" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:url" content="https://www.bytecth.com" />
    <meta name="twitter:title" content="<?php echo $GetSetting["tblSettingCompanyTitle"]; ?> Üye Ol" />
    <meta name="twitter:description" content="<?php echo $GetSetting["tblSettingDescription"]; ?>" />
    <meta name="description" content="<?php echo $GetSetting["tblSettingDescription"]; ?>" />
</head>

<body class="bg-white">

    <!-- MODALS 
     Modal Sidebar cart -->
    <div class="modal modal-sidebar left fade-left fade" id="cartModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header mb-4">
                    <h5 class="modal-title">Sepet İçeriğiniz</h5>
                    <button type="button" class="close text-primary" data-bs-dismiss="modal" aria-label="Close">
                        <!-- Icon -->
                        <svg width="16" height="17" viewbox="0 0 16 17" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.142135 2.00015L1.55635 0.585938L15.6985 14.7281L14.2843 16.1423L0.142135 2.00015Z"
                                fill="currentColor"></path>
                            <path d="M14.1421 1.0001L15.5563 2.41431L1.41421 16.5564L0 15.1422L14.1421 1.0001Z"
                                fill="currentColor"></path>
                        </svg>

                    </button>
                </div>

                <div class="modal-body">
                    <ul class="list-group list-group-flush mb-5">


                        <?php
                        if ($GetCart->rowCount()>0) { 
                            foreach ($GetCart as $Cart) {
                                $CartTotal += $Cart["tblCartPrice"];
                                ?>
                        <li class="list-group-item border-bottom py-0">
                            <div class="d-flex py-5">
                                <div class="bg-gray-200 w-60p h-60p rounded-circle overflow-hidden"></div>
                                <div class="flex-grow-1 mt-1 ms-4">
                                    <h6 class="fw-normal mb-0"><?php echo $Cart["tblCourseTitle"] ?></h6>
                                    <div class="font-size-sm"><?php echo $Cart["tblCartPrice"] ?></div>
                                </div>

                                <a href="javascript:;" @click="removeCart(<?php echo $Cart["tblCartId"] ?>);"
                                    class="d-inline-flex text-secondary">
                                    <!-- Icon -->
                                    <svg width="16" height="16" viewbox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.0469 0H5.95294C5.37707 0 4.90857 0.4685 4.90857 1.04437V3.02872H6.16182V1.25325H9.83806V3.02872H11.0913V1.04437C11.0913 0.4685 10.6228 0 10.0469 0Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M11.0492 5.51652L9.7968 5.47058L9.52527 12.8857L10.7777 12.9315L11.0492 5.51652Z"
                                            fill="currentColor"></path>
                                        <path d="M8.62666 5.49353H7.37341V12.9087H8.62666V5.49353Z" fill="currentColor">
                                        </path>
                                        <path
                                            d="M6.47453 12.8855L6.203 5.47034L4.95056 5.51631L5.22212 12.9314L6.47453 12.8855Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M0.543091 2.4021V3.65535H1.849L2.885 15.4283C2.9134 15.7519 3.18434 16 3.50912 16H12.4697C12.7946 16 13.0657 15.7517 13.0939 15.4281L14.1299 3.65535H15.4569V2.4021H0.543091ZM11.8958 14.7468H4.08293L3.10706 3.65535H12.8719L11.8958 14.7468Z"
                                            fill="currentColor"></path>
                                    </svg>

                                </a>
                            </div>
                        </li>
                        <?php }
                        ?>
                    </ul>

                    <div class="d-flex mb-5">
                        <h5 class="mb-0 me-auto">Toplam:</h5>
                        <h5 class="mb-0"><?php echo floatval($CartTotal)." ₺"; ?> </h5>
                    </div>

                    <div class="d-md-flex justify-content-between">

                        <a href="javascript:;" @click="completeCheckout()"
                            class="d-block d-md-inline-block mb-4 mb-md-0 btn btn-primary btn-sm-wide btn-block">Sepeti
                            Onayla</a>

                    </div>
                    <?php } else {
                            echo "<b>Sepetiniz boş</b>";
                        } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- NAVBAR
    ================================================== -->
    <header class="navbar navbar-expand-xl navbar-light bg-white border-bottom py-2 py-xl-4">
        <div class="container-fluid">

            <!-- Brand -->
            <a class="navbar-brand me-0" href="Home">
                <img src="<?php echo $GetSetting["tblSettingLogoUrl"] ?>" class="navbar-brand-img" alt="...">
            </a>

            <!-- Vertical Menu -->
            <ul class="navbar-nav navbar-vertical ms-xl-4 d-none d-xl-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link pb-4 mb-n4 px-0 pt-0" id="navbarVerticalMenu" data-bs-toggle="dropdown" href="#"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="bg-primary rounded py-3 px-5 d-flex align-items-center">
                            <div class="me-3 ms-1 d-flex text-white">
                                <!-- Icon -->
                                <svg width="25" height="17" viewbox="0 0 25 17" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="25" height="1" fill="currentColor"></rect>
                                    <rect y="8" width="15" height="1" fill="currentColor"></rect>
                                    <rect y="16" width="20" height="1" fill="currentColor"></rect>
                                </svg>

                            </div>
                            <span class="text-white fw-medium me-1">Kategoriler</span>
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-md bg-primary rounded py-4 mt-4"
                        aria-labelledby="navbarVerticalMenu">
                        <?php
                        foreach ($GetCategories->fetchAll() as $category) { ?>
                        <li class="dropdown-item dropright">
                            <a class="dropdown-link dropdown-toggle"   href="kategori-<?php echo $category["tblCourseCategorySeoUrl"] . "-" . $category["tblCourseCategoryId"]; ?>">
                                <div class="me-4 d-flex text-white icon-xs">
                                    <i class="fa fa-grip-lines"></i>
                                </div>
                                <?php echo $category["tblCourseCategoryTitle"] ?>
                            </a>
                        </li>
                        <?php } ?>

                    </ul>
                </li>
            </ul>

            <!-- Search -->
            <form class="d-none d-wd-flex ms-5 w-xl-450p">
                <div class="input-group border rounded">
                    <div class="input-group-prepend">
                        <button class="btn btn-sm my-2 my-sm-0 text-secondary icon-xs d-flex align-items-center"
                            type="submit">
                            <!-- Icon -->
                            <svg width="20" height="20" viewbox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.8477 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.8477 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.8477 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z"
                                    fill="currentColor"></path>
                                <path
                                    d="M19.762 18.6121L15.1007 13.9509C14.7831 13.6332 14.2687 13.6332 13.9511 13.9509C13.6335 14.2682 13.6335 14.7831 13.9511 15.1005L18.6124 19.7617C18.7712 19.9205 18.9791 19.9999 19.1872 19.9999C19.395 19.9999 19.6032 19.9205 19.762 19.7617C20.0796 19.4444 20.0796 18.9295 19.762 18.6121Z"
                                    fill="currentColor"></path>
                            </svg>

                        </button>
                    </div>
                    <input class="form-control form-control-sm border-0 ps-0" type="search"
                        placeholder="What do you want to learn ?" aria-label="Search">
                </div>
            </form>

            <!-- Collapse -->
            <div class="collapse navbar-collapse z-index-lg" id="navbarCollapse">

                <!-- Toggler -->
                <button class="navbar-toggler outline-0 text-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <!-- Icon -->
                    <svg width="16" height="17" viewbox="0 0 16 17" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.142135 2.00015L1.55635 0.585938L15.6985 14.7281L14.2843 16.1423L0.142135 2.00015Z"
                            fill="currentColor"></path>
                        <path d="M14.1421 1.0001L15.5563 2.41431L1.41421 16.5564L0 15.1422L14.1421 1.0001Z"
                            fill="currentColor"></path>
                    </svg>

                </button>
                <!-- Navigation -->
            </div>
            <!-- Search, Account & Cart -->
            <ul class="navbar-nav flex-row ms-auto ms-xl-0 me-n2 me-md-n4">
                <li class="nav-item border-0 px-0 d-none d-370-block d-xl-none">
                    <a class="nav-link d-flex px-3 px-md-4 search-mobile text-secondary icon-xs"
                        data-bs-toggle="collapse" href="#collapseSearchMobile" role="button" aria-expanded="false"
                        aria-controls="collapseSearchMobile">
                        <!-- Icon -->
                        <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.8477 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.8477 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.8477 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z"
                                fill="currentColor"></path>
                            <path
                                d="M19.762 18.6121L15.1007 13.9509C14.7831 13.6332 14.2687 13.6332 13.9511 13.9509C13.6335 14.2682 13.6335 14.7831 13.9511 15.1005L18.6124 19.7617C18.7712 19.9205 18.9791 19.9999 19.1872 19.9999C19.395 19.9999 19.6032 19.9205 19.762 19.7617C20.0796 19.4444 20.0796 18.9295 19.762 18.6121Z"
                                fill="currentColor"></path>
                        </svg>


                        <!-- Icon -->
                        <svg width="16" height="17" viewbox="0 0 16 17" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.142135 2.00015L1.55635 0.585938L15.6985 14.7281L14.2843 16.1423L0.142135 2.00015Z"
                                fill="currentColor"></path>
                            <path d="M14.1421 1.0001L15.5563 2.41431L1.41421 16.5564L0 15.1422L14.1421 1.0001Z"
                                fill="currentColor"></path>
                        </svg>

                    </a>

                    <div class="collapse position-absolute right-0 left-0" id="collapseSearchMobile">
                        <div class="card card-body p-4 mt-7 shadow-dark">
                            <!-- Search -->
                            <form class="w-100">
                                <div class="input-group border rounded">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-sm text-secondary icon-xs d-flex align-items-center"
                                            type="submit">
                                            <!-- Icon -->
                                            <svg width="20" height="20" viewbox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.80758 0C3.95121 0 0 3.95121 0 8.80758C0 13.6642 3.95121 17.6152 8.80758 17.6152C13.6642 17.6152 17.6152 13.6642 17.6152 8.80758C17.6152 3.95121 13.6642 0 8.80758 0ZM8.80758 15.9892C4.8477 15.9892 1.62602 12.7675 1.62602 8.80762C1.62602 4.84773 4.8477 1.62602 8.80758 1.62602C12.7675 1.62602 15.9891 4.8477 15.9891 8.80758C15.9891 12.7675 12.7675 15.9892 8.80758 15.9892Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M19.762 18.6121L15.1007 13.9509C14.7831 13.6332 14.2687 13.6332 13.9511 13.9509C13.6335 14.2682 13.6335 14.7831 13.9511 15.1005L18.6124 19.7617C18.7712 19.9205 18.9791 19.9999 19.1872 19.9999C19.395 19.9999 19.6032 19.9205 19.762 19.7617C20.0796 19.4444 20.0796 18.9295 19.762 18.6121Z"
                                                    fill="currentColor"></path>
                                            </svg>

                                        </button>
                                    </div>
                                    <input class="form-control form-control-sm border-0 ps-0" type="search"
                                        placeholder="What do you want to learn ?" aria-label="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
                <li class="nav-item border-0 px-0">
                    <!-- Button trigger account modal -->
                    <a href="Courses" class="nav-link d-flex px-3 px-md-4 text-secondary icon-xs">
                        Kurslar
                    </a>
                </li>
                <?php
                if (empty($_SESSION["StudentEmail"])) { ?>
                <li class="nav-item border-0 px-0">
                    <!-- Button trigger account modal -->
                    <a href="Register" class="nav-link d-flex px-3 px-md-4 text-secondary icon-xs" >
                        Üye Ol
                    </a>
                </li>
                <li class="nav-item border-0 px-0">
                    <!-- Button trigger account modal -->
                    <a href="Login" class="nav-link d-flex px-3 px-md-4 text-secondary icon-xs">
                        Giriş Yap
                    </a>
                </li>
                <?php } else{?>
                <li class="nav-item border-0 px-0">
                    <!-- Button trigger account modal -->
                    <a href="TrainingList" class="nav-link d-flex px-3 px-md-4 text-secondary icon-xs">
                        Öğrenim İçeriğim
                    </a>
                </li>
                <li class="nav-item border-0 px-0">
                    <!-- Button trigger account modal -->
                    <a href="Logout" class="nav-link d-flex px-3 px-md-4 text-secondary icon-xs">
                        Çıkış Yap
                    </a>
                </li>
                <?php } ?>

                <li class="nav-item border-0 px-0">
                    <!-- Button trigger cart modal -->
                    <a href="#" class="nav-link d-flex px-3 px-md-4 position-relative text-secondary icon-xs"
                        data-bs-toggle="modal" data-bs-target="#cartModal">
                        <span class="badge badge-primary rounded-circle fw-bold badge-float mt-n1 ms-n2 px-0 w-16"
                            style="font-size: 8px;"><?php echo $GetCart->rowCount(); ?></span>
                        <!-- Icon -->
                        <svg width="13" height="15" viewbox="0 0 13 15" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.2422 3.51562H10.4567C10.2239 1.53873 8.53839 0 6.5 0C4.46161 0 2.7761 1.53873 2.54334 3.51562H0.757812C0.434199 3.51562 0.171875 3.77795 0.171875 4.10156V14.4141C0.171875 14.7377 0.434199 15 0.757812 15H12.2422C12.5658 15 12.8281 14.7377 12.8281 14.4141V4.10156C12.8281 3.77795 12.5658 3.51562 12.2422 3.51562ZM6.5 1.17188C7.89113 1.17188 9.04939 2.18716 9.27321 3.51562H3.72679C3.95062 2.18716 5.10887 1.17188 6.5 1.17188ZM11.6562 13.8281H1.34375V4.6875H2.51562V6.44531C2.51562 6.76893 2.77795 7.03125 3.10156 7.03125C3.42518 7.03125 3.6875 6.76893 3.6875 6.44531V4.6875H9.3125V6.44531C9.3125 6.76893 9.57482 7.03125 9.89844 7.03125C10.2221 7.03125 10.4844 6.76893 10.4844 6.44531V4.6875H11.6562V13.8281Z"
                                fill="currentColor"></path>
                        </svg>

                    </a>
                </li>
            </ul>

            <!-- Toggler -->
            <button
                class="navbar-toggler ms-4 ms-md-5 shadow-none bg-teal text-white icon-xs p-0 outline-0 h-40p w-40p d-flex d-xl-none place-flex-center"
                type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse"
                aria-expanded="false" aria-label="Toggle navigation">
                <!-- Icon -->
                <svg width="25" height="17" viewbox="0 0 25 17" xmlns="http://www.w3.org/2000/svg">
                    <rect width="25" height="1" fill="currentColor"></rect>
                    <rect y="8" width="15" height="1" fill="currentColor"></rect>
                    <rect y="16" width="20" height="1" fill="currentColor"></rect>
                </svg>

            </button>
        </div>
    </header>