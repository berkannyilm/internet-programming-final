<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="FormLogo">
                    <div class="card-header">
                        <h5 class="card-title">{{PageContentTitle}}</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group col-md-3">
                                <label class="form-label" for="Title">Mevcut Logo: </label><br>
                                <img :src="'../' + CurrentLogoUrl" />
                            </div>
                            <div class="form-group">
                                <label>Yeni Logo Seç:</label>
                                <input type="file" class="form-control" ref="LogoImageUrl" @change="handleFileUpload($event)">
                            </div>

                            <div class="text-end">
                                <a class="btn btn-primary" @click="ButtonUpdateLogo()">Kaydet</a>
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


    var FormLogo = new Vue({

        el: "#FormLogo",
        data: {
            PageContentTitle: "Logo Ayarları",
            CurrentLogoUrl: "<?php echo $Setting["tblSettingLogoUrl"]; ?>",
            LogoImageUrl: "" 
        },
        methods: {
            ButtonUpdateLogo() {

                let formData = new FormData();
                formData.append("LogoImageUrl", this.LogoImageUrl);

                axios.post('Update/UpdateLogo', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (response) {
                    console.log(response.logo);
                    let getResponse = response.data;
                    let getIcon = getResponse.icon;
                    toastr[getIcon](getResponse.message, getResponse.title);

                }).catch(function (error) {
                    console.error(error);
                });

            },
            handleFileUpload(event) {
                this.LogoImageUrl = event.target.files[0];
            }
        }
    });

</script>