<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="FormSocialMedia">
                    <div class="card-header">
                        <h5 class="card-title">{{PageContentTitle}}</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Facebook Kullanıcı Adı:</label>
                                <input type="text" class="form-control" v-model="InputFacebook">
                            </div>
                            <div class="form-group">
                                <label>Instagram Kullanıcı Adı:</label>
                                <input type="text" class="form-control" v-model="InputInstagram">
                            </div>
                            <div class="form-group">
                                <label>Linkedin Kullanıcı Adı:</label>
                                <input type="text" class="form-control" v-model="InputLinkedin">
                            </div>
                            <div class="form-group">
                                <label>Twitter Kullanıcı Adı:</label>
                                <input type="text" class="form-control" v-model="InputTwitter">
                            </div>
                            <div class="form-group">
                                <label>Youtube Kanal Adı:</label>
                                <input type="text" class="form-control" v-model="InputYoutube">
                            </div>
                            <div class="text-end">
                                <a class="btn btn-primary" @click="ButtonUpdateSocialMedia()">Kaydet</a>
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
    var VueFormSocialMedia = new Vue({

        el: "#FormSocialMedia",
        data: {
            PageContentTitle: "Sosyal Medya Ayarları",
            InputFacebook: "<?php echo $Setting["tblSettingFacebook"]; ?>",
            InputInstagram: "<?php echo $Setting["tblSettingInstagram"]; ?>",
            InputTwitter: "<?php echo $Setting["tblSettingTwitter"]; ?>",
            InputLinkedin: "<?php echo $Setting["tblSettingLinkedin"]; ?>",
            InputYoutube: "<?php echo $Setting["tblSettingYoutube"]; ?>"
        },
        methods: {
            ButtonUpdateSocialMedia() {

                axios.post('Update/UpdateSocialMedia', {
                    InputFacebook: this.InputFacebook,
                    InputInstagram: this.InputInstagram,
                    InputTwitter: this.InputTwitter,
                    InputLinkedin: this.InputLinkedin,
                    InputYoutube: this.InputYoutube,

                }).then(function (response) {

                    let getResponse = response.data;
                    let getIcon = getResponse.icon;
                    toastr[getIcon](getResponse.message, getResponse.title);

                }).catch(function (error) {
                    console.error(error);
                });


            }
        }
    });
</script>