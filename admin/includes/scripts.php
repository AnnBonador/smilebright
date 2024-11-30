<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- Bootstrap 4 -->
<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- ChartJS -->
<script src="../../assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<!-- DataTables  & Plugins -->
<script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../assets/plugins/jszip/jszip.min.js"></script>
<script src="../../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../assets/plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../../assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- SweetAlert2 -->
<script src="../../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../../assets/plugins/toastr/toastr.min.js"></script>
<!-- Datetimepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="../../assets/plugins/moment/moment.min.js"></script>
<script src="../../assets/plugins/fullcalendar/main.js"></script>
<!-- AdminLTE App -->
<script src="../../assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../assets/dist/js/demo.js"></script>
<script src="../../assets/dist/js/date.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../assets/dist/js/pages/dashboard.js"></script>
<!-- Summernote -->
<script src="../../assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="../../assets/plugins/inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="../../assets/dist/js/countrystatecity.js"></script>
<script src="../../assets/dist/js/custom.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(600, 0).slideUp(600, function() {
            $(this).remove();
        });
    }, 4000);
</script>
<script>
    jQuery(function($) {
        $(".js-phone").inputmask({
            mask: ["+639999999999"],
            jitMasking: 3,
            showMaskOnHover: false,
            autoUnmask: true,
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#password').keyup(function() {

            if ($(this).val().length == 0) {
                $('.show_hide').hide();
            } else {
                $('.show_hide').show();
            }
        }).keyup();

        $('#password').keyup(function() {
            var password = $('#password').val();
            if (checkStrength(password) == false) {
                password.setCustomValidity('');

            }
        });

     function checkStrength(password) {
    var strength = 0;

    // Lowercase and uppercase character validation
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
        strength += 1;
        $('.low-upper-case').addClass('text-success').find('i').removeClass('fa-exclamation-triangle').addClass('fa-check');
    } else {
        $('.low-upper-case').removeClass('text-success').find('i').addClass('fa-exclamation-triangle').removeClass('fa-check');
    }

    // Number and letter validation
    if (/[a-zA-Z]/.test(password) && /[0-9]/.test(password)) {
        strength += 1;
        $('.one-number').addClass('text-success').find('i').removeClass('fa-exclamation-triangle').addClass('fa-check');
    } else {
        $('.one-number').removeClass('text-success').find('i').addClass('fa-exclamation-triangle').removeClass('fa-check');
    }

    // Special character validation
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        strength += 1;
        $('.one-special-char').addClass('text-success').find('i').removeClass('fa-exclamation-triangle').addClass('fa-check');
    } else {
        $('.one-special-char').removeClass('text-success').find('i').addClass('fa-exclamation-triangle').removeClass('fa-check');
    }

    // Length validation
    if (password.length >= 8) {
        strength += 1;
        $('.eight-character').addClass('text-success').find('i').removeClass('fa-exclamation-triangle').addClass('fa-check');
    } else {
        $('.eight-character').removeClass('text-success').find('i').addClass('fa-exclamation-triangle').removeClass('fa-check');
    }

    // Update strength indicator
    if (strength < 2) {
        $('#result').text('Very Weak').removeClass().addClass('text-danger');
        $('#password-strength').css('width', '10%').addClass('bg-danger');
    } else if (strength == 2) {
        $('#result').text('Weak').removeClass().addClass('text-warning');
        $('#password-strength').css('width', '60%').removeClass('bg-danger').addClass('bg-warning');
    } else if (strength == 4) {
        $('#result').text('Very Strong').removeClass().addClass('text-success');
        $('#password-strength').css('width', '100%').removeClass('bg-warning').addClass('bg-success');
    }
}


    });
</script>
<script>
    $(document).ready(function() {
        $('.selectb').each(function() {
            $(this).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
                closeOnSelect: !$(this).attr('multiple'),
            });
        });
        $(document).on('click', '.logoutbtn', function() {
            $('#logoutModal').modal('show');
        });
        $('#datepicker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: new Date()
        })
        $('#edit_dob').datepicker({
            clearBtn: true,
            autoclose: true,
            endDate: new Date()
        })
    });
</script>

<script>
    function validatePassword() {
        var password = document.getElementById("password");
        var confirmPassword = document.getElementById("confirmPassword");
        if (password.value != confirmPassword.value) {
            confirmPassword.setCustomValidity("Password does not match");
        } else {
            confirmPassword.setCustomValidity('');
        }
        password.onchange = validatePassword();
        confirmPassword.onkeyup = validatePassword();
    }
</script>


<script>
    $(document).ready(function() {
        $('#example1').dataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });
</script>