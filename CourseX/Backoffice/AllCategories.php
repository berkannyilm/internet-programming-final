<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card" id="Categories">
                    <div class="card-header">
                        <h4 class="card-title">{{CardTitle}} <div style="float: right;">
                                <a href="AddCategory" class="btn btn-sm btn-white text-primary me-2"
                                    data-bs-toggle="modal" data-bs-target=".addCategory">
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

                                        <th class="text-center">Kategori Adı</th>
                                        <th class="text-center">Kategori Seo Url</th>
                                        <th class="text-center">Oluşturulma Tarihi</th>
                                        <th class="text-center">Durum</th>
                                        <th class="text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="Category in Categories" :key="Category.Id">

                                        <td class="text-center">{{Category.Title}}</td>
                                        <td class="text-center">{{Category.SeoUrl}}</td>
                                        <td class="text-center">{{Category.CreatedDate}}</td>
                                        </td>
                                        <td v-if="Category.Status=='Active'" class="text-center">
                                            <span class="badge badge-pill bg-success-light">Aktif</span>
                                        </td>
                                        <td v-else class="text-center">
                                            <button class="btn btn-sm btn-white text-danger me-2">Pasif</button>
                                        </td>
                                        <td v-if="Category.Status=='Active'" class="text-center">
                                            <a href="javascript:;" class="btn btn-sm btn-white text-success me-2"
                                            @click='identifySelectedCategory(Category.Id, Category.Title)'
                                            data-bs-toggle="modal" data-bs-target=".updateCategory">
                                                <i class="far fa-edit me-1"></i>
                                                Düzenle
                                            </a>
                                            <a href="javascript:;" @click="deleteCategory(Category.Id)"
                                                class="btn btn-sm btn-white text-danger me-2">
                                                <i class="far fa-trash-alt me-1"></i>
                                                Kategoriyi Pasif Et
                                            </a>
                                        </td>
                                        <td v-else class="text-center">
                                            <a href="javascript:;" @click="activedCategory(Category.Id)"
                                                class="badge badge-pill bg-success-light">
                                                <i class="fa fa-check me-1"></i>
                                                Kategoryi Aktif Et
                                            </a>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal fade addCategory" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Yeni Kategori Ekle</h4>
                                        <input type="text" class="form-control" v-model="categoryTitle">
                                        <button type="button" class="btn btn-warning my-2"
                                            @click="addCategory()">Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade updateCategory" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-4">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">Kategori Düzenle</h4>
                                        <input type="text" class="form-control" v-model="updateCategoryTitle">
                                        <button type="button" class="btn btn-warning my-2"
                                            @click="updateCategory()">Kaydet</button>
                                    </div>
                                </div>
                            </div>
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
var Categories = new Vue({

    el: "#Categories",
    data: {
        CardTitle: "Tüm Ana Kategoriler",
        categoryTitle: "",
        categoryId: "",
        updateCategoryTitle: "",
        Categories: []
    },
    watch: {
        Categories() {
            $('.datatable').DataTable().destroy();
            this.$nextTick(() => {
                $('.datatable').DataTable()
            });
        }
    },
    async created() {
        await axios.get("../Api/categories.json")
            .then((response) => {
                this.Categories = response.data;
                $('.datatable').DataTable()
            })
            .catch((e) => {
                console.log(e);
            });
    },
    methods: {
        addCategory() {

            axios.post('Add/AddCategory', {

                CategoryTitle: this.categoryTitle

            }).then(function(response) {

                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });

        },
        updateCategory() {
             
            axios.post('Update/UpdateCategory', { 

                CategoryId: this.categoryId,
                CategoryTitle: this.updateCategoryTitle

            }).then(function(response) { 
                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });


        },
        deleteCategory(CategoryId) {
            axios.post('Delete/DeleteCategory', {

                CategoryId: CategoryId

            }).then(function(response) {

                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });

        },
        activedCategory(CategoryId) {
            axios.post('Update/ActivedCategory', {

                CategoryId: CategoryId

            }).then(function(response) {

                let getResponse = response.data;
                let getIcon = getResponse.icon;
                toastr[getIcon](getResponse.message, getResponse.title);
                pageReload();

            }).catch(function(error) {
                console.error(error);
            });

        },
        identifySelectedCategory(id, title) {
            this.categoryId = id;
            this.updateCategoryTitle = title; 
           // alert(this.categoryId + " " + this.updateCategoryTitle);
        }
    },
    mounted() {
        $('.datatable').DataTable()
    }
});
</script>