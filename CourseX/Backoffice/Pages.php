<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card" id="CorporatePages">
                    <div class="card-header">
                        <h4 class="card-title">{{CardTitle}}
                            <div style="float: right;">
                                <a href="AddPage" class="btn btn-sm btn-white text-primary me-2" >
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
                                        <th class="text-center">Sıra</th>
                                        <th class="text-center">Başlık</th>
                                        <th class="text-center">Seo Url</th>
                                        <th class="text-center">Oluşturulma Tarihi</th>
                                        </th>
                                        <th class="text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="Page in Pages" :key="Page.Id">

                                        <td class="text-center">{{Page.Arrangement}}</td>
                                        <td class="text-center">{{Page.Title}}</td>
                                        <td class="text-center">{{Page.SeoUrl}}</td>
                                        </td>
                                        <td class="text-center">{{Page.CreatedDate}}</td>
                                        <td class="text-center">
                                            <a href="javascript:;" @click="updatePage(Page.Id)"
                                                class="btn btn-sm btn-white text-success me-2">
                                                <i class="far fa-edit me-1"></i>
                                                Düzenle
                                            </a>
                                            <a href="javascript:;" @click="deletePage(Page.Id)"
                                                class="btn btn-sm btn-white text-danger me-2">
                                                <i class="far fa-trash-alt me-1"></i>
                                                Sayfayı Sil
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
var Pages = new Vue({

    el: "#CorporatePages",
    data: {
        CardTitle: "Tüm Kurumsal Sayfalar",
        Pages: []
    },
    watch: {
        Pages() {
            $('.datatable').DataTable().destroy();
            this.$nextTick(() => {
                $('.datatable').DataTable()
            });
        }
    },
    async created() {
        await axios.get("../Api/Pages.json")
            .then((response) => {
                this.Pages = response.data;
            })
            .catch((e) => {
                console.log(e);
            });
    },
    methods: {
        updatePage(PageId){
            window.open("UpdatePage?Id=" + PageId, "_blank");
        },
        deletePage(PageId) {
            axios.post('Delete/DeletePage', {

                PageId: PageId

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