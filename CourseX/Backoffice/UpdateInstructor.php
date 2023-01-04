<?php require_once("Header.php");
$Id = xss_clean(securty(intval($_GET["Id"])));
$GetInstructor = $connection->prepare("SELECT * FROM tblinstructors WHERE tblInstructorId= :tblInstructorId");
$GetInstructor->bindParam(":tblInstructorId", $Id, PDO::PARAM_INT);
$GetInstructor->execute();
$GetInstructor = $GetInstructor->fetch(PDO::FETCH_ASSOC);
$_SESSION["ImageUrl"] = $GetInstructor["tblInstructorImageUrl"];
$_SESSION["InstructorId"] = $GetInstructor["tblInstructorId"];
?>

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
                            <div class="form-group col-sm-2">
                                <label>Profil Resmi:</label>
                                <img :src="'../'+CurrentProfileImageUrl">
                            </div>
                            <div class="form-group">
                                <label>Yeni Profil Resmi Seç:</label>
                                <div class="change-photo-btn">
                                    <div>
                                        <p>Yeni Resim Ekle</p>
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
                                <input type="text" disabled class="form-control" v-model="InputEmail">
                            </div>
                            <div class="form-group">
                                <label>Şifre:</label>
                                <input type="password" class="form-control" v-model="InputPassword">
                            </div>
                            <div class="form-group">
                                <label>Hakkında:</label>
                                <textarea class="form-control" cols="20" rows="10" v-model="InputDetail">{{InputDetail}}</textarea>
                            </div>
                            <div class="text-end">
                                <a class="btn btn-white text-primary me-2" @click="ButtonUpdateInstructor()">
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
        PageContentTitle: "<?php echo $GetInstructor["tblInstructorFirstname"] . " " . $GetInstructor["tblInstructorLastname"]; ?> Hesap Bilgilerini Güncelle",
        CurrentProfileImageUrl: "<?php echo $GetInstructor["tblInstructorImageUrl"]; ?>",
        ProfileImageUrl: "",
        InputFirstname: "<?php echo $GetInstructor["tblInstructorFirstname"]; ?>",
        InputLastname: "<?php echo $GetInstructor["tblInstructorLastname"]; ?>",
        InputEmail: "<?php echo $GetInstructor["tblInstructorEmail"]; ?>",
        InputPassword: "<?php echo $GetInstructor["tblInstructorPassword"]; ?>",
        InputPhone: "<?php echo $GetInstructor["tblInstructorPhone"]; ?>",
        InputDetail: "<?php echo $GetInstructor["tblInstructorDetail"]; ?>"
    },
    methods: {
        ButtonUpdateInstructor() {

            if ( 
                this.InputFirstname != "" &&
                this.InputLastname != "" &&
                this.InputPassword != "" && 
                this.InputPhone != "" &&
                this.InputDetail !=""
            ) {
              
                let formData = new FormData();
                formData.append("ProfileImageUrl", this.ProfileImageUrl);
                formData.append("InputFirstname", this.InputFirstname);
                formData.append("InputLastname", this.InputLastname); 
                formData.append("InputPassword", this.InputPassword);
                formData.append("InputPhone", this.InputPhone);
                formData.append("InputDetail", this.InputDetail);

                axios.post('Update/UpdateInstructor', formData, {
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