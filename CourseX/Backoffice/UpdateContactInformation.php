<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="FormContactInformation">
                    <div class="card-header">
                        <h5 class="card-title">{{PageContentTitle}} </h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Şirket Unvanı:</label>
                                <input type="text" class="form-control" v-model="InputCompanyTitle">
                            </div>
                            <div class="form-group">
                                <label>Kurumsal Bilgi E-Posta:</label>
                                <input type="text" class="form-control" v-model="InputCorporateEmail">
                            </div>
                            <div class="form-group">
                                <label>Kurumsal Destek E-Posta:</label>
                                <input type="text" class="form-control" v-model="InputCorporateSupportEmail">
                            </div>
                            <div class="form-group">
                                <label>Kurumsal Destek E-Posta:</label>
                                <input type="text" class="form-control" v-model="InputCorporateSupportEmail">
                            </div>
                            <div class="form-group">
                                <label>Kurumsal Telefon:</label>
                                <input type="text" class="form-control"  v-model="InputPhone">
                            </div>
                            <div class="form-group">
                                <label>GSM Telefon:</label>
                                <input type="text" id="" class="form-control" v-model="InputGsmPhone">
                            </div>
                            <div class="form-group">
                                <label>Açık Adres:</label>
                                <textarea class="form-control" v-model="InputAddres">{{InputAddres}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Sehir:</label>
                                <input type="text" v-model="SelectedCity" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>İlçe:</label>
                                <input type="text" v-model="SelectedNeighbourhood" class="form-control">
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
    
    var VueFormContactInformation = new Vue({ 

        el: "#FormContactInformation",
        data: {
            PageContentTitle: "İletişim Bilgileri",
            InputCompanyTitle: "<?php echo $Setting["tblSettingCompanyTitle"]; ?>",
            InputCorporateEmail: "<?php echo $Setting["tblSettingEmail"]; ?>",
            InputCorporateSupportEmail: "<?php echo $Setting["tblSettingSupportEmail"]; ?>",
            InputPhone: "<?php echo $Setting["tblSettingPhone"]; ?>",
            InputGsmPhone: "<?php echo $Setting["tblSettingGsm"]; ?>",
            InputAddres: "<?php echo $Setting["tblSettingAddress"]; ?>",
            SelectedCity: "<?php echo $Setting["tblSettingCity"]; ?>",
            SelectedNeighbourhood: "<?php echo $Setting["tblSettingDistrict"]; ?>" 
        },
        methods: {
            
            ButtonUpdateSocialMedia() {
       
                axios.post('Update/UpdateContactInformation', {

                    InputCompanyTitle: this.InputCompanyTitle,
                    InputCorporateEmail: this.InputCorporateEmail,
                    InputCorporateSupportEmail: this.InputCorporateSupportEmail,
                    InputPhone: this.InputPhone,
                    InputGsmPhone: this.InputGsmPhone,
                    InputAddres: this.InputAddres,
                    SelectedCity: this.SelectedCity,
                    SelectedNeighbourhood: this.SelectedNeighbourhood

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