{{-- end content-wrapper (header)--}}
</div>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="#">ISOMARCO</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('Assets/Backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('Assets/Backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('Assets/Backend/js/adminlte.min.js')}}"></script>
<!-- Sweet alert2 -->
<script src="{{asset('Assets/Backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
    $(document).ready(function(){
       $(document).on("click", "#header_exit_button", function(){
           Swal.fire({
               title: "Çıxmaq istədiyinizdən əminsiniz ?",
               text: "",
               icon: 'question',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: "Bəli",
               cancelButtonText: "Xeyr"
           }).then((result) => {
               if (result.isConfirmed) {
                   window.location.href = "{{route('Backend_Logout')}}";
               }
           })
       });
    });
</script>
