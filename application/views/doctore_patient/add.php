<div class="modal-dialog emp-add-add">
    <div class="overlay-loader" id="overlay-loader">
        <img src="<?php echo ROOT_IMAGES_PATH; ?>loader.gif" class="aj-loader">
    </div>
    <div class="modal-content">
        <form id="medicine_unit" class="form-inline">
            <input type="hidden" name="data_id" id="type_id" value="<?php echo $form_data['data_id']; ?>" />
            <input type="hidden" name="booking_id" id="booking_id" value="<?php echo $form_data['booking_id']; ?>" />
            <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $form_data['patient_id']; ?>" />
            <input type="hidden" name="referred_by" id="referred_by" value="<?php echo $form_data['referred_by']; ?>" />
            <div class="modal-header">
                <button type="button" class="close" data-number="1" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4><?php echo $page_title; ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 m-b1">
                        <div class="row">
                            <div class="grp">
                                <div class="col-md-4">
                                    <label>Room No</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="room_no" id="refered_id" class="m_input_default select-height">
                                        <option value="">Select Room</option>
                                        <?php
                                        if (!empty($room_no_list)) {
                                            foreach ($room_no_list as $room) {
                                                ?>
                                                <option <?php if ($form_data['room_no'] == $room->id) {
                                                    echo 'selected="selected"';
                                                } ?> value="<?php echo $room->id; ?>">
                                                    <?php echo $room->room_no; ?>
                                                </option>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                    <?php if (!empty($form_error)) {
                                        echo form_error('room_no');
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <!-- innerrow -->
                    </div> <!-- 12 -->
                </div> <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <!-- <div class="col-md-4">
                                <label>Status</label>
                            </div>
                            <div class="col-md-8">
                                <input type="radio" class="" name="status" <?php if ($form_data['status'] == 1) {
                                    echo 'checked="checked"';
                                } ?> id="status" value="1" /> Active
                                <input type="radio" class="" name="status" <?php if ($form_data['status'] == 0) {
                                    echo 'checked="checked"';
                                } ?> id="login_status" value="0" /> Inactive
                            </div> -->
                        </div> <!-- innerrow -->
                    </div> <!-- 12 -->
                </div> <!-- row -->
            </div> <!-- modal-body -->

            <div class="modal-footer">
                <input type="submit" class="btn-update" name="submit" value="Save" />
                <button type="button" class="btn-cancel" data-number="1">Close</button>
            </div>
        </form>

        <script>

            function isNumberKey(evt) {
                var charCode = (evt.which) ? evt.which : event.keyCode;
                if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                } else {
                    return true;
                }
            }

            $("#medicine_unit").on("submit", function (event) {
                event.preventDefault();
                $('#overlay-loader').show();

                var ids = $('#type_id').val();
                var path = ids && !isNaN(ids) ? 'edit/' + ids : 'add/';
                var msg = ids ? 'Room No successfully updated.' : 'Room No successfully created.';

                var formData = $(this).serialize();
                formData += '&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>';

                $.ajax({
                    url: "<?php echo base_url('doctore_patient/'); ?>" + path,
                    type: "post",
                    data: formData,
                    success: function (result) {
                        var data = JSON.parse(result)
                        if (data && data.success) {
                            $('#load_add_medicine_unit_modal_popup').modal('hide');
                            flash_session_msg(data.message);
                            // reload_table();
                            window.location.href = '<?php echo base_url('ortho_ptics'); ?>';
                        } else if (data.faield) {
                            $('#load_add_medicine_unit_modal_popup').modal('hide');
                            showAlert(
                                data.message,
                                "#ffc107", // Yellow color for a warning
                                "<?php echo base_url('doctore_patient'); ?>" // URL for redirection
                            );
                        }
                        else {
                            $("#load_add_medicine_unit_modal_popup").html(data);
                        }
                        $('#overlay-loader').hide();
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: ", error);
                        $('#overlay-loader').hide();
                    }
                });
            });

            function showAlert(message, color, redirectUrl) {
                // Create the alert box
                const alertBox = document.createElement("div");
                alertBox.style.position = "fixed";
                alertBox.style.top = "20px";
                alertBox.style.right = "20px";
                alertBox.style.padding = "15px";
                alertBox.style.borderRadius = "5px";
                alertBox.style.backgroundColor = color;
                alertBox.style.color = "white";
                alertBox.style.fontSize = "16px";
                alertBox.style.zIndex = "1000";
                alertBox.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)";
                alertBox.innerHTML = `
        <p>${message}</p>
        <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
            <button id="yesButton" style="margin-right: 10px; padding: 5px 10px; border: none; border-radius: 3px; background-color: #28a745; color: white; cursor: pointer;">Yes</button>
        </div>
    `;

                // Append the alert box to the body
                document.body.appendChild(alertBox);

                // Add event listeners for buttons
                const yesButton = document.getElementById("yesButton");
                // const noButton = document.getElementById("noButton");

                yesButton.addEventListener("click", () => {
                    window.location.href = redirectUrl;
                });
            }


            $("button[data-number=1]").click(function () {
                $('#load_add_medicine_unit_modal_popup').modal('hide');
            });

            function get_unit() {
                $.ajax({
                    url: "<?php echo base_url(); ?>medicine_unit/medicine_unit_dropdown/",
                    success: function (result) {
                        $('#unit_id').html(result);
                        $('#unit_second_id').html(result);
                    }
                });
            }

        </script>
    </div>

</div>