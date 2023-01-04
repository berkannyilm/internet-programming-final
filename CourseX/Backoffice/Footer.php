<script src="assets/js/jquery-3.6.0.min.js"></script>

<script src="assets/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/feather.min.js"></script>
 
<script src="assets/js/select2.min.js"></script>  

<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="assets/js/jquery.maskedinput.min.js"></script>
<script src="assets/js/mask.js"></script>

<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="assets/plugins/apexchart/chart-data.js"></script>

<script src="assets/plugins/toastr/toastr.min.js"></script>
<script src="assets/plugins/toastr/toastr.js"></script>

<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/datatables.min.js"></script>

<script src="assets/js/script.js"></script>  
<script src="assets/js/custom.js"></script> 
<script src="assets/js/custom.js"></script>
<script src="assets/js/vue.js"></script>
<script src="assets/js/axios.min.js"></script>
<script>
    $(".right-side-views").hide();
</script>
 
<script>
    let logoutButton = document.getElementById("Logout");
    logoutButton.addEventListener("click", () => {
        toastr.success("Çıkış işlemi yapıldı!", "Backoffice"); 
        setTimeout(() => {
            location.href = "Logout";
        }, 2000);
    });
</script>

</body>

</html>