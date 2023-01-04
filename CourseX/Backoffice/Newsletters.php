<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card" id="Newsletters">
                    <div class="card-header">
                        <h4 class="card-title">{{CardTitle}}
                        </h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped">
                                <thead>
                                    <tr>
                                        <th class="text-center">E-Posta</th>
                                        <th class="text-center">Oluşturulma Tarihi</th>

                                        <th class="text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="Newsletter in Newsletters" :key="Newsletter.Id">

                                        <td class="text-center">{{Newsletter.Email}}</td>
                                        </td>
                                        <td class="text-center">{{Newsletter.CreatedDate}}</td>

                                        <td class="text-center">
                                            <a href="javascript:;" @click="deleteNewsletter(Newsletter.Id)"
                                                class="btn btn-sm btn-white text-danger me-2">
                                                <i class="far fa-trash-alt me-1"></i>
                                                Aboenliği Sil
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
let Newsletters = new Vue({

    el: "#Newsletters",
    data: {
        CardTitle: "Tüm Abonelikler",
        Newsletters: []
    },
    watch: {
        Newsletters() {
            $('.datatable').DataTable().destroy();
            this.$nextTick(() => {
                $('.datatable').DataTable()
            });
        }
    },
    async created() {
        await axios.get("../Api/newsletters.json")
            .then((response) => {
                this.Newsletters = response.data;
            })
            .catch((e) => {
                console.log(e);
            });
    },
    methods: {

        deleteNewsletter(NewsletterId) {
            axios.post('Delete/DeleteNewsletter', {

                NewsletterId: NewsletterId

            }).then(function(response) {
                $('.datatable').DataTable();
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