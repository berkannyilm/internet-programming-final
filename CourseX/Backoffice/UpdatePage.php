<?php require_once("Header.php");
$Id = xss_clean(securty(intval($_GET["Id"])));
$GetPage = $connection->prepare("SELECT * FROM tblpages WHERE tblPageId= :tblPageId");
$GetPage->bindParam(":tblPageId", $Id, PDO::PARAM_INT);
$GetPage->execute();
$GetPage = $GetPage->fetch(PDO::FETCH_ASSOC);
 
$_SESSION["tblPageId"] = $GetPage["tblPageId"];
?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="UpdatePage">
                    <div class="card-header">
                        <h5 class="card-title">{{PageContentTitle}}</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Kurumsal Sayfa Sıra</label>
                                <input type="number" class="form-control" v-model="PageArrangement">
                            </div>
                            <div class="form-group">
                                <label>Kurumsal Sayfa Başlık</label>
                                <input type="text" class="form-control" v-model="PageTitle">
                            </div>
                            <div class="form-group">
                                <label>Kurumsal Sayfa Detay</label>
                                <textarea cols="30" rows="10" class="form-control"
                                    v-model="PageDetail">{{PageDetail}}</textarea>
                            </div>
                            <div class="text-end">
                                <a class="btn btn-primary" @click="ButtonUpdatePage()">Kaydet</a>
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
var VueUpdatePage = new Vue({

    el: "#UpdatePage",
    data: {
        PageContentTitle: "<?php echo $GetPage["tblPageTitle"]; ?>",
        PageTitle: "<?php echo $GetPage["tblPageTitle"]; ?>",
        PageDetail: "<?php echo $GetPage["tblPageDetail"]; ?>",
        PageArrangement: "<?php echo $GetPage["tblPageArrangement"]; ?>"
    },
    methods: {
        ButtonUpdatePage() {

            if (this.PageTitle != '' && this.PageDetail != '' && this.PageArrangement != "") {

                axios.post('Update/UpdatePage', {
                    PageArrangement: this.PageArrangement,
                    PageTitle: this.PageTitle,
                    PageDetail: this.PageDetail

                }).then(function(response) {

                    let getResponse = response.data;
                    let getIcon = getResponse.icon;
                    toastr[getIcon](getResponse.message, getResponse.title);

                }).catch(function(error) {
                    console.error(error);
                });

            } else {

                toastr.warning("Tüm alanları doldurunuz!", "Kurumsal Sayfa Ayarlar");

            }
        }
    }
});
</script>