<?php require_once("Header.php"); ?>

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
                                    <option v-for="Instructor in Instructors" :value="Instructor.Id" :key="Instructor.Id">{{Instructor.Firstname}} {{Instructor.Lastname}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategori Seç:</label>
                                <select v-model="CategoryId" class="form-control">
                                <option v-for="Category in Categories" :value="Category.Id" :key="Category.Id">{{Category.Title}}</option>

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
                                <textarea cols="20" rows="10" class="form-control" v-model="Summary"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Detay:</label>
                                <textarea cols="20" rows="10" class="form-control" v-model="Detail"></textarea>
                            </div>
                            <div class="text-end">
                                <a class="btn btn-white text-primary me-2" @click="ButtonAddCourse()">
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
        PageContentTitle: "Yeni Kurs Oluştur",
        CourseImageUrl: "",
        Title: "",
        InstructorId: "",
        CategoryId: "",
        Price: "",
        Summary: "",
        Detail: "",
        Instructors: [],
        Categories: []
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
        ButtonAddCourse() {

            if (this.CourseImageUrl != "" &&
                this.Title != "" &&
                this.InstructorId != "" &&
                this.CategoryId != "" &&
                this.Price != "" &&
                this.Summary != "" &&
                this.Detail != ""
            ) {
                let formData = new FormData();
                formData.append("CourseImageUrl", this.CourseImageUrl);
                formData.append("InstructorId", this.InstructorId);
                formData.append("CategoryId", this.CategoryId);
                formData.append("Title", this.Title);
                formData.append("Price", this.Price);
                formData.append("Summary", this.Summary);
                formData.append("Detail", this.Detail);

                axios.post('Add/AddCourse', formData, {
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
                toastr.warning("Tüm alanları doldurunuz!", "Kurs Ekle");
            }

        },
        handleFileUpload(event) {
            this.CourseImageUrl = event.target.files[0];
        }
    }
});
</script>