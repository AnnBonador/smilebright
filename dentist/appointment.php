<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <style>
    .select2-selection__choice__remove {
      display: contents;
      position: relative;
      padding-right: 5px !important;
    }
  </style>
  <div class="wrapper">
    <div class="modal fade" id="EditAppointmentModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Walk-In Appointment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="appointment_action.php" id="edit-appointment" method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <input type="hidden" value="<?php echo $_SESSION['auth_user']['user_id']; ?>" id="user_id">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <input type="hidden" name="select_patient" id="edit_patient_id">
                    <input type="hidden" name="select_dentist" id="edit_dentist_id">
                    <input type="hidden" id="edit_schedule">
                    <label>Select Patient</label>
                    <span class="text-danger">*</span>
                    <select class="select2 patient" name="" id="edit_patient" style="width:100%;" required disabled>
                      <?php
                      if (isset($_GET['id'])) {
                        echo $id = $_GET['id'];
                      }
                      $sql = "SELECT * FROM tblpatient";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>

                          <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['fname'] . ' ' . $row['lname']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="scheddateEdit">Appointment Date</label>
                    <span class="text-danger">*</span>
                    <input type="text" id="scheddateEdit" name="scheddate" class="form-control" autocomplete="off" readonly required>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <div id="time-slotsEdit" class="row">
                      <!-- Dynamic time slots will appear here -->
                    </div>
                    <input type="hidden" id="selected-time-slotEdit" name="selected_time_slot">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Service</label>
                    <span class="text-danger">*</span>
                    <select multiple="multiple" name="service[]" id="edit_reason" style="width: 100%;" required>
                      <?php
                      $sql = "SELECT * FROM procedures ORDER BY procedures ASC";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>
                          <option value="<?php echo $row['procedures']; ?>">
                            <?php echo $row['procedures']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Appointment Status</label>
                    <span class="text-danger">*</span>
                    <select class="form-control custom-select" name="status" id="edit_status" id="show-checkbox" required>
                      <option value="Confirmed">Confirmed</option>
                      <option value="Cancelled">Cancelled</option>
                      <option value="Reschedule">Reschedule</option>
                      <option value="Treated">Treated</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="color">Color</label>
                    <select name="color" class="form-control custom-select" id="edit_color">
                      <option style="color:#f39c12;" value="#f39c12"> Yellow</option>
                      <option style="color:#00c0ef;" value="#00c0ef"> Aqua</option>
                      <option style="color:#0073b7;" value="#0073b7"> Blue</option>
                      <option style="color:#00a65a;" value="#00a65a"> Green</option>
                      <option style="color:#FF8C00;" value="#FF8C00"> Orange</option>
                      <option style="color:#3c8dbc;" value="#3c8dbc"> Light Blue</option>
                      <option style="color:#f56954;" value="#f56954"> Red</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input ck" type="checkbox" id="editFollowUp" name="follow_up">
                      <label for="editFollowUp" class="custom-control-label">Yes, schedule a follow-up</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="custom-control custom-checkbox" id="show-email2">
                    <input class="custom-control-input ck" type="checkbox" id="customCheckbox3" name="send-email" disabled>
                    <label for="customCheckbox3" class="custom-control-label">Send Email</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="update_appointment" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="content-wrapper">
      <div class="content-header">
        <section class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Walk-In Appointment</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Walk-In Appointment</li>
              </ol>
            </div>
          </div>
        </section>
      </div>

      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php
              include('message.php');
              ?>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Walk-in Appointment List</h3>
                </div>
                <div class="col-md-12 mt-4">
                  <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="all-tab" data-toggle="tab" data-target="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="confirmed-tab" data-toggle="tab" data-target="#confirmed" role="tab" aria-controls="confirmed" aria-selected="false">Confirmed</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="treated-tab" data-toggle="tab" data-target="#treated" role="tab" aria-controls="treated-tab" aria-selected="false">Treated</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cancelled-tab" data-toggle="tab" data-target="#cancelled" role="tab" aria-controls="cancelled-tab" aria-selected="false">Cancelled</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="reschedule-tab" data-toggle="tab" data-target="#reschedule" aria-controls="reschedule-tab" aria-selected="false">Reschedule</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div id="confirmed" class="tab-pane fade" role="tabpanel" aria-labelledby="confirmed-tab">
                      <table id="confirmedtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Time</th>
                            <th class="export">Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="treated" class="tab-pane fade" role="tabpanel" aria-labelledby="treated-tab">
                      <table id="treatedtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Time</th>
                            <th class="export">Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="cancelled" class="tab-pane fade" role="tabpanel" aria-labelledby="cancelled-tab">
                      <table id="cancelledtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Time</th>
                            <th class="export">Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="reschedule" class="tab-pane fade" role="tabpanel" aria-labelledby="reschedule-tab">
                      <table id="rescheduletbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Time</th>
                            <th class="export">Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="all" class="tab-pane fade show active" role="tabpanel" aria-labelledby="reschedule-tab">
                      <table id="alltbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Patient</th>
                            <th class="export">Date Submitted</th>
                            <th class="export">Appointment Date</th>
                            <th class="export">Time</th>
                            <th class="export">Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
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
  <?php include('includes/scripts.php'); ?>
  <script>
    $(document).ready(function() {
      var table1 = $('#confirmedtbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
        "buttons": [{
            extend: 'copyHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-clipboard"></i>  Copy',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'csvHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-csv"></i>  CSV',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-excel"></i>  Excel',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'pdfHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-print"></i>  Print',
            exportOptions: {
              columns: '.export'
            }
          }
        ],
        "order": [
          [1, "desc"]
        ],
        "language": {
          'search': '',
          'searchPlaceholder': "Search...",
          'emptyTable': "No results found",
        },
        "ajax": {
          "url": "appointment_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Confirmed'
          }
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              var options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
              };
              var date = new Date(data);
              return date.toLocaleDateString("en-US", options)
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              var options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
              };
              var date = new Date(data);
              return date.toLocaleDateString("en-US", options)
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Confirmed') {
                return '<span class="badge badge-success">Confirmed</span>';
              } else if (data == 'Pending') {
                return '<span class="badge badge-warning">Pending</span>';
              } else if (data == 'Treated') {
                return '<span class="badge badge-primary">Treated</span>';
              } else if (data == 'Reschedule') {
                return '<span class="badge badge-secondary">Reschedule</span>';
              } else {
                return '<span class="badge badge-danger">Cancelled</span>';
              }
            }
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
        "initComplete": function() {
          this.api().columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change clear', function() {
              if (that.search() !== this.value) {
                that
                  .search(this.value)
                  .draw();
              }
            });
          });
        },
      });
      $('#confirmedtbl tfoot th.search').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
      });
    });

    $(document).ready(function() {

      var table2 = $('#treatedtbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
        "buttons": [{
            extend: 'copyHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-clipboard"></i>  Copy',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'csvHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-csv"></i>  CSV',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-excel"></i>  Excel',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'pdfHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-print"></i>  Print',
            exportOptions: {
              columns: '.export'
            }
          }
        ],
        "order": [
          [1, "desc"]
        ],
        "language": {
          'search': '',
          'searchPlaceholder': "Search...",
          'emptyTable': "No results found",
        },
        "ajax": {
          "url": "appointment_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Treated'
          }
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Treated') {
                return '<span class="badge badge-primary">Treated</span>';
              }
            }
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });

      var table3 = $('#cancelledtbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
        "buttons": [{
            extend: 'copyHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-clipboard"></i>  Copy',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'csvHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-csv"></i>  CSV',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-excel"></i>  Excel',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'pdfHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-print"></i>  Print',
            exportOptions: {
              columns: '.export'
            }
          }
        ],
        "order": [
          [1, "desc"]
        ],
        "language": {
          'search': '',
          'searchPlaceholder': "Search...",
          'emptyTable': "No results found",
        },
        "ajax": {
          "url": "appointment_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Cancelled'
          }
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Cancelled') {
                return '<span class="badge badge-danger">Cancelled</span>';
              }
            }
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });

      var table4 = $('#rescheduletbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
        "buttons": [{
            extend: 'copyHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-clipboard"></i>  Copy',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'csvHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-csv"></i>  CSV',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-excel"></i>  Excel',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'pdfHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-print"></i>  Print',
            exportOptions: {
              columns: '.export'
            }
          }
        ],
        "order": [
          [1, "desc"]
        ],
        "language": {
          'search': '',
          'searchPlaceholder': "Search...",
          'emptyTable': "No results found",
        },
        "ajax": {
          "url": "appointment_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Reschedule'
          }
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Reschedule') {
                return '<span class="badge badge-secondary">Reschedule</span>';
              }
            }
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });
      var table5 = $('#alltbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
        "buttons": [{
            extend: 'copyHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-clipboard"></i>  Copy',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'csvHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-csv"></i>  CSV',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-excel"></i>  Excel',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'pdfHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-print"></i>  Print',
            exportOptions: {
              columns: '.export'
            }
          }
        ],
        "order": [
          [1, "desc"]
        ],
        "language": {
          'search': '',
          'searchPlaceholder': "Search...",
          'emptyTable': "No results found",
        },
        "ajax": {
          "url": "appointment_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": '%e%'
          }
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Confirmed') {
                return '<span class="badge badge-success">Confirmed</span>';
              } else if (data == 'Pending') {
                return '<span class="badge badge-warning">Pending</span>';
              } else if (data == 'Treated') {
                return '<span class="badge badge-primary">Treated</span>';
              } else if (data == 'Reschedule') {
                return '<span class="badge badge-secondary">Reschedule</span>';
              } else {
                return '<span class="badge badge-danger">Cancelled</span>';
              }
            }
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });

      $('.nav-tabs a').on('shown.bs.tab', function(event) {
        var tabID = $(event.target).attr('data-target');
        if (tabID === '#confirmed') {
          table1.columns.adjust().responsive.recalc();
        }
        if (tabID === '#treated') {
          table2.columns.adjust().responsive.recalc();
        }
        if (tabID === '#cancelled') {
          table3.columns.adjust().responsive.recalc();
        }
        if (tabID === '#reschedule') {
          table4.columns.adjust().responsive.recalc();
        }
        if (tabID === '#all') {
          table5.columns.adjust().responsive.recalc();
        }
      });

      $(document).ready(function() {

        $('#edit_stime').datetimepicker({
          format: 'LT'
        });
        $('#edit_etime').datetimepicker({
          format: 'LT'
        });

        $('#edit_sched').datepicker({
          todayHighlight: true,
          clearBtn: true,
          autoclose: true,
          startDate: new Date()
        });

        $('.select2').select2()

        $("#edit_dentist").on("change", function() {
          var selectedDentistId = $("#edit_dentist").val();
          var patientID = $("#edit_patient").val();
          $("#edit_sched").empty().trigger('change');
          $("#edit_schedTime").empty().trigger('change');
          $('#edit_sched').select2({
            allowClear: true,
            placeholder: "Available Date",
            ajax: {
              url: 'appointment_action.php',
              type: 'GET',
              dataType: 'json',
              delay: 250,
              data: function(params) {
                return {
                  doctorIdDate: selectedDentistId,
                  patientId: patientID
                };
              },
              processResults: function(response) {
                return {
                  results: response
                };
              },
              cache: true,
            }
          });
        });
        $("#edit_sched").on("change", function() {
          var selectedSchedId = $("#edit_sched").val();
          $("#edit_schedTime").empty().trigger('change');
          $('#edit_schedTime').select2({
            allowClear: true,
            placeholder: "Available Date",
            ajax: {
              url: 'appointment_action.php',
              type: 'POST',
              dataType: 'json',
              delay: 250,
              data: function(params) {
                return {
                  selectedDateId: selectedSchedId,
                };
              },
              processResults: function(response) {
                return {
                  results: response
                };
              },
              cache: true,
            }
          });
        });

        initializeSelect2(".patient", "Select Patient");
        initializeSelect2("#edit_reason", "Select Service");

        initializeCalendarDate("#scheddateEdit");

        handleTimeSlotClick(".edit-time-slot", "#selected-time-slotEdit", "slot");

        validateFormSubmission("#edit-appointment", "#selected-time-slotEdit");

        const colorBox = document.getElementById('edit_color');

        colorBox.addEventListener('change', (event) => {
          const color = event.target.value;
          event.target.style.color = color;
        }, false);


        $("#edit_status").on('change', function() {
          var val = $(this).val();
          if (this.value == "Confirmed") {
            $('.ck').prop("disabled", false);
          } else {
            $('.ck').prop("disabled", true);
            $('#customCheckbox3').prop("checked", false);
          }
        });



        $(document).on('click', '.editbtn', function() {
          var schedid = $(this).data('id');
          $("#edit_sched").empty().trigger('change')
          $("#edit_schedTime").empty().trigger('change')

          $.ajax({
            type: 'post',
            url: "appointment_action.php",
            data: {
              'checking_editbtn': true,
              'app_id': schedid,
            },
            success: function(response) {

              var selectedDoctorId = response["doc_id"];

              $('#edit_id').val(response['id']);
              $('#edit_patient_id').val(response['patient_id']);
              $('#edit_patient').val(response['patient_id']).trigger('change');
              $('#edit_dentist_id').val(response['doc_id']);
              $("#scheddateEdit").val(response["schedule"]);
              $("#selected-time-slotEdit").val(response["starttime"]);
              loadAvailableTimeSlotsForEdit(response["doc_id"], response["schedule"]);

              var services = response['reason'].split(",");
              $('#edit_reason').val(services).trigger('change');
              $('#edit_status').val(response['status']);
              $('#edit_color').val(response['bgcolor']);
              $("#editFollowUp").val(response["follow_up"]);

              $("#editFollowUp").prop("checked", response["follow_up"] == 1);

              $.ajax({
                url: "appointment_action.php",
                type: "GET",
                data: {
                  dentist: true,
                  doctor_id: selectedDoctorId,
                },
                dataType: "json",
                success: function(doctor) {
                  // Check if there is an error in the response
                  if (doctor.error) {
                    // Display a custom error message
                    const errorMessage =
                      "Sorry, the schedule for the selected doctor is not available. Please choose another doctor or try again later.";
                    $("#time-slotsEdit").html(`<div class="col-12 text-danger">${errorMessage}</div>`);
                    return; // Exit the function to prevent further execution
                  }

                  const availableDays = doctor.available_days;
                  const disabledDays = [0, 1, 2, 3, 4, 5, 6].filter(
                    (day) => !availableDays.includes(["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][day])
                  );

                  $("#scheddateEdit").datepicker("setDaysOfWeekDisabled", disabledDays);
                },
                error: function(error) {
                  console.log("Error fetching doctor schedule:", error);
                },
              });

              $('#EditAppointmentModal').modal('show');
            }
          });
        });

        $('#edit_status').on('change', function() {
          var treated = $(this).val();
          var schedDate = $("#edit_schedule").val();
          var appDate = Date.parse(schedDate);
          var todayDate = new Date().getTime();;
          if (treated == "Treated") {
            if (todayDate < appDate) {
              if (confirm('The appointment date is not today, are you sure you want to set it to Treated?')) {} else {
                this.selectedIndex = 0;
              }
            }
            return false;
          }
        });
      });
    });

    function loadAvailableTimeSlotsForEdit(doctorId, selectedDate) {
      $.ajax({
        url: "appointment_action.php", // Endpoint to fetch available time slots
        type: "GET",
        data: {
          timeslots: true,
          doctor_id: doctorId,
          date: selectedDate,
        },
        dataType: "json",
        success: function(response) {
          if (response.available_time_slots && response.available_time_slots.length > 0) {
            let slotsHtml = '<div class="col-12"><h5>Available Time Slots:</h5></div>';
            response.available_time_slots.forEach(function(slot) {
              slotsHtml += `<button type="button" class="col-md-2 btn btn-outline-primary edit-time-slot" data-slot="${slot}">${slot}</button>`;
            });
            $("#time-slotsEdit").html(slotsHtml);
          } else {
            const noSlotsMessage = "Sorry, no available time slots for the selected doctor. Please try again later.";
            $("#time-slotsEdit").html(`<div class="col-12 text-danger">${noSlotsMessage}</div>`);
          }
        },
        error: function(error) {
          console.log("Error fetching time slots:", error);
        },
      });
    }
  </script>
  <?php include('includes/footer.php'); ?>