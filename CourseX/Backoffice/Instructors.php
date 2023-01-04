<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card" id="Instructors">
                    <div class="card-header">
                        <h4 class="card-title">{{CardTitle}} <div style="float: right;">
                                <a href="AddInstructor" class="btn btn-sm btn-white text-primary me-2">
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
                                        <th class="text-center">Profil</th>
                                        <th class="text-center">Adı</th>
                                        <th class="text-center">Soyadı</th>
                                        <th class="text-center">Puanlama</th>
                                        <th class="text-center">Oluşturulma Tarihi</th>
                                        <th class="text-center">Durum</th>
                                        <th class="text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="Instructor in Instructors" :key="Instructor.Id">
                                        <td class="text-center"><img width="75" height="75" :src="'../'+Instructor.ProfileImageUrl"
                                                alt="Instructor.Firstname">
                                        </td>
                                        <td class="text-center">{{Instructor.Firstname}}</td>
                                        <td class="text-center">{{Instructor.Lastname}}</td>
                                        <td class="text-center">{{Instructor.Rating}}</td>
                                        <td class="text-center">{{Instructor.CreatedDate}}</td>
                                        <td v-if="Instructor.Status=='Active'"  class="text-center">
                                            <span class="badge badge-pill bg-success-light">Aktif</span>
                                        </td>
                                        <td v-else  class="text-center">
                                            <button class="btn btn-sm btn-white text-danger me-2">Pasif</button>
                                        </td>
                                        <td v-if="Instructor.Status=='Active'"  class="text-center">
                                            <a href="javascript:;" @click="updateInstructor(Instructor.Id)"
                                                class="btn btn-sm btn-white text-success me-2">
                                                <i class="far fa-edit me-1"></i>
                                                Düzenle
                                            </a>
                                            <a href="javascript:;" @click="deleteInstructor(Instructor.Id)"
                                                class="btn btn-sm btn-white text-danger me-2">
                                                <i class="far fa-trash-alt me-1"></i>
                                                Hesabı Pasif Et
                                            </a>
                                        </td>
                                        <td v-else class="text-center">
                                            <a href="javascript:;" @click="activedInstructor(Instructor.Id)"
                                                class="badge badge-pill bg-success-light">
                                                <i class="fa fa-check me-1"></i>
                                                Hesabı Aktif Et
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
var Instructors = new Vue({

    el: "#Instructors",
    data: {
        CardTitle: "Tüm Eğitmenler",
        Instructors: []
    },
    watch: {
        Instructors() {
            $('.datatable').DataTable().destroy();
            this.$nextTick(() => {
                $('.datatable').DataTable()
            });
        }
    },
    async created() {
        await axios.get("../Api/instructors.json")
            .then((response) => {
                this.Instructors = response.data;
                $('.datatable').DataTable()
            })
            .catch((e) => {
                console.log(e);
            });
    },
    methods: {
        updateInstructor(InstructorId) {

            window.open("UpdateInstructor?Id=" + InstructorId, "_blank");

        },
        deleteInstructor(InstructorId) {
            axios.post('Delete/DeleteInstructor', {

                InstructorId: InstructorId

            }).then(function(response) {

                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });

        },
        activedInstructor(InstructorId) {
            axios.post('Update/ActivedInstructor', {

                InstructorId: InstructorId

            }).then(function(response) {

                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });

        }
    },
    mounted() {
        $('.datatable').DataTable()
    }
});
</script>