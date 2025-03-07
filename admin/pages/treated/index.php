<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!--Edit Modal-->
    <div class="modal fade" id="EditAppointmentModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Treated</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="treatment_action.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <label>Patient</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2 patient" name="select_patient" id="edit_patient" style="width: 100%;" required disabled>
                      <option selected disabled value="">Select Patient</option>
                      <?php
                      if (isset($_GET['id'])) {
                        echo $id = $_GET['id'];
                      }
                      $sql = "SELECT CONCAT(p.fname,' ',p.lname) as pname,t.id,t.patient_id FROM tblappointment t INNER JOIN tblpatient p ON p.id = t.patient_id WHERE t.status='Treated'";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>

                          <option value="<?php echo $row['patient_id']; ?>">
                            <?php echo $row['pname']; ?></option>
                        <?php
                        }
                      } else {
                        ?>
                        <option value="">No Record Found"</option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <input type="hidden" class="form-control" name="selectpatient" id="show_patient" readonly>
                <input type="hidden" class="form-control" name="select_dentist" id="edit_dentist" readonly>
                <input type="hidden" class="form-control" name="showvisit" id="show_visit" readonly>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Date Visit</label>
                    <span class="text-danger">*</span>
                    <input type="text" autocomplete="off" name="visit" class="form-control" id="edit_visit" readonly>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Treated</label>
                    <input type="text" name="treatment" id="edit_treatment" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Teeth No./s</label>
                    <input type="text" name="teeth" id="edit_teeth" class="form-control">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Description</label>
                    <span class="text-danger">*</span>
                    <textarea class="form-control" rows="2" name="description" id="edit_complaint" placeholder="Enter ..."></textarea>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Fees</label>
                    <input type="number" name="fees" id="edit_fees" min="0" class="form-control">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Upload File</label>
                    <input type="file" name="uploadedFile" class="form-control">
                    <input type="hidden" name="old_file" id="old_file" />
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Remarks</label>
                    <input type="text" name="remarks" id="edit_remarks" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="update_treatment" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/edit modal -->

    <!-- delete modal pop up modal -->
    <div class="modal fade" id="deletemodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Delete Treated Record</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="treatment_action.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="delete_id" id="delete_id">
              <p> Do you want to delete this data?</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="deletedata" class="btn btn-primary ">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/delete modal -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <section class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Treated</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Treated</li>
              </ol>
            </div> <!-- /.col -->
          </div> <!-- /.row -->
        </section><!-- /.container-fluid -->
      </div>
      <!--/.content-header-->


      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php
              include('../../message.php');
              ?>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Treated List</h3>
                </div>
                <div class="card-body">
                  <table id="treatment_table" class="table table-borderless table-hover" style="width:100%">
                    <thead class="bg-light">
                      <tr>
                        <th class="export">Patient</th>
                        <th class="export">Date Visit</th>
                        <th class="export">Teeth No./s</th>
                        <th class="export">Description</th>
                        <th class="export">Fees</th>
                        <th class="export">Remarks</th>
                        <th>Attachment</th>
                        <th>Download</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $sql = "SELECT CONCAT(p.lname,', ',p.fname) as pname,t.visit,t.teeth,t.treatment,t.file_name,t.complaint,t.fees,t.remarks,t.id FROM treatment t INNER JOIN tblpatient p ON t.patient_id = p.id ORDER BY t.id DESC";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>
                          <tr>
                            <td><?= $row['pname']; ?></td>
                            <td><?= $row['visit']; ?></td>
                            <td><?= $row['teeth'] ?></td>
                            <td><?= $row['complaint'] ?></td>
                            <td><?= $row['fees'] ?></td>
                            <td><?= $row['remarks'] ?></td>
                            <?php if (empty($row['file_name'])) {
                              echo '<td>N/A</td><td>N/A</td>';
                            } else {
                              echo '<td><a href="../../../upload/documents/' . $row['file_name'] . '" target="_blank">View</a></td>
<td><a href="../../../upload/documents/' . $row['file_name'] . '" download>Download</a></td>';
                            }
                            ?>
                            <td>
                              <button type="button" data-id="<?php echo $row['id']; ?>" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>
                              <button type="button" data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>
                            </td>
                          </tr>
                      <?php
                        }
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="search">Patient</th>
                        <th class="search">Date Visit</th>
                        <th class="search">Teeth No./s</th>
                        <th class="search">Description</th>
                        <th class="search">Fees</th>
                        <th class="search">Remarks</th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div> <!-- /.container -->
    </div> <!-- /.content-wrapper -->

  </div>

  <?php include('../../includes/scripts.php'); ?>
  <script>
    $(document).ready(function() {
      $('#treatment_table tfoot th.search').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
      });
      var table = $('#treatment_table').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "responsive": true,
        "ordering": false,
        "searching": true,
        "paging": true,
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
        initComplete: function() {
          // Apply the search
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
        }
      });

      $('#scheddate1').datepicker({});
      $('#scheddate2').datepicker({});

      $('.select2').select2()

      $(".patient").select2({
        placeholder: "Select Patient",
        allowClear: true
      });

      $(".dentist").select2({
        placeholder: "Select Dentist",
        allowClear: true
      });

      //edit treatment
      $(document).on('click', '.editbtn', function() {
        var treatment = $(this).data('id');

        $.ajax({
          type: 'post',
          url: "treatment_action.php",
          data: {
            'checking_editbtn': true,
            'treatment_id': treatment,
          },
          success: function(response) {
            $.each(response, function(key, value) {
              $('#edit_id').val(value['id']);
              $('#show_patient').val(value['patient_id']);
              $('#edit_patient').val(value['patient_id']);
              $('#edit_patient').select2().trigger('change');
              $('#edit_dentist').val(value['doc_id']);
              $('#show_visit').val(value['visit']);
              $('#edit_visit').val(value['visit']);
              $('#edit_teeth').val(value['teeth']);
              $('#edit_complaint').val(value['complaint']);
              $('#edit_treatment').val(value['treatment']);
              $('#edit_fees').val(value['fees']);
              $('#edit_amount').val(value['amount']);
              $('#edit_remarks').val(value['remarks']);
              $('#old_file').val(value['file_name']);
            });

            $('#EditAppointmentModal').modal('show');
          }
        });
      });

      //delete 
      $(document).on('click', '.deletebtn', function() {
        var user_id = $(this).data('id');
        $('#delete_id').val(user_id);
        $('#deletemodal').modal('show');

      });

      //load edit patient
      $('#edit_patient').on('change', function() {
        var user_id = $(this).val();
        console.log(user_id);
        $.ajax({
          type: 'post',
          url: "treatment_action.php",
          data: {
            user_id: user_id
          },
          dataType: "JSON",
          success: function(response) {
            $('#edit_dentist').val(response.doc_id);
            $('#edit_visit').val(response.visit);
          }
        })

      });

    });
  </script>

  <?php include('../../includes/footer.php'); ?>