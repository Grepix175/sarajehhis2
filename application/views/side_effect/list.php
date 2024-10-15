<?php
$users_data = $this->session->userdata('auth_users');
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $page_title . PAGE_TITLE; ?></title>
    <meta name="viewport" content="width=1024">

    <!-- Bootstrap and DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>bootstrap-datatable.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>my_layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>menu_for_all.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_CSS_PATH; ?>withoutresponsive.css">

    <!-- jQuery and Bootstrap JS -->
    <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_JS_PATH; ?>bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script src="<?php echo ROOT_JS_PATH; ?>jquery.dataTables.min.js"></script>
    <script src="<?php echo ROOT_JS_PATH; ?>dataTables.bootstrap.min.js"></script>

    <script type="text/javascript">
        var save_method;
        var table;

        <?php if (in_array('2485', $users_data['permission']['action'])): ?>
            $(document).ready(function () {
                table = $('#table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "pageLength": 20,
                    "ajax": {
                        "url": "<?php echo base_url('side_effect/ajax_list') ?>",
                        "type": "POST",
                    },
                    "columnDefs": [
                        {
                            "targets": [0, -1], // Last column
                            "orderable": false, // Set not orderable
                        },
                    ],
                });
            });
        <?php endif; ?>

        $(document).ready(function () {
            var $modal = $('#load_add_side_effect_popup');
            $('#modal_add').on('click', function () {
                $modal.load('<?php echo base_url('side_effect/add/') ?>', {}, function () {
                    $modal.modal('show');
                });
            });
        });

        function edit_side_effect(id) {
            var $modal = $('#load_add_side_effect_popup');
            $modal.load('<?php echo base_url('side_effect/edit/') ?>' + id, {}, function () {
                $modal.modal('show');
            });
        }

        function view_side_effect(id) {
            var $modal = $('#load_add_side_effect_popup');
            $modal.load('<?php echo base_url('add/view/') ?>' + id, {}, function () {
                $modal.modal('show');
            });
        }

        function reload_table() {
            table.ajax.reload(null, false); // Reload DataTable Ajax
        }

        function checkboxValues() {
            $('#table').dataTable();
            var allVals = [];
            $(':checkbox:checked').each(function () {
                allVals.push($(this).val());
            });
            all_side_effect_delete(allVals);
        }

        function all_side_effect_delete(allVals) {
            if (allVals.length > 0) {
                $('#confirm').modal({ backdrop: 'static', keyboard: false })
                    .one('click', '#delete', function () {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('side_effect/deleteall'); ?>",
                            data: { row_id: allVals },
                            success: function (result) {
                                flash_session_msg(result);
                                reload_table();
                            }
                        });
                    });
            } else {
                $('#confirm-select').modal({ backdrop: 'static', keyboard: false });
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

        <!-- Main Content Start -->
        <section class="userlist">
            <div class="userlist-box">
                <div class="row m-b-5">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-6"></div>
                            <div class="col-xs-6"></div>
                        </div>
                    </div>
                </div>
                <form>
                    <?php if (in_array('2485', $users_data['permission']['action'])): ?>
                        <table id="table" class="table table-striped table-bordered side_effect_list" cellspacing="0" width="100%">
                            <thead class="bg-theme">
                                <tr>
                                    <th width="40" align="center"> <input type="checkbox" name="selectall" class="" id="selectAll" value="">

                                    <th> Side Effect Name </th>
                                    <!-- <th> Status </th> -->
                                    <th> Created Date </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                        </table>
                    <?php endif; ?>
                </form>
            </div>

            <div class="userlist-right">
                <div class="btns">
                    <?php if (in_array('2486', $users_data['permission']['action'])): ?>
                        <button class="btn-update" id="modal_add">
                            <i class="fa fa-plus"></i> New
                        </button>
                    <?php endif; ?>
                    <?php if (in_array('2488', $users_data['permission']['action'])): ?>
                        <button class="btn-update" id="deleteAll" onclick="return checkboxValues();">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    <?php endif; ?>
                    <?php if (in_array('2486', $users_data['permission']['action'])): ?>
                        <button class="btn-update" onclick="reload_table()">
                            <i class="fa fa-refresh"></i> Reload
                        </button>
                    <?php endif; ?>
                    <button class="btn-update" onclick="window.location.href='<?php echo base_url(); ?>'">
                        <i class="fa fa-sign-out"></i> Exit
                    </button>
                </div>
            </div>
        </section>

        <?php $this->load->view('include/footer'); ?>

        <script>
            function delete_side_effect(rate_id) {
                $('#confirm').modal({ backdrop: 'static', keyboard: false })
                    .one('click', '#delete', function () {
                        $.ajax({
                            url: "<?php echo base_url('side_effect/delete/') ?>" + rate_id,
                            success: function (result) {
                                flash_session_msg(result);
                                reload_table();
                            }
                        });
                    });
            }

            $(document).ready(function () {
                $('#load_add_side_effect_popup').on('shown.bs.modal', function () {
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
                    <div class="modal-body" style="font-size:8px;">
                        *Data that have been in Archive more than 60 days will be automatically deleted.
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn-update" id="delete">Confirm</button>
                        <button type="button" data-dismiss="modal" class="btn-cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for adding/editing -->
        <div id="load_add_side_effect_popup" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg"></div>
        </div>
    </div>
</body>
</html>
