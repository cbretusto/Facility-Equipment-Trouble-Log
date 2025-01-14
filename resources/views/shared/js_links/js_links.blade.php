<!-- jQuery -->
<script src="{{ asset('public/template/jquery/js/jquery.min.js') }}"></script>

<!-- Bootstrap 5 -->
<script src="{{ asset('public/template/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/template/bootstrap/js/popper.min.js') }}"></script>

<!-- AdminLTE -->
<script src="{{ asset('public/template/adminlte/js/adminlte.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('public/template/datatables/js/datatables.min.js') }}"></script>
{{-- <script src="{{ asset('/template/datatables/js/dataTables.bootstrap5.min.js') }}"></script> --}}

<!-- Select2 -->
<script src="{{ asset('public/template/select2/js/select2.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('public/template/toastr/js/toastr.min.js') }}"></script>

<script src="{{ asset('public/template/moment/moment.min.js') }}"></script>

<!-- Custom JS -->
<script>
    toastr.options = {
        "closeButton"       : false,
        "debug"             : false,
        "newestOnTop"       : true,
        "progressBar"       : true,
        "positionClass"     : "toast-top-right",
        "preventDuplicates" : false,
        "onclick"           : null,
        "showDuration"      : "300",
        "hideDuration"      : "2000",
        "timeOut"           : "2000",
        "extendedTimeOut"   : "2000",
        "showEasing"        : "swing", 
        "hideEasing"        : "linear",
        "showMethod"        : "fadeIn",
        "hideMethod"        : "fadeOut",
        "iconClass"         :  "toast-custom"
    };
</script>

<script src="{{ asset('public/js/User.js?n=1') }}"></script>
<script src="{{ asset('public/js/Equipments.js?n=2') }}"></script>
<script src="{{ asset('public/js/EquipmentModel.js?n=1') }}"></script>
<script src="{{ asset('public/js/FETL.js?n=1') }}"></script>
