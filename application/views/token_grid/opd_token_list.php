<?php
$users_data = $this->session->userdata('auth_users');
$user_role = $users_data['users_role'];

?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo $page_title . PAGE_TITLE; ?></title>
  <meta name="viewport" content="width=1024">
  <!-- bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datatable.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>font-awesome.min.css">

  <!-- links -->
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>my_layout.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_for_all.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>withoutresponsive.css">
  <style>
    .radio-label {
      margin-right: 6px;
      font-size: 12px;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
      font-weight: normal;
      /* Ensures the font is not bold */
      display: inline-flex;
      align-items: center;
    }

    .radio-label input[type="radio"] {
      margin-right: 5px;
    }

    .border-red {
      border: 2px solid red;
    }

    .border-blue {
      border: 2px solid blue;
    }

    .border-yellow {
      border: 2px solid yellow;
    }

    .border-red,
    .border-blue,
    .border-yellow {
      padding: 10px;
      margin: 5px 0;
    }

    #additional_selection .radio-label {
      display: inline-flex;
      align-items: center;
      /* margin-right: 20px; Adds spacing between each radio button group */
    }

    #additional_selection input[type="radio"] {
      margin-right: 5px;
      /* Adjust spacing between radio button and label */

    }

    #additional_selection .col-xs-9 {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      margin-left: -38px;
    }

    span {
      font-weight: normal;
    }

    /* .btn-custom {
      display: inline-block;
      padding: 5px 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 3px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
    } */

    .btn-custom:hover {
      background-color: #0056b3;
    }

    .btn-custom:disabled,
    .btn-custom[style*="pointer-events: none;"] {
      background-color: #cccccc;
      cursor: not-allowed;
    }

    /*  */
  </style>
  <!-- js -->
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script>

  <!-- datatable js -->
  <script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datepicker.css">
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datepicker.js"></script>

  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>moment-with-locales.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datetimepicker.css">
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap-datetimepicker.js"></script>
  <script type="text/javascript">
    var save_method;
    var table;
    <?php
    if (in_array('2073', $users_data['permission']['action'])) {
      ?>
      $(document).ready(function () {
        table = $('#table').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "pageLength": '20',
          "ajax": {
            "url": "<?php echo base_url('token_no/ajax_list') ?>",
            "type": "POST",
          },
          "columnDefs": [
            {
              "targets": [0, -1], // last column
              "orderable": false, // set not orderable
            },
            {
              "targets": -1, // Hide the last column (emergency_status)
              "visible": false,
            },
            {
              "targets": 5, // Ensure the fifth column is visible
              "visible": true,
            }
          ],
          "createdRow": function (row, data, dataIndex) {
            // Access emergency_status (assuming it's the last column in the data array)
            var emergencyStatus = data[data.length - 1]; // Get the emergency_status value

            // Change the background color of the first column based on emergency_status
            var firstColumn = $('td', row).eq(0); // Get the first column cell

            if (emergencyStatus == 1) {
              firstColumn.css({
                'background-color': 'red',   // Red background for emergency_status 1
                // 'color': 'white',            // White font color
                'font-weight': 'bold'        // Bold font
              });
            } else if (emergencyStatus == 2) {
              firstColumn.css({
                'background-color': 'blue',  // Blue background for emergency_status 2
                // 'color': 'white',            // White font color
                'font-weight': 'bold'        // Bold font
              });
            } else if (emergencyStatus == 3) {
              firstColumn.css({
                'background-color': 'yellow', // Yellow background for emergency_status 3
                // 'color': 'black',             // Black font color (or default)
                'font-weight': 'bold'         // Bold font
              });
            } else {
              firstColumn.css({
                // 'background-color': 'white',  // Default white background
                // 'color': 'black',             // Default font color
                'font-weight': 'bold'         // Bold font by default
              });
            }
          },
        });

        $('.tog-col').on('click', function (e) {
          var column = table.column($(this).attr('data-column'));
          column.visible(!column.visible());
        });
      });
    <?php } ?>


    function reload_table() {
      table.ajax.reload(null, false); //reload datatable ajax 
    }

  </script>




</head>

<body>


  <div class="container-fluid">
    <?php
    $this->load->view('include/header');
    $this->load->view('include/inner_header');
    ?>
    <section class="userlist">

      <div class="userlist-box">
        <?php //if (isset($user_role) && $user_role != 4 && $user_role != 3) { ?>
        <form name="search_form" id="search_form" class="search_form " style="margin-top: 0px;">
          <div class="row">
            <div class="col-sm-4">
              <div class="row m-b-5">
                <div class="col-xs-4"><label for="from_date">From Date</label></div>
                <div class="col-xs-8">
                  <input id="from_date" name="from_date" class="start_datepicker m_input_default" type="text"
                    value="<?php echo isset($form_data['from_date']) && !empty($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d'); ?>">
                </div>

              </div>
              <div class="row m-b-5">
                <div class="col-xs-4"><label>Status</label></div>
                <div class="col-xs-8">
                  <!-- Pending (Default) -->
                  <label class="radio-label">
                    <input type="radio" name="search_type" value="1" id="search_type_default"
                      onclick="return form_submit();" checked="checked">
                    <span style="margin-top: 5px;">Pending</span>
                  </label>

                  <!-- Completed -->
                  <label class="radio-label">
                    <input type="radio" name="search_type" value="2" id="search_type_waiting"
                      onclick="return form_submit();">
                    <span style="margin-top: 5px;">Completed</span>
                  </label>

                  <!-- All -->
                  <label class="radio-label">
                    <input type="radio" name="search_type" value="" id="search_type_process"
                      onclick="return form_submit();">
                    <span style="margin-top: 5px;">All</span>
                  </label>
                </div>

              </div>


            </div> <!-- 4 -->


            <!-- ///////////////// -->
            <div class="col-sm-4">
              <div class="row m-b-5">
                <div class="col-xs-5"><label>To Date</label></div>
                <div class="col-xs-7">
                  <input name="to_date" id="to_date" class="end_datepicker m_input_default"
                    value="<?php echo isset($form_data['to_date']) && !empty($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d'); ?>"
                    type="text">
                </div>

              </div>
              <?php //if(in_array('1',$permission_section)){ ?>

            </div> <!-- 4 -->



            <!-- ///////////////// -->

            <div class="col-sm-4 d-flex justify-content-center" style="margin-left: 133px;margin-top: 0px;">
              <input value="Reset" class="btn-custom" onclick="reset_search(this.form)" type="button">



            </div> <!-- 4 -->
          </div> <!-- row -->

          <div class="row">
            <div class="col-sm-12">
              <div id="additional_selection">

                <div class="col-xs-2"><label style="margin-left: -15px;">Type</label></div>

                <div class="col-xs-10" style="margin-left: -79px;">
                  <label class="radio-label">
                    <input type="radio" name="priority_type" value="1" id="priority_red"
                      onclick="return form_submit();">
                    <span style="margin-top: 5px;">Priority</span>
                  </label>

                  <label class="radio-label">
                    <input type="radio" name="priority_type" value="2" id="fasttrack_blue"
                      onclick="return form_submit();">
                    <span style="margin-top: 5px;">Fast Track OPD Consultation</span>
                  </label>

                  <label class="radio-label">
                    <input type="radio" name="priority_type" value="3" id="priority_yellow"
                      onclick="return form_submit();">
                    <span style="margin-top: 5px;">Post-Operative</span>
                  </label>
                  <label class="radio-label">
                    <input type="radio" name="priority_type" value="4" id="priority_normal"
                      onclick="return form_submit();">
                    <span style="margin-top: 5px;">Normal</span>
                  </label>
                  <label class="radio-label">
                    <input type="radio" name="priority_type" value="" id="priority_all" onclick="return form_submit();"
                      checked>
                    <span style="margin-top: 5px;">All</span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <script>
            $(document).ready(function () {
              // Function to show/hide additional selection based on radio button selection
              $('input[name="search_type"]').change(function () {
                if ($(this).val() == "1") { // If Pending is selected
                  $('#additional_selection').show();
                } else {
                  $('#additional_selection').hide();
                }
              });
            });
          </script>
        </form>
        <?php //} ?>

        <form>
          <div class="hr-scroll">
            <table id="table" class="table table-striped table-bordered opd_booking_list " cellspacing="0" width="100%">
              <thead class="bg-theme">
                <tr>
                  <th width="20%">Token No.</th>
                  <th>Patient Reg. No. </th>
                  <th>Patient Name</th>
                  <?php //if ($branch_type == 2) { ?>
                  <!-- <th>Specialization Name</th> -->
                  <?php //} else { ?>
                  <th>Status</th>
                  <?php //} ?>
                  <th>Action </th>
                </tr>
              </thead>
            </table>
          </div>
        </form>
      </div>
      <div class="userlist-right" style="margin-top: 0px;">
        <div class="btns">
          <button class="btn-update" data-toggle="tooltip" title="Add New patient"
            onclick="window.location.href='<?php echo base_url('patient/add'); ?>'">
            <i class="fa fa-plus"></i> New
          </button>
          <!-- <button class="btn-update" id="modal_add">
            <i class="fa fa-plus"></i> New
          </button>
          <button class="btn-update" id="deleteAll" onclick="return checkboxValues();">
            <i class="fa fa-trash"></i> Delete
          </button> -->
          <a data-toggle="tooltip" title="Download list in excel" href="#" id="toen_download_excel"
            class="btn-anchor m-b-2">
            <i class="fa fa-file-excel-o"></i> Excel
          </a>
          <!-- <a data-toggle="tooltip" title="Download list in pdf" href="#" id="token_download_pdf" class="btn-anchor m-b-2">
            <i class="fa fa-file-pdf-o"></i> PDF
          </a> -->
          <!-- <button class="btn-update" onclick="reload_table()">
            <i class="fa fa-refresh"></i> Reload
          </button> -->
          <!-- <button class="btn-update"
            onclick="window.location.href='http://localhost/sarajehhis2/patient_category/archive'">
            <i class="fa fa-archive"></i> Archive
          </button> -->
          <button class="btn-update" onclick="window.location.href='http://localhost/sarajehhis2/'">
            <i class="fa fa-sign-out"></i> Exit
          </button>
        </div>
      </div>
    </section>

  </div>
  <?php
  $this->load->view('include/footer');
  ?>

  <script>

    $(document).ready(function () {
      // Function to show/hide additional selection based on radio button selection
      $('input[name="search_type"]').change(function () {
        if ($(this).val() == "1") { // If Pending is selected
          $('#additional_selection').show();
        } else {
          $('#additional_selection').hide();
        }
      });


    });

    function reset_search() {
      $('#doctor_id').val('');
      $('#specialization_id').val('');
      $('#from_date').val('');
      $('#to_date').val('');
      $.ajax({
        url: "<?php echo base_url(); ?>token_no/reset_search/",
        success: function (result) {
          $('#additional_selection').hide();
          reload_table();
        }
      });
    }



    function form_submit(vals) {
      var specialization_id = $('#specialization_id').val();
      var doctor_id = $('#doctor_id').val();
      var priority_type = $('input[name="priority_type"]:checked').val();
      var search_type = $('input[name="search_type"]:checked').val();
      var start_date = $('#from_date').val();
      var end_date = $('#to_date').val();
      $.ajax({
        url: "<?php echo base_url('token_no/advance_search/'); ?>",
        type: 'POST',
        data: { doctor_id: doctor_id, specialization_id: specialization_id, search_type: search_type, priority_type: priority_type, from_date: start_date, to_date: end_date },
        success: function (result) {
          if (vals != "1") {
            reload_table();
          }
        }
      });
    }

    form_submit(1);


    <?php
    $flash_success = $this->session->flashdata('success');
    if (isset($flash_success) && !empty($flash_success)) {
      echo 'flash_session_msg("' . $flash_success . '");';
    }
    ?>

    function confirm_booking(id) {
      var $modal = $('#load_add_modal_popup');
      $modal.load('<?php echo base_url() . 'opd/confirm_booking/' ?>' + id,
        {
        },
        function () {
          $modal.modal('show');
        });
    }


    function update_status(id, val) {
      var conf = confirm("Do you want to update?");
      if (conf == true) {
        $.ajax({
          url: "<?php echo base_url('token_status/update_token_status/'); ?>",
          type: 'POST',
          data: { token_id: id, token_status: val },
          success: function (result) {
            flash_session_msg(result);
            reload_table();
          }
        });
      }
    }

    $(document).ready(function () {
      setInterval(function () {
        reload_table();
      }, 60000);
      $('.start_datepicker').datepicker({
        format: 'yyyy-mm-dd', // Use the correct date format
        autoclose: true,
        endDate: new Date(),
      }).on("change", function (selectedDate) {
        var start_date = $('.start_datepicker').val();
        $('.end_datepicker').datepicker('setStartDate', start_date);
        form_submit();
      });

      $('.end_datepicker').datepicker({
        format: 'yyyy-mm-dd', // Use the correct date format
        autoclose: true,
      }).on("change", function (selectedDate) {
        form_submit();
      });

    });

    document.getElementById('toen_download_excel').addEventListener('click', function (e) {
      e.preventDefault();

      var fromDate = document.getElementById('from_date').value;
      var toDate = document.getElementById('to_date').value;

      var url = '<?php echo base_url("token_no/token_no_excel"); ?>';

      if (fromDate || toDate) {
        url += '?';
        if (fromDate) {
          url += 'from_date=' + encodeURIComponent(fromDate);
        }
        if (toDate) {
          url += (fromDate ? '&' : '') + 'to_date=' + encodeURIComponent(toDate);
        }
      }
      window.location.href = url;
    });
    // document.getElementById('token_download_pdf').addEventListener('click', function (e) {
    //   e.preventDefault();

    //   var fromDate = document.getElementById('start_date').value;
    //   var toDate = document.getElementById('to_date').value;

    //   var fromDateObj = new Date(fromDate);
    //   var toDateObj = new Date(toDate);

    //   var url = '<?php echo base_url("token_no/token_no_pdf"); ?>';
    //   url += '?from_date=' + encodeURIComponent(fromDate) + '&to_date=' + encodeURIComponent(toDate);
    //   window.location.href = url;
    // });

    $(document).on('click', '.book-now-btn', function () {
      const btn = $(this); // Get the clicked button
      const patientId = btn.data('id'); // Patient ID from data attribute
      const bookingUrl = btn.data('url'); // Redirect URL from data attribute

      // Disable the button and show "Booking..." text
      btn.prop('disabled', true).text('Booking...');

      // Send AJAX request to backend to handle booking
      $.ajax({
        url: '<?= base_url("token_no/book_patient"); ?>', // Call `book_patient` method
        type: 'POST',
        data: { patient_id: patientId },
        success: function (response) {
          const data = JSON.parse(response);

          if (data.status === 'success') {
            // If booking is successful, open the booking page in a new tab
            window.open(bookingUrl, '_blank');
            // btn.text('Booked');
          } else {
            // If the patient is already booked or error occurs
            // alert(data.message);
            btn.prop('disabled', false).text('Booking...');
          }
        },
        error: function () {
          // Handle AJAX error
          alert('An error occurred. Please try again.');
          btn.prop('disabled', false).text('Book Now');
        }
      });
    });


  </script>


</body>

</html>