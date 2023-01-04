<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card" id="Students">
                    <div class="card-header">
                        <h4 class="card-title">{{CardTitle}}  
                        </h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped">
                                <thead>
                                    <tr> </tr>
                                        <th class="text-center">Adı</th>
                                        <th class="text-center">Soyadı</th> 
                                      <th class="text-center">Oluşturulma Tarihi</th>
                                        <th class="text-center">Durum</th>
                                        <th class="text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="Student in Students" :key="Student.Id">
                                       
                                        <td class="text-center">{{Student.Firstname}}</td>
                                        <td class="text-center">{{Student.Lastname}}</td> 
                                        
                                        <td class="text-center">{{Student.CreatedDate}}</td>
                                        <td v-if="Student.Status=='Active'"  class="text-center">
                                            <span class="badge badge-pill bg-success-light">Aktif</span>
                                        </td>
                                        <td v-else  class="text-center">
                                            <button class="btn btn-sm btn-white text-danger me-2">Pasif</button>
                                        </td>
                                        <td v-if="Student.Status=='Active'"  class="text-center"> 
                                             <a href="javascript:;" @click="deleteStudent(Student.Id)"
                                                class="btn btn-sm btn-white text-danger me-2">
                                                <i class="far fa-trash-alt me-1"></i>
                                                Hesabı Pasif Et
                                            </a>
                                        </td>
                                        <td v-else class="text-center">
                                            <a href="javascript:;" @click="activedStudent(Student.Id)"
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
var Students = new Vue({

    el: "#Students",
    data: {
        CardTitle: "Tüm Öğrenciler",
        Students: []
    },
    watch: {
        Students() {
            $('.datatable').DataTable().destroy();
            this.$nextTick(() => {
                $('.datatable').DataTable()
            });
        }
    },
    async created() {
        await axios.get("../Api/students.json")
            .then((response) => {
                this.Students = response.data;
                $('.datatable').DataTable()
            })
            .catch((e) => {
                console.log(e);
            });
    },
    methods: {
        
        deleteStudent(StudentId) {
            axios.post('Delete/DeleteStudent', {

                StudentId: StudentId

            }).then(function(response) {

                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });

        },
        activedStudent(StudentId) {
            axios.post('Update/ActivedStudent', {

                StudentId: StudentId

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