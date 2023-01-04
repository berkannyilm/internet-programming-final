<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card" id="Courses">
                    <div class="card-header">
                        <h4 class="card-title">{{CardTitle}} <div style="float: right;">
                                <a href="AddCourse" class="btn btn-sm btn-white text-primary me-2">
                                    <i class="fa fa-plus me-1"></i>
                                    Yeni Kayıt
                                </a>
                            </div>
                        </h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Eğitmen</th>
                                        <th class="text-center">Kurs Görüntü</th>
                                        <th class="text-center">Eğitmen Adı Soyadı</th> </th>
                                        <th class="text-center">Kurs Adı</th>
                                        <th class="text-center">Kategori Adı</th>
                                        <th class="text-center">Rating</th>
                                        <th class="text-center">Oluşturulma Tarihi</th>
                                        <th class="text-center">İçerik Ekle</th>
                                        <th class="text-center">Durum</th>
                                        <th class="text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="Course in Courses" :key="Course.Id">
                                        <td class="text-center"><img width="50" height="50" :src="'../'+Course.IProfileImageUrl"
                                                alt="Course.Firstname">
                                        </td>
                                        <td class="text-center"><img width="100" height="50" :src="'../'+Course.ImageUrl"
                                                alt="Course.Title">
                                        </td>
                                        <td class="text-center">{{Course.IFirstnameAndLastname}}</td>
                                        <td class="text-center">{{Course.Title}}</td>
                                        <td class="text-center">{{Course.CategoryTitle}}</td>
                                        <td class="text-center">{{Course.Rating}}</td>
                                        <td class="text-center">{{Course.CreatedDate}}</td>
                                        <td class="text-center">
                                            <a href="javascript:;" @click="addCourseContent(Course.Id)"
                                            class="badge badge-pill bg-primary-light">
                                                <i class="fa fa-desktop me-1"></i>
                                               İçerik Ekle
                                            </a>
                                         
                                        </td>
                                        <td v-if="Course.Status=='Active'"  class="text-center">
                                            <span class="badge badge-pill bg-success-light">Aktif</span>
                                        </td> 
                                        <td v-else  class="text-center">
                                            <button class="btn btn-sm btn-white text-danger me-2">Pasif</button>
                                        </td>
                                        <td v-if="Course.Status=='Active'"  class="text-center">
                                            <a href="javascript:;" @click="updateCourse(Course.Id)"
                                                class="btn btn-sm btn-white text-success me-2">
                                                <i class="far fa-edit me-1"></i>
                                                Düzenle
                                            </a>
                                            <a href="javascript:;" @click="deleteCourse(Course.Id)"
                                                class="btn btn-sm btn-white text-danger me-2">
                                                <i class="far fa-trash-alt me-1"></i>
                                                Kursu Pasif Et
                                            </a>
                                        </td>
                                        <td v-else class="text-center">
                                            <a href="javascript:;" @click="activedCourse(Course.Id)"
                                                class="badge badge-pill bg-success-light">
                                                <i class="fa fa-check me-1"></i>
                                                Kursu Aktif Et
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<?php require_once("Footer.php"); ?>

<script>
var Courses = new Vue({

    el: "#Courses",
    data: {
        CardTitle: "Tüm Kurslar",
        Courses: []
    },
    watch: {
        Courses() {
            $('.datatable').DataTable().destroy();
            this.$nextTick(() => {
                $('.datatable').DataTable()
            });
        }
    },
    async created() {
        await axios.get("../Api/courses.json")
            .then((response) => {
                this.Courses = response.data;
                $('.datatable').DataTable()
            })
            .catch((e) => {
                console.log(e);
            });
    },
    methods: {
        updateCourse(CourseId) {

            window.open("UpdateCourse?Id=" + CourseId, "_blank");

        },
        deleteCourse(CourseId) {
            axios.post('Delete/DeleteCourse', {

                CourseId: CourseId

            }).then(function(response) {

                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });

        },
        activedCourse(CourseId) {
            axios.post('Update/ActivedCourse', {

                CourseId: CourseId

            }).then(function(response) {

                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });

        },
        addCourseContent(CourseId) {

            window.open("CreateCourseContent?Id=" + CourseId, "_blank");

        }
    },
    mounted() {
        $('.datatable').DataTable()
    }
});
</script>