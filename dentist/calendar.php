<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <div class="modal fade" id="AppointmentDetails">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="modalTitle" class="modal-title">Appointment Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="modalBody" class="modal-body">
            <div class="viewdetails">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Calendar</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Calendar</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">
              <div class="sticky-top mb-3">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h4 class="card-title">Upcoming Appointments</h4>
                  </div>
                  <div class="card-body">
                    <div id="external-events">
                      <div class="col">
                        <div class="info-box">
                          <div class="info-box-content">
                            <h3 class="text-center">
                              <?php
                              $userid = $_SESSION['auth_user']['user_id'];
                              $sql = "SELECT COUNT(*) AS total FROM tblappointment WHERE status IN ('Confirmed', 'Reschedule') AND doc_id='$userid'";
                              $query_run = mysqli_query($conn, $sql);

                              $row = mysqli_fetch_assoc($query_run); // Fetch the result as an associative array
                              echo $row['total']; // Display the total count
                              ?>
                            </h3>
                            <span class="info-box-text text-center">Confirmed and Rescheduled</span>

                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="info-box">
                          <div class="info-box-content">
                            <h3 class="text-center">
                              <?php
                              $userid = $_SESSION['auth_user']['user_id'];
                              $sql = "SELECT status FROM tblappointment WHERE status='Pending' AND doc_id='$userid'";
                              $query_run = mysqli_query($conn, $sql);

                              $row = mysqli_num_rows($query_run);
                              echo $row;
                              ?>
                            </h3>
                            <span class="info-box-text text-center">Pending</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card card-primary card-outline">
                <div class="card-body">
                  <div class="card-body p-0">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>

    </div>
    <?php
    $userid = $_SESSION['auth_user']['user_id'];
    $query = $conn->query("SELECT a.*, 
                              CONCAT(p.fname, ' ', p.lname) AS pname, 
                              CONCAT(a.schedule, ' ', a.starttime) AS timestamp, 
                              CONCAT(a.schedule, ' ', a.endtime) AS enddate 
                       FROM tblappointment a 
                       INNER JOIN tblpatient p 
                       WHERE p.id = a.patient_id 
                       AND a.status IN ('Confirmed', 'Reschedule') 
                       AND a.doc_id = '$userid'");

    $sched_arr = json_encode($query->fetch_all(MYSQLI_ASSOC));
    ?>
    <?php include('includes/scripts.php'); ?>
    <script>
      $(function() {

        $('.userdata').click(function(e) {
          var clientTag = document.getElementById("client-label");
          var requiredId = clientTag.getAttribute('data-id');
          window.location.href = 'edit-appointment.php?id=' + requiredId;

        });

        function ini_events(ele) {
          ele.each(function() {

            var eventObject = {
              title: $.trim($(this).text())
            }

            $(this).data('eventObject', eventObject)

            $(this).draggable({
              zIndex: 1070,
              revert: true,
              revertDuration: 0
            })

          })
        }

        ini_events($('#external-events div.external-event'))

        var date = new Date()
        var d = date.getDate(),
          m = date.getMonth(),
          y = date.getFullYear()
        var scheds = $.parseJSON('<?php echo ($sched_arr) ?>');

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');

        new Draggable(containerEl, {
          itemSelector: '.external-event',
          eventData: function(eventEl) {
            return {
              title: eventEl.innerText,
              backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
              borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
              textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
            };
          }
        });

        var calendar = new FullCalendar.Calendar(calendarEl, {
          themeSystem: 'bootstrap',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
          },

          events: function(event, successCallback) {
            var events = []
            Object.keys(scheds).map(k => {
              events.push({
                id: scheds[k].id,
                title: scheds[k].pname,
                start: moment(scheds[k].timestamp).format('YYYY-MM-DD[T]HH:mm'),
                end: moment(scheds[k].enddate).format('hh:mm'),
                backgroundColor: scheds[k].bgcolor,
                borderColor: scheds[k].bgcolor
              });
            })
            successCallback(events)

          },
          eventClick: function(info) {
            var userid = info.event.id;

            $.ajax({
              type: "post",
              url: "calendar_action.php",
              data: {
                userid: userid
              },
              success: function(response) {
                $('.viewdetails').html(response);
                $("#AppointmentDetails").modal();
              }
            });
          },



          navLinks: true,
          businessHours: [{
            daysOfWeek: [1, 2, 3, 4, 5, 6],
            startTime: '09:00',
            endTime: '18:00'
          }], // display business hours
          editable: true,
          selectable: true,
          droppable: false, //
        });

        calendar.render();

        var currColor = '#3c8dbc' //Red by default
        // Color chooser button
        $('#color-chooser > li > a').click(function(e) {
          e.preventDefault()
          // Save color
          currColor = $(this).css('color')
          // Add color effect to button
          $('#add-new-event').css({
            'background-color': currColor,
            'border-color': currColor
          })
        })
        $('#add-new-event').click(function(e) {
          e.preventDefault()
          // Get value and make sure it is not null
          var val = $('#new-event').val()
          if (val.length == 0) {
            return
          }

          // Create events
          var event = $('<div />')
          event.css({
            'background-color': currColor,
            'border-color': currColor,
            'color': '#fff'
          }).addClass('external-event')
          event.text(val)
          $('#external-events').prepend(event)

          // Add draggable funtionality
          ini_events(event)

          // Remove event from text input
          $('#new-event').val('')
        })
      })
    </script>

    <?php include('includes/footer.php'); ?>