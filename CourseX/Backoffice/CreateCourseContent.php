<?php require_once("Header.php");

$_SESSION["CourseID"] = xss_clean(securty(intval($_GET["Id"])));

?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="FormCourse">
                    <div class="card-header">
                        <h5 class="card-title">{{PageContentTitle}}</h5>
                    </div>
                    <div class="card-body">
                        <form>

                            <div class="form-group">
                                <label>Dosya Seçiniz <small>(.mp4, .pdf)</small>:</label>
                                <div class="change-photo-btn">
                                    <div>
                                        <p>Dosya Ekle</p>
                                    </div>
                                    <input class="upload" type="file" id="CourseFile" ref="CourseFile"
                                        @change="handleFileUpload($event)" />
                                </div>
                            </div> 
                            <div class="form-group">
                                <label>İçerik Başlık:</label>
                                <input type="text" class="form-control" v-model="Title">
                            </div>
                            <div class="form-group">
                                <label>Sıra:</label>
                                <input type="number"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    class="form-control" v-model="Arrangement">
                            </div>
                            
                            <div class="text-end">
                                <a class="btn btn-white text-primary me-2" @click="ButtonAddContent()">
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
var VueFormAddCourse = new Vue({

    el: "#FormCourse",
    data: {
        PageContentTitle: "Kurs İçeriğini Oluştur",
        CourseFile: "",
        Title: "", 
        Arrangement: ""   
    },
  
    methods: {
        ButtonAddContent() {

            if (this.CourseFile != "" &&
                this.Title != "" && 
                this.Arrangement != ""
            ) {
                let formData = new FormData();
                formData.append("CourseFile", this.CourseFile); 
                formData.append("Title", this.Title);
                formData.append("Arrangement", this.Arrangement); 
                axios.post('Add/AddCourseContent', formData, {
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
                toastr.warning("Tüm alanları doldurunuz!", "İçerik Ekle");
            }

        },
        handleFileUpload(event) {
            this.CourseFile = event.target.files[0];
            //console.log(this.CourseFile);
        }
    }
});
</script>