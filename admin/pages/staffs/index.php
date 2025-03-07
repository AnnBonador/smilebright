<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="modal fade" id="AddStaffModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="staff_action.php" id="staff_form" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Full Name</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="fname" class="form-control" pattern="[a-zA-Z'-'\s]*" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Birthdate</label>
                    <span class="text-danger">*</span>
                    <input type="text" autocomplete="off" name="birthday" class="form-control" id="birthday" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Address</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="address" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Gender</label>
                    <span class="text-danger">*</span>
                    <select class="custom-select" name="gender" required>
                      <option selected disabled value="">Choose</option>
                      <option>Female</option>
                      <option>Male</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Contact Number</label>
                    <span class="text-danger">*</span>
                    <input type="text" class="form-control js-phone" name="phone" pattern="^(09|\+639)\d{9}$" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Email</label>
                    <span class="text-danger">*</span>
                    <input type="email" name="email" class="form-control email_id" pattern="^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$" required>
                    <span class="email_error text-danger"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="input-group col-sm-6">
                  <input type="password" class="form-control" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Must contain at least one number and one uppercase and lowercase letter,at least one special character, and at least 8 or more characters" placeholder="Password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="fas fa-eye" id="eye"></i>
                    </div>
                  </div>
                </div>
                <div class="input-group col-sm-6">
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="fas fa-eye" id="cf-eye"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="doc_image">Upload Image</label>
                    <input type="file" name="doc_image" id="doc_image">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" id="submit_button" name="insertstaff" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="ViewStaffModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Staff Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="staff_viewing_data">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="EditStaffModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="staff_action.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <input type="hidden" name="edit_id" id="edit_id">
                  <div class="form-group">
                    <label>Full Name</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="fname" id="edit_fname" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-6 auto">
                  <div class="form-group">
                    <label>Birthdate</label>
                    <span class="text-danger">*</span>
                    <input type="text" autocomplete="off" id="edit_dob" name="birthday" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Address</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="address" id="edit_address" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-6 auto">
                  <div class="form-group">
                    <label>Gender</label>
                    <span class="text-danger">*</span>
                    <select class="custom-select" name="gender" id="edit_gender" required>
                      <option selected disabled value="">Choose</option>
                      <option>Female</option>
                      <option>Male</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Contact Number</label>
                    <span class="text-danger">*</span>
                    <input type="text" id="edit_phone" name="phone" class="form-control js-phone" pattern="^(09|\+639)\d{9}$" required>
                  </div>
                </div>
                <div class="col-sm-6 auto">
                  <div class="form-group">
                    <label>Email</label>
                    <span class="text-danger">*</span>
                    <input type="email" name="email" id="edit_email" class="form-control email_id" required>
                    <span class="email_error text-danger"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <input type="hidden" id="edit_password" name="edit_password" class="form-control" required>
                <input type="hidden" id="edit_confirmPassword" name="edit_confirmPassword" class="form-control" required>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="doc_image">Upload Image</label>
                    <input type="file" id="edit_docimage" name="edit_docimage" />
                    <input type="hidden" name="old_image" id="old_image" />
                    <div id="uploaded_image"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="updatestaff" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="DeleteStaffModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="staff_action.php" method="POST">
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
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Staff</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                <li class="breadcrumb-item active">Staff</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php include('../../message.php'); ?>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Staff List</h3>
                  <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddStaffModal">
                    <i class="fa fa-plus"></i> &nbsp;&nbsp;Add Staff</button>
                </div>
                <div class="card-body">
                  <table id="stafftbl" class="table table-borderless table-hover" style="width: 100%;">
                    <thead class="bg-light">
                      <tr>
                        <th class="text-center">Photo</th>
                        <th class="export">Staff Name</th>
                        <th class="export">Gender</th>
                        <th class="export">Contact</th>
                        <th class="export">Email</th>
                        <th class="export">Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th class="text-center"></th>
                        <th class="search">Staff Name</th>
                        <th class="search">Gender</th>
                        <th class="search">Contact</th>
                        <th class="search">Email</th>
                        <th class="search">Status</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('../../includes/scripts.php'); ?>
  <script>
    var table = $('#stafftbl').DataTable({
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
        [1, "asc"]
      ],
      "language": {
        'search': '',
        'searchPlaceholder': "Search...",
        'emptyTable': "No results found",
      },
      "ajax": {
        "url": "staff_table.php",
      },
      "columns": [{
          "data": 'image',
          render: function(data, type) {
            return '<img src="../../../upload/staff/' + data + '" class="img-thumbnail img-circle" width="50" alt="">';
          }
        },
        {
          "data": "name"
        },
        {
          "data": "gender"
        },
        {
          "data": "phone"
        },
        {
          "data": "email"
        },
        {
          "data": 'status',
          render: function(data, type, row) {
            if (data == 1) {
              return '<button data-id="' + row.id + '" data-status="' + data + '" class="btn btn-sm btn-primary activatebtn">Active</button>';
            } else {
              return '<button data-id="' + row.id + '" data-status="' + data + '" class="btn btn-sm btn-danger activatebtn">Inactive</button>';
            }
          }
        },
        {
          "data": 'id',
          render: function(data, type, row) {
            return '<button data-id="' + data + '" class="btn btn-sm btn-info editStaffbtn"><i class="fas fa-edit"></i></button> <input type="hidden" name="del_image" value="' + data + '"> <button data-id="' + data + '" class="btn btn-danger btn-sm deleteStaffbtn"><i class="far fa-trash-alt"></i></button>';
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
    $('#stafftbl tfoot th.search').each(function() {
      var title = $(this).text();
      $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
    });

    $(document).ready(function() {

      initializeDatepickerAndPreventInput('#birthday');
      initializeDatepickerAndPreventInput('#edit_dob');

      $(document).on('click', '.viewStaffbtn', function() {
        var userid = $(this).data('id');

        $.ajax({
          url: 'staff_action.php',
          type: 'post',
          data: {
            'checking_viewStafftbtn': true,
            'user_id': userid,
          },
          success: function(response) {

            $('.staff_viewing_data').html(response);
            $('#ViewStaffModal').modal('show');
          }
        });
      });

      //Staff Edit Modal
      $(document).on('click', '.editStaffbtn', function() {
        var userid = $(this).data('id');

        $.ajax({
          type: "POST",
          url: "staff_action.php",
          data: {
            'checking_editStaffbtn': true,
            'user_id': userid,
          },
          success: function(response) {
            $.each(response, function(key, value) {
              $('#edit_id').val(value['id']);
              $('#edit_fname').val(value['name']);
              $('#edit_address').val(value['address']);
              $('#edit_dob').val(value['dob']);
              $('#edit_gender').val(value['gender']);
              $('#edit_phone').val(value['phone'].substring(3));
              $('#edit_email').val(value['email']);
              $('#uploaded_image').html('<img src="../../../upload/staff/' + value['image'] + '" class="img-fluid img-thumbnail" width="120" />');
              $('#old_image').val(value['image']);
              $('#edit_password').val(value['password']);
              $('#edit_confirmPassword').val(value['password']);
            });

            $('#EditStaffModal').modal('show');
          }
        });
      });

      //Staff Delete Modal
      $(document).on('click', '.deleteStaffbtn', function() {

        var user_id = $(this).data('id');
        $('#delete_id').val(user_id);
        $('#DeleteStaffModal').modal('show');
      });

      $(document).on('click', '.activatebtn', function() {
        var userid = $(this).data('id');
        var status = $(this).data('status');
        var next_status = 'Active';
        if (status == 1) {
          next_status = 'Inactive';
        }

        if (confirm("Are you sure you want to " + next_status + " it?")) {
          $.ajax({
            type: "post",
            url: "staff_action.php",
            data: {
              'change_status': true,
              'user_id': userid,
              'status': status,
              'next_status': next_status
            },
            success: function(response) {
              location.reload();
            }
          });
        }
      });


    });
  </script>


  <?php include('../../includes/footer.php'); ?>