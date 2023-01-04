<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="FormMetaTag">
                    <div class="card-header">
                        <h5 class="card-title">{{PageContentTitle}}</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Meta Tag Title</label>
                                <input type="text" class="form-control" v-model="MetaTagTitle">
                            </div>
                            <div class="form-group">
                                <label>Meta Tag Description</label>
                                <textarea cols="30" rows="10" class="form-control"
                                    v-model="MetaTagDescription">{{MetaTagDescription}}</textarea>
                            </div>
                            <div class="text-end">
                                <a class="btn btn-primary" @click="ButtonUpdateMetaTag()">Kaydet</a>
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
    var VueFormMetaTag = new Vue({

        el: "#FormMetaTag",
        data: {
            PageContentTitle: "Meta Tag Ayarları",
            MetaTagTitle: "<?php echo $Setting["tblSettingTitle"]; ?>",
            MetaTagDescription: "<?php echo $Setting["tblSettingDescription"]; ?>"
        },
        methods: {
            ButtonUpdateMetaTag() {

                if (this.MetaTagTitle != '' && this.MetaTagDescription != '') {

                    axios.post('Update/UpdateMetaTag', {

                        MetaTagTitle: this.MetaTagTitle,
                        MetaTagDescription: this.MetaTagDescription

                    }).then(function (response) {

                        let getResponse = response.data;
                        let getIcon = getResponse.icon;
                        toastr[getIcon](getResponse.message, getResponse.title);

                    }).catch(function (error) {
                        console.error(error);
                    });

                } else {

                    toastr.warning("Tüm alanları doldurunuz!", "Meta Tag Ayarlar");

                }
            }
        }
    });
</script>