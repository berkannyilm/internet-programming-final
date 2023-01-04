<?php require_once("Header2.php"); ?>
<!-- PAGE TITLE
    ================================================== -->
<header class="py-8 py-md-6" style="background-image: none;">
    <div class="container text-center py-xl-2">
        <h1 class="display-4 fw-semi-bold mb-0"><?php echo $GetSetting["tblSettingCompanyTitle"]; ?> Giriş Yap</h1>
        </h1>
    </div>
</header>


<!-- Login
    ================================================== -->
<div class="container mb-11">
    <div class="row gx-0">
        <div class="col-md-7 col-xl-4 mx-auto" id="Login">
            <!-- Form Login -->
            <form class="mb-5">

                <!-- Email -->
                <div class="form-group mb-5">
                    <label for="modalSignupEmail1">
                        E-Posta Adresin:
                    </label>
                    <input type="email" class="form-control" v-model="Email">
                </div>

                <!-- Password -->
                <div class="form-group mb-5">
                    <label for="modalSignupPassword3">
                        Şifren:
                    </label>
                    <input type="password" class="form-control" v-model="Password">
                </div>

                <!-- Submit -->
                <a class="btn btn-block btn-primary" @click="Login()">
                    Üye Ol
                </a>

            </form>

            <!-- Text -->
            <p class="mb-0 font-size-sm text-center">
                Hesabın yoksa hemen üyelik oluşturalım ? <a class="text-underline" href="Register">Üye Ol</a>
            </p>
        </div>
    </div>
</div>

<?php require_once("Footer.php"); ?>
<script>
var LoginApp = new Vue({
    el: "#Login",
    data: {

        Password: "",
        Email: ""
    },
    methods: {
        Login() {

            if (this.Email != '' && this.Password != '') {

                axios.post('User/Login', {

                    Email: this.Email,
                    Password: this.Password

                }).then(function(response) {

                    Swal.fire({
                        icon: response.data.icon,
                        title: response.data.title,
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    setTimeout(() => {
                        location.href = "Home";
                    }, 2000);


                }).catch(function(error) {
                    console.error(error);
                });

            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'CourseX',
                    text: "Tüm alanları doldurunuz!",
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    }
});
</script>