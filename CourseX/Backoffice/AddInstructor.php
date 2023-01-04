<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="FormInstructor">
                    <div class="card-header">
                        <h5 class="card-title">{{PageContentTitle}}</h5>
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="form-group">
                                <label>Profil Resmi:</label>
                                <div class="change-photo-btn">
                                    <div>
                                        <p>Resim Ekle</p>
                                    </div>
                                    <input class="upload" type="file" id="ProfileImageUrl" ref="ProfileImageUrl"
                                        @change="handleFileUpload($event)" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Adı:</label>
                                <input type="text" class="form-control" v-model="InputFirstname">
                            </div>
                            <div class="form-group">
                                <label>Soyadı:</label>
                                <input type="text" class="form-control" v-model="InputLastname">
                            </div>
                            <div class="form-group">
                                <label>Telefon:</label>
                                <input type="text" class="form-control" v-model="InputPhone">
                            </div>
                            <div class="form-group">
                                <label>E-Posta:</label>
                                <input type="text" class="form-control" v-model="InputEmail">
                            </div>
                            <div class="form-group">
                                <label>Şifre:</label>
                                <input type="password" class="form-control" v-model="InputPassword">
                            </div>
                            <div class="form-group">
                                <label>Hakkında:</label>
                                <textarea class="form-control" cols="20" rows="10" v-model="InputDetail"></textarea>
                            </div>
                            <div class="text-end">
                                <a class="btn btn-white text-primary me-2" @click="ButtonAddInstructor()">
                                    <i class="far fa-save me-1"></i>
                                    Kaydet</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<?php require_once("Footer.php"); ?>
<script>
var VueFormAddInstructor = new Vue({

    el: "#FormInstructor",
    data: {
        PageContentTitle: "Eğitmen Ekle",
        ProfileImageUrl: "",
        InputFirstname: "",
        InputLastname: "",
        InputEmail: "",
        InputPassword: "",
        InputPhone: "",
        InputPhone: "",
        InputDetail: ""
    },
    methods: {
        ButtonAddInstructor() {
   
            if (
                this.ProfileImageUrl != "" &&
                this.InputFirstname != "" &&
                this.InputLastname != "" &&
                this.InputPassword != "" &&
                this.InputEmail != "" &&
                this.InputPhone != "" &&
                this.InputDetail !=""
            ) {
                let formData = new FormData();
                formData.append("ProfileImageUrl", this.ProfileImageUrl);
                formData.append("InputFirstname", this.InputFirstname);
                formData.append("InputLastname", this.InputLastname);
                formData.append("InputEmail", this.InputEmail);
                formData.append("InputPassword", this.InputPassword);
                formData.append("InputPhone", this.InputPhone);
                formData.append("InputDetail", this.InputDetail);

                axios.post('Add/AddInstructor', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function(response) {

                    let getResponse = response.data;
                    let getIcon = getResponse.icon;
                    toastr[getIcon](getResponse.message, getResponse.title);

                }).catch(function(error) {
                    console.error(error);
                });
            } else {
                toastr.warning("Tüm alanları doldurunuz!", "Eğitmen Ekle");
            }

        },
        handleFileUpload(event) {
            this.ProfileImageUrl = event.target.files[0];
        }
    }
});
</script>