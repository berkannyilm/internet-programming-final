<?php require_once("Header.php"); 
$Id = xss_clean(securty(intval($_GET["Id"])));
$GetCourse = $connection->prepare("SELECT * FROM tblcourses WHERE tblCourseId= :tblCourseId");
$GetCourse->bindParam(":tblCourseId", $Id, PDO::PARAM_INT);
$GetCourse->execute();
$GetCourse = $GetCourse->fetch(PDO::FETCH_ASSOC);


$_SESSION["CourseImageUrl"] = $GetCourse["tblCourseImageUrl"];
$_SESSION["CourseId"] = $GetCourse["tblCourseId"];
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
                            <div class="form-group col-sm-2">
                                <label>Kurs Görüntüsü:</label>
                                <img :src="'../'+CurrentProfileImageUrl">
                            </div>
                            <div class="form-group">
                                <label>Resim Seçiniz:</label>
                                <div class="change-photo-btn">
                                    <div>
                                        <p>Resim Ekle</p>
                                    </div>
                                    <input class="upload" type="file" id="CourseImageUrl" ref="CourseImageUrl"
                                        @change="handleFileUpload($event)" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Eğitmen Seç:</label>
                                <select v-model="InstructorId" class="form-control">
                                    <option v-for="Instructor in Instructors" :value="Instructor.Id"
                                        :key="Instructor.Id">{{Instructor.Firstname}} {{Instructor.Lastname}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategori Seç:</label>
                                <select v-model="CategoryId" class="form-control">
                                    <option v-for="Category in Categories" :value="Category.Id" :key="Category.Id">
                                        {{Category.Title}}</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kurs Adı:</label>
                                <input type="text" class="form-control" v-model="Title">
                            </div>
                            <div class="form-group">
                                <label>Fiyat:</label>
                                <input type="number"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    class="form-control" v-model="Price">
                            </div>
                            <div class="form-group">
                                <label>Özet:</label>
                                <textarea cols="20" rows="10" class="form-control"
                                    v-model="Summary">{{Summary}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Detay:</label>
                                <textarea cols="20" rows="10" class="form-control"
                                    v-model="Detail">{{Detail}}</textarea>
                            </div>
                            <div class="text-end">
                                <a class="btn btn-white text-primary me-2" @click="ButtonUpdateCourse()">
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
        PageContentTitle: "<?php echo $GetCourse["tblCourseTitle"]; ?>",
        CurrentProfileImageUrl: "<?php echo $GetCourse["tblCourseImageUrl"]; ?>",
        CourseImageUrl: "",
        Title: "<?php echo $GetCourse["tblCourseTitle"]; ?>",
        InstructorId: "<?php echo $GetCourse["tblInstructorId"]; ?>",
        CategoryId: "<?php echo $GetCourse["tblCourseCategoryId"]; ?>",
        Price: "<?php echo $GetCourse["tblCoursePrice"]; ?>", 
        Summary: "<?php echo $GetCourse["tblCourseSummary"]; ?>",
        Detail: "<?php echo $GetCourse["tblCourseDetail"]; ?>", 
        Instructors: [],
        Categories: [],
    },
    async created() {
        await axios.get("../Api/instructors.json")
            .then((response) => {
                this.Instructors = response.data;
                console.log(this.Instructors);
            })
            .catch((e) => {
                console.log(e);
            });

        await axios.get("../Api/categories.json")
            .then((response) => {
                this.Categories = response.data;
                console.log(this.Categories);
            })
            .catch((e) => {
                console.log(e);
            });

    },
    methods: {
        ButtonUpdateCourse() {

            if ( 
                this.Title != "" &&
                this.CourseId != "" &&
                this.CategoryId != "" &&
                this.InstructorId != "" &&
                this.Price != "" &&
                this.Summary != "" &&
                this.Detail != ""
            ) {
                let formData = new FormData();
                formData.append("CourseImageUrl", this.CourseImageUrl);
                formData.append("CourseId", this.CourseId);
                formData.append("CategoryId", this.CategoryId);
                formData.append("InstructorId", this.InstructorId);
                formData.append("Title", this.Title);
                formData.append("Price", this.Price);
                formData.append("Summary", this.Summary);
                formData.append("Detail", this.Detail);

                axios.post('Update/UpdateCourse', formData, {
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
            this.CourseImageUrl = event.target.files[0];
        }
    }
});
</script>