<?php
$users_data = $this->session->userdata('auth_users');
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

  <!-- js -->
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script>

  <!-- datatable js -->
  <script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
  <script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>
  <script type="text/javascript">
    var save_method;
    var table;
    <?php if (in_array('2485', $users_data['permission']['action'])) { ?>
      $(document).ready(function () {
        table = $('#table').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "pageLength": '20',
          "ajax": {
            "url": "<?php echo base_url('vision/ajax_list') ?>",
            "type": "POST",
          },
          "columnDefs": [
            {
              "targets": [0, -1],
              "orderable": false,
            },
          ],
        });
      });
    <?php } ?>


    function edit_vision(id) {
        // Redirect to the edit page for vision with the specified ID
        window.location.href = '<?php echo base_url('vision/edit/'); ?>' + id;
    }

    function reload_table() {
      table.ajax.reload(null, false);
    }

    function checkboxValues() {
      $('#table').dataTable();
      var allVals = [];
      $(':checkbox').each(function () {
        if ($(this).prop('checked') == true) {
          allVals.push($(this).val());
        }
      });
      allbranch_delete(allVals);
    }

    function allbranch_delete(allVals) {
      if (allVals != "") {
        $('#confirm').modal({
          backdrop: 'static',
          keyboard: false
        })
          .one('click', '#delete', function (e) {
            $.ajax({
              type: "POST",
              url: "<?php echo base_url('vision/deleteall'); ?>",
              data: { row_id: allVals },
              success: function (result) {
                flash_session_msg(result);
                reload_table();
              }
            });
          });
      }
      else {
        $('#confirm-select').modal({
          backdrop: 'static',
          keyboard: false
        });
      }
    }
  </script>

</head>

<body>
  <div class="container-fluid">
    <?php
    $this->load->view('include/header');
    $this->load->view('include/inner_header');
    ?>
    <!-- ============================= Main content start here ===================================== -->
    <section class="userlist">
      <div class="userlist-box">
        <div class="row m-b-5">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-6">
                <!-- Search area or other content -->
              </div>
              <div class="col-xs-6"></div>
            </div>
          </div>
        </div>
        <form>
          <?php if (in_array('2485', $users_data['permission']['action'])) { ?>
            <!-- bootstrap data table -->
            <table id="table" class="table table-striped table-bordered patient_category_list" cellspacing="0" width="100%">
              <thead class="bg-theme">
                <tr>
                  <th width="40" align="center"> <input type="checkbox" name="selectall" class="" id="selectAll" value="">
                  </th>
                  <th> Patient Name </th>
                  <th> Vision Name </th>
                  <th> Side Effect </th>
                  <th> Created Date </th>
                  <th> Action </th>
                </tr>
              </thead>
            </table>
          <?php } ?>
        </form>
      </div>
      <div class="userlist-right">
        <div class="btns">
          <?php if (in_array('2486', $users_data['permission']['action'])) { ?>
            <!-- <button class="btn-update" id="1modal_add"
                onclick="window.location.href='<?php echo base_url('vision/add'); ?>'">
              <i class="fa fa-plus"></i> New
            </button> -->
          <?php } ?>
          <?php if (in_array('2488', $users_data['permission']['action'])) { ?>
            <button class="btn-update" id="deleteAll" onclick="return checkboxValues();">
              <i class="fa fa-trash"></i> Delete
            </button>
          <?php } ?>
          <?php if (in_array('2486', $users_data['permission']['action'])) { ?>
            <button class="btn-update" onclick="reload_table()">
              <i class="fa fa-refresh"></i> Reload
            </button>
          <?php } ?>
          <button class="btn-update" onclick="window.location.href='<?php echo base_url(); ?>'">
            <i class="fa fa-sign-out"></i> Exit
          </button>
        </div>
      </div>

    </section>

    <?php $this->load->view('include/footer'); ?>

    <script>
      function delete_vision(rate_id) {
        $('#confirm').modal({
          backdrop: 'static',
          keyboard: false
        })
          .one('click', '#delete', function (e) {
            $.ajax({
              url: "<?php echo base_url('vision/delete/'); ?>" + rate_id,
              success: function (result) {
                flash_session_msg(result);
                reload_table();
              }
            });
          });
      }
      <?php
      $flash_success = $this->session->flashdata('success');
      if (isset($flash_success) && !empty($flash_success)) {
        echo 'flash_session_msg("' . $flash_success . '");';
      }
      ?>

      $(document).ready(function () {
        $('#load_add_vision_popup').on('shown.bs.modal', function (e) {
          $('.inputFocus').focus();
        });
      });
    </script>

    <!-- Confirmation Modals -->
    <div id="confirm-select" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-theme">
            <h4>Please select at least one record.</h4>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn-cancel">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div id="confirm" class="modal fade dlt-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-theme">
            <h4>Are You Sure?</h4>
          </div>
          <div class="modal-body" style="font-size:8px;">*Data that has been archived for more than 60 days will be automatically deleted.</div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn-update" id="delete">Confirm</button>
            <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    <div id="load_add_vision_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>
  </div>
</body>

</html>
