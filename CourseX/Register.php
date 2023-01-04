<?php require_once("Header2.php"); ?>
<!-- PAGE TITLE
    ================================================== -->
<header class="py-8 py-md-6" style="background-image: none;">
    <div class="container text-center py-xl-2">
        <h1 class="display-4 fw-semi-bold mb-0"><?php echo $GetSetting["tblSettingCompanyTitle"]; ?> Üye Ol</h1>
        </h1>
        </h1>
    </div>
    <!-- Img -->
    <img class="d-none img-fluid" src="..." alt="...">
</header>


<!-- REGISTER
    ================================================== -->
<div class="container mb-11">
    <div class="row gx-0">
        <div class="col-md-7 col-xl-4 mx-auto" id="Register">
            <!-- Register -->
            <h3 class="mb-6">Hemen üye ol, öğrenmeye başla!</h3>

            <!-- Form Register -->
            <form class="mb-5">

                <!-- Username -->
                <div class="form-group mb-5">
                    <label for="modalSignupUsername1">
                        Adın:
                    </label>
                    <input type="text" class="form-control" v-model="Firstname" placeholder="">
                </div>
                <div class="form-group mb-5">
                    <label for="modalSignupUsername1">
                        Soyadın:
                    </label>
                    <input type="text" class="form-control" v-model="Lastname" placeholder="">
                </div>
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
                <a class="btn btn-block btn-primary" @click="Register()">
                    Üye Ol
                </a>

            </form>

            <!-- Text -->
            <p class="mb-0 font-size-sm text-center">
                Zaten hesabın var mı ? <a class="text-underline" href="Login">Giriş Yap</a>
            </p>
        </div>
    </div>
</div>

<?php require_once("Footer.php"); ?>
<script>
var RegisterApp = new Vue({
    el: "#Register",
    data: {
        Firstname: "",
        Lastname: "",
        Password: "",
        Email: ""
    },
    methods: {
        Register() {

            if (this.Firstname != '' && this.Lastname != '' && this.Email != '' && this.Password != '') {

                axios.post('User/Register', {

                    Firstname: this.Firstname,
                    Lastname: this.Lastname,
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
                    if (response.data.status == 1) {
                        setTimeout(() => {
                            location.href = response.data.Url;
                        }, 2000);
                    }

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