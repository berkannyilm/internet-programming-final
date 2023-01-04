<?php
require_once("Configuration/Database.php");
require_once("Configuration/Functions.php");

$SettingDefaultId = 1;
$Settings = $connection->prepare("SELECT * FROM tblsettings WHERE tblSettingId= :tblSettingId");
$Settings->bindParam(":tblSettingId", $SettingDefaultId, PDO::PARAM_INT);
$Settings->execute();
$Setting = $Settings->fetch(PDO::FETCH_ASSOC);

CheckOpenedSession();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo $Setting["tblSettingCompanyTitle"] . " Backoffice"; ?> </title>
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toatr.css">
</head>
<body>

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container" id="Login">
                <img class="img-fluid logo-dark mb-2" src="../<?php echo $Setting["tblSettingLogoUrl"]; ?>">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Backoffice</h1>
                            <p class="account-subtitle">Hesap bilgilerinizi girin.</p>
                            <form @keyup.enter="Login();">
                                <div class="form-group">
                                    <label class="form-control-label">E-Posta:</label>
                                    <input type="email" v-model='managerEmail' class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Şifreniz:</label>
                                    <div class="pass-group">
                                        <input type="password" v-model='managerPassword'
                                            class="form-control pass-input">
                                        <span class="fas fa-eye toggle-password"></span>
                                    </div>
                                </div>

                                <a class="btn btn-lg btn-block btn-primary w-100" @click="Login()">Giriş Yap</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/plugins/toastr/toastr.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="../cdn/js/vue.js"></script>
    <script src="../cdn/js/axios.min.js"></script>
    <script>
        var LoginApp = new Vue({
            el: "#Login",
            data: {
                managerEmail: "",
                managerPassword: ""
            },
            methods: {
                Login() {


                    if (this.managerEmail != '' && this.managerPassword != '') {

                        axios.post('Authorization/Login', {

                            managerEmail: this.managerEmail,
                            managerPassword: this.managerPassword

                        }).then(function (response) {

                            let getResponse = response.data;
                            let getIcon = getResponse.icon;
                            toastr[getIcon](getResponse.message, getResponse.title);
                            setTimeout(() => {
                                var URL = getResponse.redirectURL || "";
                                if (URL) window.location.href = URL;
                            }, 2000);


                        }).catch(function (error) {
                            console.error(error);
                        });

                    } else {
                        toastr.warning("E-Posta ve şifrenizi boş bırakmayınız.", "Uyarı");
                    }
                }
            }
        });
    </script>
    <script>
    $(".right-side-views").hide();
</script>
</body>

</html>