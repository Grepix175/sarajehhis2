<?php error_reporting(0); ?>
<style>
	input[type=text], .form-control{height:25px;background:#f8f8f8;font-size:13px;padding:2px;}
	input[type=text].w-40px{width:40px !important;}
	.row hr {margin:3px 0 10px;}
	.row input[type=range]{margin-top:10px;}
	table.table thead {background:#d9edf7 !important;color:black !important;}
	table.table thead >tr> th, table.table-bordered, table.table-bordered td {border-color:#aad4e8 !important;font-size:12px;}
	.row .well {min-height:auto;margin-bottom:0px;}
	.row textarea.form-control {height:75px;width:100%;}
	.input-group-addon {border-radius:0px;border-color:#aaa;} 
	.grp-full>.grp>.box-right>input[type="text"] {
            /* width: 233px; */
        }
        .box-right {
            width: 70%; /* Input width (70% of the 50% container) */
        }
        
        .grp {
            width: 50%;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .grp label {
            width: 20%; /* Adjust this value according to your preference */
            font-weight: bold;
        }

        .box-right {
            flex-grow: 1;
        }

        .input-height {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .star {
            color: red;
        }
        #patient_form .pat-col>.grp {
            width: 80%;
        }

        #patient_form input[type="text"],
        #patient_form input[type="password"],
        #patient_form input[type="date"],
        #patient_form select,
        #patient_form .pat-col>.grp>.box-right {
            width: 300px;
        }

        #patient_form #mobile_no {
            width: 246px;
        }

        #patient_form .pat-col>.grp-full>.grp>.box-right>input[type="text"] {
            width: 233px;
        }

        #patient_form .pat-col>.grp-full>.grp>.box-right {
            width: 300px;
        }

        #patient_form .pat-col {
            width: 50%;
        }

        #patient_form .country_code {
            width: 50px !important;
        }

        #patient_form #simulation_id,
        #patient_form #relation_simulation_id {
            width: 11%;
        }

        #patient_form #age_y,
        #patient_form #age_m,
        #patient_form #age_d,
        #patient_form #age_h {
            width: 29px;
        }

        #patient_form #patient_category {
            /* width: 480px; */
        }
        .footer {
            position: absolute; /* Fixed position at the bottom */
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px; /* Smaller font size for footer text */
        }

        .footer hr {
            border: none;
            border-top: 1px solid #000; /* Line style */
            margin: 0; /* Remove margins */
        }

		.patient-info-table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            margin-bottom: 10px;

        }

        .patient-info-table td {
            padding: 5px;
            vertical-align: top;
            text-align: left;
        }

        .input-height {
            height: 45px !important;
            padding: 8px;
            font-size: 14px;
            width: 434px !important;
        }

        .select-height {
            height: 45px !important;
            padding: 2px;
            font-size: 14px;
            width: 435px;

        }

        /* Target the main Select2 container */
        .select2-container .select2-selection--single {
            height: 40px !important;
            /* width: 380px !important; */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
            font-size: 14px;
            /* width: 380px !important; */
        }

        /* Adjust the dropdown arrow (caret) */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            /* width: 380px !important; */
        }

        .grp-full .border-top {
            /* border-top: 1px solid #000; */
            /* Adjust border color */
        }

        .row.mb-4 {
            margin-bottom: 0px;
            /* Space between the row and the next element */
        }
        .grp-full{
            float: left;
            width: 100%;
            margin-bottom: 5px;
        }
</style>

<p style="text-align: center; font-size: 7px;"><strong>Sara Eye HOSPITALS</strong></p>

	<?php
        // Loop through the contact lens data
        $age_y = $booking_data['age_y']??'';
        $age_m = $booking_data['age_m']??'';
        $age_d = $booking_data['age_d']??'';

        $age = "";
        if ($age_y > 0) {
            $year = 'Years';
            if ($age_y == 1) {
                $year = 'Year';
            }
            $age .= $age_y . " " . $year;
        }
        if ($age_m > 0) {
            $month = 'Months';
            if ($age_m == 1) {
                $month = 'Month';
            }
            $age .= ", " . $age_m . " " . $month;
        }
        if ($age_d > 0) {
            $day = 'Days';
            if ($age_d == 1) {
                $day = 'Day';
            }
            $age .= ", " . $age_d . " " . $day;
        }
    ?>
	<table class="patient-info-table" style=" margin-top: 20px; ">
		<tr>
			<td class="left-column">
				<table>
					<tr>
						<td class="info-label">Patient</td>
						<td class="info-content">: <?php echo $booking_data['patient_name']??''; ?></td>
					</tr>
					<tr>
						<td class="info-label">Patient Reg. No</td>
						<td class="info-content">: <?php echo $booking_data['patient_code']??''; ?></td>
					</tr>
					<tr>
						<td class="info-label">Token No</td>
						<td class="info-content">: <?php echo $booking_data['token_no']??''; ?></td>
					</tr>
					<tr>
						<td class="info-label">OPD No</td>
						<td class="info-content">: <?php echo $booking_data['booking_code']??''; ?></td>
					</tr>
				</table>
			</td>
			<td class="right-column">
				<table>
					<tr>
						<td class="info-label">Mobile no.</td>
						<td class="info-content">: <?php echo $booking_data['mobile_no']??''; ?></td>
					</tr>
					<tr>
						<td class="info-label">Age</td>
						<td class="info-content">: <?php echo $age??''; ?></td>
					</tr>
					<tr>
						<td class="info-label">Gender</td>
						<td class="info-content">: <?php echo ($booking_data['gender'] == '0') ? 'Female' : 'Male'; ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


<section class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12 text-right btn_edit"><a href="javascript:void(0)" class="btn_fill" onclick="$('.auto_ref').toggle();">Edit</a><hr></div>
			<div class="col-md-2">
				<!-- <div class="label_name">AUTO REFRACTION (ARx) <i onclick="refraction_ar_ltr();" title="Copy Left to Right" class="fa fa-arrow-right"></i></div> -->
				<div class="label_name">AUTO REFRACTION (DRY) <i onclick="refraction_ar_ltr();" title="Copy Left to Right" class="fa fa-arrow-right"></i></div>
				<button type="button" class="btn_fill auto_ref d-none" title="Fill AUTO REFRACTION" onclick="return open_modals_2('refraction_ar');">Fill <i class="fa fa-arrow-right"></i> </button> 	
				
			</div>
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="25%"></th>
							<th width="25%">Sph</th>
							<th width="25%">Cyl</th>
							<th width="25%">Axis</th>
						</tr>
					</thead>
					<tbody> 
						<tr> 
							<!-- <td style="text-align:left;">Dry</td> -->
							<td style="text-align:left;">OD</td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_dry_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_dry_sph'];?>" name="refraction_ar_l_dry_sph" id="refraction_ar_l_dry_sph" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_dry_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_dry_cyl'];?>" name="refraction_ar_l_dry_cyl" id="refraction_ar_l_dry_cyl" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_dry_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_dry_axis'];?>" name="refraction_ar_l_dry_axis" id="refraction_ar_l_dry_axis" class="w-50px auto_ref d-none"></td>
						</tr>
						<tr>
							<!-- <td style="text-align:left;">Dilated</td> -->
							<td style="text-align:left;">OS</td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_dd_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_dd_sph'];?>" name="refraction_ar_l_dd_sph" id="refraction_ar_l_dd_sph" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_dd_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_dd_cyl'];?>" name="refraction_ar_l_dd_cyl" id="refraction_ar_l_dd_cyl" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_dd_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_dd_axis'];?>" name="refraction_ar_l_dd_axis" id="refraction_ar_l_dd_axis" class="w-50px auto_ref d-none"></td>
						</tr>
						<!-- <tr>
							<td style="text-align:left;"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_b1_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_b1_sph'];?>" name="refraction_ar_l_b1_sph" id="refraction_ar_l_b1_sph" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_b1_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_b1_cyl'];?>" name="refraction_ar_l_b1_cyl" id="refraction_ar_l_b1_cyl" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_b1_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_b1_axis'];?>" name="refraction_ar_l_b1_axis" id="refraction_ar_l_b1_axis" class="w-50px auto_ref d-none"></td>
						</tr> -->
						<!-- <tr>
							<td style="text-align:left;"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_b2_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_b2_sph'];?>" name="refraction_ar_l_b2_sph" id="refraction_ar_l_b2_sph" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_b2_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_b2_cyl'];?>" name="refraction_ar_l_b2_cyl" id="refraction_ar_l_b2_cyl" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_l_b2_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_l_b2_axis'];?>" name="refraction_ar_l_b2_axis" id="refraction_ar_l_b2_axis" class="w-50px auto_ref d-none"></td>
						</tr> -->
					</tbody>
				</table> 
			</div>
			<!-- <div class="col-md-2">
				<div class="label_name">AUTO REFRACTION (ARx) <i onclick="refraction_ar_rtl();" title="Copy Right to Left" class="fa fa-arrow-left"></i> </div>
			</div>
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="25%"></th>
							<th width="25%">Sph</th>
							<th width="25%">Cyl</th>
							<th width="25%">Axis</th>
						</tr>
					</thead>
					<tbody>
						<tr> 
							<td style="text-align:left;">Dry</td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_dry_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_dry_sph'];?>" name="refraction_ar_r_dry_sph" id="refraction_ar_r_dry_sph" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_dry_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_dry_cyl'];?>" name="refraction_ar_r_dry_cyl" id="refraction_ar_r_dry_cyl" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_dry_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_dry_axis'];?>" name="refraction_ar_r_dry_axis" id="refraction_ar_r_dry_axis" class="w-50px auto_ref d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Dilated</td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_dd_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_dd_sph'];?>" name="refraction_ar_r_dd_sph" id="refraction_ar_r_dd_sph" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_dd_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_dd_cyl'];?>" name="refraction_ar_r_dd_cyl" id="refraction_ar_r_dd_cyl" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_dd_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_dd_axis'];?>" name="refraction_ar_r_dd_axis" id="refraction_ar_r_dd_axis" class="w-50px auto_ref d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_b1_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_b1_sph'];?>" name="refraction_ar_r_b1_sph" id="refraction_ar_r_b1_sph" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_b1_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_b1_cyl'];?>" name="refraction_ar_r_b1_cyl" id="refraction_ar_r_b1_cyl" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_b1_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_b1_axis'];?>" name="refraction_ar_r_b1_axis" id="refraction_ar_r_b1_axis" class="w-50px auto_ref d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_b2_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_b2_sph'];?>" name="refraction_ar_r_b2_sph" id="refraction_ar_r_b2_sph" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_b2_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_b2_cyl'];?>" name="refraction_ar_r_b2_cyl" id="refraction_ar_r_b2_cyl" class="w-50px auto_ref d-none"></td>
							<td><span class="auto_ref"><?php echo $refrtsn_auto_ref['refraction_ar_r_b2_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref['refraction_ar_r_b2_axis'];?>" name="refraction_ar_r_b2_axis" id="refraction_ar_r_b2_axis" class="w-50px auto_ref d-none"></td>
						</tr>
					</tbody>
				</table>
			</div> -->
		</div>
	</div>
</section>

<section class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12 text-right btn_edit"><a href="javascript:void(0)" class="btn_fill" onclick="$('.auto_fer2').toggle();">Edit</a><hr></div>
			<div class="col-md-2">
				<div class="label_name">AUTO REFRACTION (PLATED) <i onclick="refraction_ar_ltr_plated();" title="Copy Left to Right" class="fa fa-arrow-right"></i></div>
				<!-- <button type="button" class="btn_fill auto_fer2 d-none" title="Fill AUTO REFRACTION" onclick="return open_modals_3('refraction_ar');">Fill <i class="fa fa-arrow-right"></i> </button> 	 -->
				
			</div>
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="25%"></th>
							<th width="25%">Sph</th>
							<th width="25%">Cyl</th>
							<th width="25%">Axis</th>
						</tr>
					</thead>
					<tbody> 
						<tr> 
							<!-- <td style="text-align:left;">Dry</td> -->
							<td style="text-align:left;">OD</td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_sph_plated'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_sph_plated'];?>" name="refraction_ar_l_dry_sph_plated" id="refraction_ar_l_dry_sph_plated" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_cyl_plated'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_cyl_plated'];?>" name="refraction_ar_l_dry_cyl_plated" id="refraction_ar_l_dry_cyl_plated" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_axis_plated'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_axis_plated'];?>" name="refraction_ar_l_dry_axis_plated" id="refraction_ar_l_dry_axis_plated" class="w-50px auto_fer2 d-none"></td>
						</tr>
						<tr>
							<!-- <td style="text-align:left;">Dilated</td> -->
							<td style="text-align:left;">OS</td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_sph_plated'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_sph_plated'];?>" name="refraction_ar_l_dd_sph_plated" id="refraction_ar_l_dd_sph_plated" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_cyl_plated'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_cyl_plated'];?>" name="refraction_ar_l_dd_cyl_plated" id="refraction_ar_l_dd_cyl_plated" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_axis_plated'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_axis_plated'];?>" name="refraction_ar_l_dd_axis_plated" id="refraction_ar_l_dd_axis_plated" class="w-50px auto_fer2 d-none"></td>
						</tr>
						<!-- <tr>
							<td style="text-align:left;"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b1_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b1_sph'];?>" name="refraction_ar_l_b1_sph" id="refraction_ar_l_b1_sph" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b1_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b1_cyl'];?>" name="refraction_ar_l_b1_cyl" id="refraction_ar_l_b1_cyl" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b1_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b1_axis'];?>" name="refraction_ar_l_b1_axis" id="refraction_ar_l_b1_axis" class="w-50px auto_fer2 d-none"></td>
						</tr> -->
						<!-- <tr>
							<td style="text-align:left;"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b2_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b2_sph'];?>" name="refraction_ar_l_b2_sph" id="refraction_ar_l_b2_sph" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b2_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b2_cyl'];?>" name="refraction_ar_l_b2_cyl" id="refraction_ar_l_b2_cyl" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b2_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_b2_axis'];?>" name="refraction_ar_l_b2_axis" id="refraction_ar_l_b2_axis" class="w-50px auto_fer2 d-none"></td>
						</tr> -->
					</tbody>
				</table> 
			</div>
			<!-- <div class="col-md-2">
				<div class="label_name">AUTO REFRACTION (ARx) <i onclick="refraction_ar_rtl();" title="Copy Right to Left" class="fa fa-arrow-left"></i> </div>
			</div>
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="25%"></th>
							<th width="25%">Sph</th>
							<th width="25%">Cyl</th>
							<th width="25%">Axis</th>
						</tr>
					</thead>
					<tbody>
						<tr> 
							<td style="text-align:left;">Dry</td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dry_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dry_sph'];?>" name="refraction_ar_r_dry_sph" id="refraction_ar_r_dry_sph" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dry_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dry_cyl'];?>" name="refraction_ar_r_dry_cyl" id="refraction_ar_r_dry_cyl" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dry_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dry_axis'];?>" name="refraction_ar_r_dry_axis" id="refraction_ar_r_dry_axis" class="w-50px auto_fer2 d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Dilated</td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dd_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dd_sph'];?>" name="refraction_ar_r_dd_sph" id="refraction_ar_r_dd_sph" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dd_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dd_cyl'];?>" name="refraction_ar_r_dd_cyl" id="refraction_ar_r_dd_cyl" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dd_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_dd_axis'];?>" name="refraction_ar_r_dd_axis" id="refraction_ar_r_dd_axis" class="w-50px auto_fer2 d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b1_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b1_sph'];?>" name="refraction_ar_r_b1_sph" id="refraction_ar_r_b1_sph" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b1_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b1_cyl'];?>" name="refraction_ar_r_b1_cyl" id="refraction_ar_r_b1_cyl" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b1_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b1_axis'];?>" name="refraction_ar_r_b1_axis" id="refraction_ar_r_b1_axis" class="w-50px auto_fer2 d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b2_sph'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b2_sph'];?>" name="refraction_ar_r_b2_sph" id="refraction_ar_r_b2_sph" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b2_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b2_cyl'];?>" name="refraction_ar_r_b2_cyl" id="refraction_ar_r_b2_cyl" class="w-50px auto_fer2 d-none"></td>
							<td><span class="auto_fer2"><?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b2_axis'];?></span> <input type="text" value="<?php echo $refrtsn_auto_ref_dilted['refraction_ar_r_b2_axis'];?>" name="refraction_ar_r_b2_axis" id="refraction_ar_r_b2_axis" class="w-50px auto_fer2 d-none"></td>
						</tr>
					</tbody>
				</table>
			</div> -->
		</div>
	</div>
</section>

<section class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<div class="text-right btn_edit"><a href="javascript:void(0)" class="btn_fill" onclick="$('.dry_ref').toggle();">Edit</a><hr></div>
			</div>
			<div class="col-md-2">
				<div class="label_name">DRY REFRACTION <i onclick="refraction_dry_ref_ltr();" title="Copy Left to Right" class="fa fa-arrow-right"></i> </div>
				<button type="button" class="btn_fill dry_ref d-none" title="Fill DRY REFRACTION" onclick="return open_modals('refraction_dry_ref','DRY-REFRACTION');">Fill <i class="fa fa-arrow-right"></i> </button> 	
				<button type="button" onclick="cpoy_to_glass_pres('refraction_dry_ref');" title="Copy Dry Refraction to Glass Prescription" class="btn_fill"> Copy <i class="fa fa-arrow-down"></i></button>	
			</div>					
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="20%"></th>
							<th width="20%">Sph</th>
							<th width="20%">Cyl</th>
							<th width="20%">Axis</th>
							<th width="20%">Vision</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">Distant</td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_sph'];?>" name="refraction_dry_ref_l_dt_sph" id="refraction_dry_ref_l_dt_sph" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_cyl'];?>" name="refraction_dry_ref_l_dt_cyl" id="refraction_dry_ref_l_dt_cyl" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_axis'];?>" name="refraction_dry_ref_l_dt_axis" id="refraction_dry_ref_l_dt_axis" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_vision'];?>" name="refraction_dry_ref_l_dt_vision" id="refraction_dry_ref_l_dt_vision" class="w-50px dry_ref d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Prism</td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_sph'];?>" name="refraction_dry_ref_l_ad_sph" id="refraction_dry_ref_l_ad_sph" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_cyl'];?>" name="refraction_dry_ref_l_ad_cyl" id="refraction_dry_ref_l_ad_cyl" class="w-50px dry_ref d-none" disabled></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_axis'];?>" name="refraction_dry_ref_l_ad_axis" id="refraction_dry_ref_l_ad_axis" class="w-50px dry_ref d-none" disabled></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_vision'];?>" name="refraction_dry_ref_l_ad_vision" id="refraction_dry_ref_l_ad_vision" class="w-50px dry_ref d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Near</td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_sph'];?>" name="refraction_dry_ref_l_nr_sph" id="refraction_dry_ref_l_nr_sph" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_cyl'];?>" name="refraction_dry_ref_l_nr_cyl" id="refraction_dry_ref_l_nr_cyl" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_axis'];?>" name="refraction_dry_ref_l_nr_axis" id="refraction_dry_ref_l_nr_axis" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_vision'];?>" name="refraction_dry_ref_l_nr_vision" id="refraction_dry_ref_l_nr_vision" class="w-50px dry_ref d-none"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-2">
				<div class="label_name">DRY REFRACTION <i onclick="refraction_dry_ref_rtl();" title="Copy Right to Left" class="fa fa-arrow-left"></i></div>
			</div>					
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="20%"></th>
							<th width="20%">Sph</th>
							<th width="20%">Cyl</th>
							<th width="20%">Axis</th>
							<th width="20%">Vision</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">Distant</td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_sph'];?>" name="refraction_dry_ref_r_dt_sph" id="refraction_dry_ref_r_dt_sph" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_cyl'];?>" name="refraction_dry_ref_r_dt_cyl" id="refraction_dry_ref_r_dt_cyl" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_axis'];?>" name="refraction_dry_ref_r_dt_axis" id="refraction_dry_ref_r_dt_axis" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_vision'];?>" name="refraction_dry_ref_r_dt_vision" id="refraction_dry_ref_r_dt_vision" class="w-50px dry_ref d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Prism</td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_sph'];?>" name="refraction_dry_ref_r_ad_sph" id="refraction_dry_ref_r_ad_sph" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_cyl'];?>" name="refraction_dry_ref_r_ad_cyl" id="refraction_dry_ref_r_ad_cyl" class="w-50px dry_ref d-none" disabled></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_axis'];?>" name="refraction_dry_ref_r_ad_axis" id="refraction_dry_ref_r_ad_axis" class="w-50px dry_ref d-none" disabled></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_vision'];?>" name="refraction_dry_ref_r_ad_vision" id="refraction_dry_ref_r_ad_vision" class="w-50px dry_ref d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Near</td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_sph'];?>" name="refraction_dry_ref_r_nr_sph" id="refraction_dry_ref_r_nr_sph" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_cyl'];?>" name="refraction_dry_ref_r_nr_cyl" id="refraction_dry_ref_r_nr_cyl" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_axis'];?>" name="refraction_dry_ref_r_nr_axis" id="refraction_dry_ref_r_nr_axis" class="w-50px dry_ref d-none"></td>
							<td><span class="dry_ref"><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_vision'];?>" name="refraction_dry_ref_r_nr_vision" id="refraction_dry_ref_r_nr_vision" class="w-50px dry_ref d-none"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel-footer dry_ref d-none">
		<div class="row">
			<div class="col-md-2">Comment:</div>
			<div class="col-md-4">
				<textarea name="refraction_dry_ref_l_comm" id="refraction_dry_ref_l_comm" class="form-control"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_comm'];?></textarea>
			</div>
			<div class="col-md-2">Comment:</div>
			<div class="col-md-4">
				<textarea name="refraction_dry_ref_r_comm" id="refraction_dry_ref_r_comm"  class="form-control"><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_comm'];?></textarea>
			</div>
		</div>
	</div>
</section>

<section class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12 text-right btn_edit"><a href="javascript:void(0)" class="btn_fill" onclick="$('.ref_dil').toggle();">Edit</a><hr></div>
			<div class="col-md-2">
				<div class="label_name">REFRACTION (DILATED) <i onclick="refraction_ref_dtd_ltr();" title="Copy Left to Right" class="fa fa-arrow-right"></i> </div>
				<button type="button" class="btn_fill ref_dil d-none" title="Fill REFRACTION (DILATED)" onclick="return open_modals('refraction_ref_dtd','REFRACTION-DILATED');">Fill <i class="fa fa-arrow-right"></i> </button> 	
				<button type="button" title="Copy Dilated Refraction to Glass Prescription" onclick="cpoy_to_glass_pres('refraction_ref_dtd');" class="btn_fill"> Copy <i class="fa fa-arrow-down"></i></button>	
			</div>			
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="20%"></th>
							<th width="20%">Sph</th>
							<th width="20%">Cyl</th>
							<th width="20%">Axis</th>
							<th width="20%">Vision</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">Distant</td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_sph'];?>" name="refraction_ref_dtd_l_dt_sph" id="refraction_ref_dtd_l_dt_sph" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_cyl'];?>" name="refraction_ref_dtd_l_dt_cyl" id="refraction_ref_dtd_l_dt_cyl" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_axis'];?>" name="refraction_ref_dtd_l_dt_axis" id="refraction_ref_dtd_l_dt_axis" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_vision'];?>" name="refraction_ref_dtd_l_dt_vision" id="refraction_ref_dtd_l_dt_vision" class="w-50px ref_dil d-none"></td>
						</tr>
						<!-- <tr>
							<td style="text-align:left;">Add <span class="text-danger">#</span></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_ad_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_ad_sph'];?>" name="refraction_ref_dtd_l_ad_sph" id="refraction_ref_dtd_l_ad_sph" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_ad_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_ad_cyl'];?>" name="refraction_ref_dtd_l_ad_cyl" id="refraction_ref_dtd_l_ad_cyl" class="w-50px ref_dil d-none" disabled ></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_ad_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_ad_axis'];?>" name="refraction_ref_dtd_l_ad_axis" id="refraction_ref_dtd_l_ad_axis" class="w-50px ref_dil d-none" disabled></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_ad_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_ad_vision'];?>" name="refraction_ref_dtd_l_ad_vision" id="refraction_ref_dtd_l_ad_vision" class="w-50px ref_dil d-none"></td>
						</tr> -->
						<tr>
							<td style="text-align:left;">Near</td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_sph'];?>" name="refraction_ref_dtd_l_nr_sph" id="refraction_ref_dtd_l_nr_sph" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_cyl'];?>" name="refraction_ref_dtd_l_nr_cyl" id="refraction_ref_dtd_l_nr_cyl" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_axis'];?>" name="refraction_ref_dtd_l_nr_axis" id="refraction_ref_dtd_l_nr_axis" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_vision'];?>" name="refraction_ref_dtd_l_nr_vision" id="refraction_ref_dtd_l_nr_vision" class="w-50px ref_dil d-none"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-2">
				<div class="label_name">REFRACTION (DILATED) <i onclick="refraction_ref_dtd_rtl();" title="Copy Right to Left" class="fa fa-arrow-left"></i> </div>							
			</div>			
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="20%"></th>
							<th width="20%">Sph</th>
							<th width="20%">Cyl</th>
							<th width="20%">Axis</th>
							<th width="20%">Vision</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">Distant</td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_sph'];?>" name="refraction_ref_dtd_r_dt_sph" id="refraction_ref_dtd_r_dt_sph" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_cyl'];?>" name="refraction_ref_dtd_r_dt_cyl" id="refraction_ref_dtd_r_dt_cyl" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_axis'];?>" name="refraction_ref_dtd_r_dt_axis" id="refraction_ref_dtd_r_dt_axis" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_vision'];?>" name="refraction_ref_dtd_r_dt_vision" id="refraction_ref_dtd_r_dt_vision" class="w-50px ref_dil d-none"></td>
						</tr>
						<!-- <tr>
							<td style="text-align:left;">Add <span class="text-danger">#</span></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_ad_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_ad_sph'];?>" name="refraction_ref_dtd_r_ad_sph" id="refraction_ref_dtd_r_ad_sph" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_ad_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_ad_cyl'];?>" name="refraction_ref_dtd_r_ad_cyl" id="refraction_ref_dtd_r_ad_cyl" class="w-50px ref_dil d-none" disabled ></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_ad_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_ad_axis'];?>" name="refraction_ref_dtd_r_ad_axis" id="refraction_ref_dtd_r_ad_axis" class="w-50px ref_dil d-none" disabled></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_ad_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_ad_vision'];?>" name="refraction_ref_dtd_r_ad_vision" id="refraction_ref_dtd_r_ad_vision" class="w-50px ref_dil d-none"></td>
						</tr> -->
						<tr>
							<td style="text-align:left;">Near</td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_sph'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_sph'];?>" name="refraction_ref_dtd_r_nr_sph" id="refraction_ref_dtd_r_nr_sph" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_cyl'];?>" name="refraction_ref_dtd_r_nr_cyl" id="refraction_ref_dtd_r_nr_cyl" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_axis'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_axis'];?>" name="refraction_ref_dtd_r_nr_axis" id="refraction_ref_dtd_r_nr_axis" class="w-50px ref_dil d-none"></td>
							<td><span class="ref_dil"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_vision'];?></span> <input type="text" value="<?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_vision'];?>" name="refraction_ref_dtd_r_nr_vision" id="refraction_ref_dtd_r_nr_vision" class="w-50px ref_dil d-none"></td>
						</tr>
					</tbody>
				</table>							
			</div>
		</div>					
	</div>
	<div class="panel-footer ref_dil d-none">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-4">Drug Used</div>
					<div class="col-md-8">
						<select name="refraction_ref_dtd_l_du" id="refraction_ref_dtd_l_du" class="custom-selct">
							<option value="">Select</option>
							<option value="Tropicamide" <?php if($refrtsn_dltd['refraction_ref_dtd_l_du']=='Tropicamide'){ echo 'selected';} ?>>Tropicamide</option>
							<option value="Tropicamide - P" <?php if($refrtsn_dltd['refraction_ref_dtd_l_du']=='Tropicamide - P'){ echo 'selected';} ?>>Tropicamide - P</option>
							<option value="Atropine" <?php if($refrtsn_dltd['refraction_ref_dtd_l_du']=='Atropine'){ echo 'selected';} ?>>Atropine</option>
							<option value="Cyclopentolate" <?php if($refrtsn_dltd['refraction_ref_dtd_l_du']=='Cyclopentolate'){ echo 'selected';} ?>>Cyclopentolate</option>
							<option value="Homide" <?php if($refrtsn_dltd['refraction_ref_dtd_l_du']=='Homide'){ echo 'selected';} ?>>Homide</option>
							<option value="Dry" <?php if($refrtsn_dltd['refraction_ref_dtd_l_du']=='Dry'){ echo 'selected';} ?>>Dry</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-2"></div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-4">Drug Used</div>
					<div class="col-md-8">
						<select name="refraction_ref_dtd_r_du" id="refraction_ref_dtd_r_du" class="custom-selct">
							<option value="">Select</option>
							<option value="Tropicamide" <?php if($refrtsn_dltd['refraction_ref_dtd_r_du']=='Tropicamide'){ echo 'selected';} ?>>Tropicamide</option>
							<option value="Tropicamide - P" <?php if($refrtsn_dltd['refraction_ref_dtd_r_du']=='Tropicamide - P'){ echo 'selected';} ?>>Tropicamide - P</option>
							<option value="Atropine" <?php if($refrtsn_dltd['refraction_ref_dtd_r_du']=='Atropine'){ echo 'selected';} ?>>Atropine</option>
							<option value="Cyclopentolate" <?php if($refrtsn_dltd['refraction_ref_dtd_r_du']=='Cyclopentolate'){ echo 'selected';} ?>>Cyclopentolate</option>
							<option value="Homide" <?php if($refrtsn_dltd['refraction_ref_dtd_r_du']=='Homide'){ echo 'selected';} ?>>Homide</option>
							<option value="Dry" <?php if($refrtsn_dltd['refraction_ref_dtd_r_du']=='Dry'){ echo 'selected';} ?>>Dry</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-footer ref_dil d-none">
		<div class="row">
			<div class="col-md-2">Comment:</div>
			<div class="col-md-4">
				<textarea name="refraction_ref_dtd_l_comm" id="refraction_ref_dtd_l_comm" class="form-control"><?php echo $refrtsn_dltd['refraction_ref_dtd_l_comm'];?></textarea>
			</div>
			<div class="col-md-2">Comment:</div>
			<div class="col-md-4">
				<textarea name="refraction_ref_dtd_r_comm" id="refraction_ref_dtd_r_comm" class="form-control"><?php echo $refrtsn_dltd['refraction_ref_dtd_r_comm'];?></textarea>
			</div>
		</div>
	</div>
</section>

<section class="panel panel-default">
	<div class="panel-body">			
		<div class="row">
			<div class="col-md-12 text-right btn_edit"><a href="javascript:void(0)" class="btn_fill" onclick="$('.pmt').toggle();">Edit</a><hr></div>
			<div class="col-md-2">
				<div class="label_name">PMT <i onclick="refraction_pmt_ltr();" title="Copy Left to Right" class="fa fa-arrow-right"></i> </div>
				<button type="button" class="btn_fill pmt d-none" title="Fill PMT" onclick="return open_modals('refraction_pmt','PMT');">Fill <i class="fa fa-arrow-right"></i> </button> 	
				<button type="button" title="Copy PMT to Glass Prescription" onclick="cpoy_to_glass_pres('refraction_pmt');" class="btn_fill"> Copy <i class="fa fa-arrow-down"></i></button>	
			</div>			
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="20%"></th>
							<th width="20%">Sph</th>
							<th width="20%">Cyl</th>
							<th width="20%">Axis</th>
							<th width="20%">Vision</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">Distant</td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_dt_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_dt_sph'];?>" name="refraction_pmt_l_dt_sph" id="refraction_pmt_l_dt_sph" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_dt_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_dt_cyl'];?>" name="refraction_pmt_l_dt_cyl" id="refraction_pmt_l_dt_cyl" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_dt_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_dt_axis'];?>" name="refraction_pmt_l_dt_axis" id="refraction_pmt_l_dt_axis" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_dt_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_dt_vision'];?>" name="refraction_pmt_l_dt_vision" id="refraction_pmt_l_dt_vision" class="w-50px pmt d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Prism</td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_ad_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_ad_sph'];?>" name="refraction_pmt_l_ad_sph" id="refraction_pmt_l_ad_sph" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_ad_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_ad_cyl'];?>" name="refraction_pmt_l_ad_cyl" id="refraction_pmt_l_ad_cyl" class="w-50px pmt d-none" disabled ></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_ad_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_ad_axis'];?>" name="refraction_pmt_l_ad_axis" id="refraction_pmt_l_ad_axis" class="w-50px pmt d-none" disabled ></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_ad_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_ad_vision'];?>" name="refraction_pmt_l_ad_vision" id="refraction_pmt_l_ad_vision" class="w-50px pmt d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Near</td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_nr_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_nr_sph'];?>" name="refraction_pmt_l_nr_sph" id="refraction_pmt_l_nr_sph" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_nr_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_nr_cyl'];?>" name="refraction_pmt_l_nr_cyl" id="refraction_pmt_l_nr_cyl" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_nr_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_nr_axis'];?>" name="refraction_pmt_l_nr_axis" id="refraction_pmt_l_nr_axis" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_l_nr_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_l_nr_vision'];?>" name="refraction_pmt_l_nr_vision" id="refraction_pmt_l_nr_vision" class="w-50px pmt d-none"></td>
						</tr>
					</tbody>
				</table>
			</div>					
			<div class="col-md-2">
				<div class="label_name">PMT <i onclick="refraction_pmt_rtl();" title="Copy Right to Left" class="fa fa-arrow-left"></i> </div>							
			</div>			
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="20%"></th>
							<th width="20%">Sph</th>
							<th width="20%">Cyl</th>
							<th width="20%">Axis</th>
							<th width="20%">Vision</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">Distant</td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_dt_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_dt_sph'];?>" name="refraction_pmt_r_dt_sph" id="refraction_pmt_r_dt_sph" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_dt_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_dt_cyl'];?>" name="refraction_pmt_r_dt_cyl" id="refraction_pmt_r_dt_cyl" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_dt_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_dt_axis'];?>" name="refraction_pmt_r_dt_axis" id="refraction_pmt_r_dt_axis" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_dt_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_dt_vision'];?>" name="refraction_pmt_r_dt_vision" id="refraction_pmt_r_dt_vision" class="w-50px pmt d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Prism</td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_ad_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_ad_sph'];?>" name="refraction_pmt_r_ad_sph" id="refraction_pmt_r_ad_sph" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_ad_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_ad_cyl'];?>" name="refraction_pmt_r_ad_cyl" id="refraction_pmt_r_ad_cyl" class="w-50px pmt d-none" disabled></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_ad_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_ad_axis'];?>" name="refraction_pmt_r_ad_axis" id="refraction_pmt_r_ad_axis" class="w-50px pmt d-none" disabled></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_ad_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_ad_vision'];?>" name="refraction_pmt_r_ad_vision" id="refraction_pmt_r_ad_vision" class="w-50px pmt d-none"></td>
						</tr>
						<tr>
							<td style="text-align:left;">Near</td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_nr_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_nr_sph'];?>" name="refraction_pmt_r_nr_sph" id="refraction_pmt_r_nr_sph" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_nr_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_nr_cyl'];?>" name="refraction_pmt_r_nr_cyl" id="refraction_pmt_r_nr_cyl" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_nr_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_nr_axis'];?>" name="refraction_pmt_r_nr_axis" id="refraction_pmt_r_nr_axis" class="w-50px pmt d-none"></td>
							<td><span class="pmt"><?php echo $refrtsn_pmt['refraction_pmt_r_nr_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pmt['refraction_pmt_r_nr_vision'];?>" name="refraction_pmt_r_nr_vision" id="refraction_pmt_r_nr_vision" class="w-50px pmt d-none"></td>
						</tr>
						</tr>
					</tbody>
				</table>							
			</div>
		</div>
	</div>
</section>

<section class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<div class="text-right btn_edit"><a href="javascript:void(0)" class="btn_fill" onclick="$('.meter_pgp').toggle();">Edit</a><hr></div>
			</div>
			<div class="col-md-2">
				<div class="label_name">PGP <i onclick="refraction_pgp_ltr();" class="fa fa-arrow-right" title="Copy Left to Right"></i> </div>
				<button type="button" class="btn_fill meter_pgp d-none" title="Fill PGP" onclick="return open_modals('refraction_pgp','PGP');">Fill <i class="fa fa-arrow-right"></i> </button> 	
				<button type="button" title="Copy PGP to Glass Prescription" onclick="cpoy_to_glass_pres('refraction_pgp');"  class="btn_fill"> Copy <i class="fa fa-arrow-down"></i></button>	
			</div>					
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="20%"></th>
							<th width="20%">Sph</th>
							<th width="20%">Cyl</th>
							<th width="20%">Axis</th>
							<th width="20%">Vision</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">Distant</td> 
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_dt_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_dt_sph'];?>" name="refraction_pgp_l_dt_sph" id="refraction_pgp_l_dt_sph" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_dt_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_dt_cyl'];?>" name="refraction_pgp_l_dt_cyl" id="refraction_pgp_l_dt_cyl" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_dt_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_dt_axis'];?>" name="refraction_pgp_l_dt_axis" id="refraction_pgp_l_dt_axis" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_dt_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_dt_vision'];?>" name="refraction_pgp_l_dt_vision" id="refraction_pgp_l_dt_vision" class="w-50px meter_pgp d-none"></td>
						</tr>
						<!-- <tr>
							<td style="text-align:left;">Add <span class="text-danger">#</span></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_ad_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_ad_sph'];?>" name="refraction_pgp_l_ad_sph" id="refraction_pgp_l_ad_sph" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_ad_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_ad_cyl'];?>" name="refraction_pgp_l_ad_cyl" id="refraction_pgp_l_ad_cyl" class="w-50px meter_pgp d-none" disabled></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_ad_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_ad_axis'];?>" name="refraction_pgp_l_ad_axis" id="refraction_pgp_l_ad_axis" class="w-50px meter_pgp d-none" disabled></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_ad_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_ad_vision'];?>" name="refraction_pgp_l_ad_vision" id="refraction_pgp_l_ad_vision" class="w-50px meter_pgp d-none"></td>
						</tr> -->
						<tr>
							<td style="text-align:left;">Near</td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_nr_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_nr_sph'];?>" name="refraction_pgp_l_nr_sph" id="refraction_pgp_l_nr_sph" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_nr_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_nr_cyl'];?>" name="refraction_pgp_l_nr_cyl" id="refraction_pgp_l_nr_cyl" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_nr_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_nr_axis'];?>" name="refraction_pgp_l_nr_axis" id="refraction_pgp_l_nr_axis" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_l_nr_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_l_nr_vision'];?>" name="refraction_pgp_l_nr_vision" id="refraction_pgp_l_nr_vision" class="w-50px meter_pgp d-none"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-2">
				<div class="label_name">PGP <i onclick="refraction_pgp_rtl();" class="fa fa-arrow-left" title="Copy Right to Left"></i> </div>							
			</div>					
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="20%"></th>
							<th width="20%">Sph</th>
							<th width="20%">Cyl</th>
							<th width="20%">Axis</th>
							<th width="20%">Vision</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">Distant</td> 
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_dt_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_dt_sph'];?>" name="refraction_pgp_r_dt_sph" id="refraction_pgp_r_dt_sph" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_dt_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_dt_cyl'];?>" name="refraction_pgp_r_dt_cyl" id="refraction_pgp_r_dt_cyl" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_dt_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_dt_axis'];?>" name="refraction_pgp_r_dt_axis" id="refraction_pgp_r_dt_axis" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_dt_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_dt_vision'];?>" name="refraction_pgp_r_dt_vision" id="refraction_pgp_r_dt_vision" class="w-50px meter_pgp d-none"></td>
						</tr>
						<!-- <tr>
							<td style="text-align:left;">Add <span class="text-danger">#</span></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_ad_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_ad_sph'];?>" name="refraction_pgp_r_ad_sph" id="refraction_pgp_r_ad_sph" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_ad_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_ad_cyl'];?>" name="refraction_pgp_r_ad_cyl" id="refraction_pgp_r_ad_cyl" class="w-50px meter_pgp d-none" disabled></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_ad_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_ad_axis'];?>" name="refraction_pgp_r_ad_axis" id="refraction_pgp_r_ad_axis" class="w-50px meter_pgp d-none" disabled></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_ad_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_ad_vision'];?>" name="refraction_pgp_r_ad_vision" id="refraction_pgp_r_ad_vision" class="w-50px meter_pgp d-none"></td>
						</tr> -->
						<tr>
							<td style="text-align:left;">Near</td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_nr_sph'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_nr_sph'];?>" name="refraction_pgp_r_nr_sph" id="refraction_pgp_r_nr_sph" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_nr_cyl'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_nr_cyl'];?>" name="refraction_pgp_r_nr_cyl" id="refraction_pgp_r_nr_cyl" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_nr_axis'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_nr_axis'];?>" name="refraction_pgp_r_nr_axis" id="refraction_pgp_r_nr_axis" class="w-50px meter_pgp d-none"></td>
							<td><span class="meter_pgp"><?php echo $refrtsn_pgp['refraction_pgp_r_nr_vision'];?></span> <input type="text" value="<?php echo $refrtsn_pgp['refraction_pgp_r_nr_vision'];?>" name="refraction_pgp_r_nr_vision" id="refraction_pgp_r_nr_vision" class="w-50px meter_pgp d-none"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel-footer meter_pgp d-none">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-1 pr-0">Type of Lens :</div>
			<div class="col-md-3">
				<select name="refraction_pgp_l_lens" id="refraction_pgp_l_lens" class="custom-select">
					<option value="">Select</option>
					<option value="Single Vision - Distant" <?php if($refrtsn_pgp['refraction_pgp_l_lens']=='Single Vision - Distant'){ echo 'selected';} ?>>Single Vision - Distant</option>
					<option value="Single Vision - Near" <?php if($refrtsn_pgp['refraction_pgp_l_lens']=='Single Vision - Near'){ echo 'selected';} ?>>Single Vision - Near</option>
					<option value="Bifocal" <?php if($refrtsn_pgp['refraction_pgp_l_lens']=='Bifocal'){ echo 'selected';} ?>>Bifocal</option>
					<option value="Progressive" <?php if($refrtsn_pgp['refraction_pgp_l_lens']=='Progressive'){ echo 'selected';} ?>>Progressive</option>
					<option value="D Bifocal" <?php if($refrtsn_pgp['refraction_pgp_l_lens']=='D Bifocal'){ echo 'selected';} ?>>D Bifocal</option>
					<option value="KT Bifocal" <?php if($refrtsn_pgp['refraction_pgp_l_lens']=='KT Bifocal'){ echo 'selected';} ?>>KT Bifocal</option>
				</select>
			</div>			
			<div class="col-md-2"></div>
			<div class="col-md-1 pr-0">Type of Lens :</div>
			<div class="col-md-3">
				<select name="refraction_pgp_r_lens" id="refraction_pgp_r_lens" class="custom-select">
					<option value="">Select</option>
					<option value="Single Vision - Distant" <?php if($refrtsn_pgp['refraction_pgp_r_lens']=='Single Vision - Distant'){ echo 'selected';} ?>>Single Vision - Distant</option>
					<option value="Single Vision - Near" <?php if($refrtsn_pgp['refraction_pgp_r_lens']=='Single Vision - Near'){ echo 'selected';} ?>>Single Vision - Near</option>
					<option value="Bifocal" <?php if($refrtsn_pgp['refraction_pgp_r_lens']=='Bifocal'){ echo 'selected';} ?>>Bifocal</option>
					<option value="Progressive" <?php if($refrtsn_pgp['refraction_pgp_r_lens']=='Progressive'){ echo 'selected';} ?>>Progressive</option>
					<option value="D Bifocal" <?php if($refrtsn_pgp['refraction_pgp_r_lens']=='D Bifocal'){ echo 'selected';} ?>>D Bifocal</option>
					<option value="KT Bifocal" <?php if($refrtsn_pgp['refraction_pgp_r_lens']=='KT Bifocal'){ echo 'selected';} ?>>KT Bifocal</option>
				</select>
			</div>	
		</div>
	</div>
</section>

<section class="panel panel-default">
	<div class="panel-body">
		<div class="row">				
			<div class="col-md-12">
				<div class="text-right btn_edit"><a href="javascript:void(0)" class="btn_fill" onclick="$('.kero_meter').toggle();">Edit</a><hr></div>
			</div>
			<div class="col-md-2">
				<div class="label_name">KERATOMETRY (K) <i onclick="refraction_km_ltr();" class="fa fa-arrow-right" title="Copy Left to Right"></i> </div>
			</div>
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="33.33%"></th>
							<th width="33.33%">Value</th>
							<th width="33.33%">Axis</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">k1</td>
							<td>
								<span class="kero_meter"><?php echo $refrtsn_kerat['refraction_km_l_kh'];?></span> <input type="text" name="refraction_km_l_kh" id="refraction_km_l_kh" class="w-100px kero_meter" value="<?php echo $refrtsn_kerat['refraction_km_l_kh'];?>" style="display:none;">
							</td>
							<td><span class="kero_meter"> <?php echo $refrtsn_kerat['refraction_km_l_kh_a'];?> </span> <input type="text" name="refraction_km_l_kh_a" id="refraction_km_l_kh_a" value="<?php echo $refrtsn_kerat['refraction_km_l_kh_a'];?>" class="w-100px kero_meter" style="display:none;"></td>
						</tr>
						<tr>
							<td style="text-align:left;">K2</td>
							
							<td>
								<span class="kero_meter"><?php echo $refrtsn_kerat['refraction_km_l_kv'];?></span> <input type="text" name="refraction_km_l_kv" id="refraction_km_l_kv" class="w-100px kero_meter" value="<?php echo $refrtsn_kerat['refraction_km_l_kv'];?>" style="display:none;">
							</td>
							<td><span class="kero_meter"> <?php echo $refrtsn_kerat['refraction_km_l_kv_a'];?> </span> <input type="text" name="refraction_km_l_kv_a" id="refraction_km_l_kv_a" value="<?php echo $refrtsn_kerat['refraction_km_l_kv_a'];?>" class="w-100px kero_meter" style="display:none;"></td>
						</tr>
					</tbody>
				</table>
			</div>			
			<div class="col-md-2">
				<div class="label_name">KERATOMETRY (K) <i onclick="refraction_km_rtl();" class="fa fa-arrow-left" title="Copy Right to Left"></i> </div>
			</div>
			<div class="col-md-4">
				<table class="table table-bordered">
					<thead class="bg-info">
						<tr>
							<th width="33.33%"></th>
							<th width="33.33%">Value</th>
							<th width="33.33%">Axis</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:left;">K1</td>
							<td>
								<span class="kero_meter"><?php echo $refrtsn_kerat['refraction_km_r_kh'];?></span> <input type="text" name="refraction_km_r_kh" id="refraction_km_r_kh" class="w-100px kero_meter" value="<?php echo $refrtsn_kerat['refraction_km_r_kh'];?>" style="display:none;">
							</td>
							<td><span class="kero_meter"> <?php echo $refrtsn_kerat['refraction_km_r_kh_a'];?> </span> <input type="text" name="refraction_km_r_kh_a" id="refraction_km_r_kh_a" class="w-100px kero_meter" value="<?php echo $refrtsn_kerat['refraction_km_r_kh_a'];?>" style="display:none;"></td>
						</tr>
						<tr>
							<td style="text-align:left;">K2</td>
							<td>
								<span class="kero_meter"><?php echo $refrtsn_kerat['refraction_km_r_kv'];?></span> <input type="text" name="refraction_km_r_kv" id="refraction_km_r_kv" class="w-100px kero_meter" value="<?php echo $refrtsn_kerat['refraction_km_r_kv'];?>" style="display:none;">
							</td>
							<td><span class="kero_meter"> <?php echo $refrtsn_kerat['refraction_km_r_kv_a'];?> </span> <input type="text" name="refraction_km_r_kv_a" id="refraction_km_r_kv_a" class="w-100px kero_meter" value="<?php echo $refrtsn_kerat['refraction_km_r_kv_a'];?>" style="display:none;"></td>
						</tr>
					</tbody>
				</table>
			</div>


			
            
				
			

		</div>

		<div class="row">
				<div class="col-md-4">
					<div class="grp-full">
						<div class="form-group row">
							<label for="average_k1" class="col-md-4 col-form-label">Average K :</label>
							<div class="col-md-8">
								
								<input type="text" id="average_k1" name="average_k1" class="form-control" style="width: 200px;" value="<?php echo $refraction_data['average_k1'];?>">
							</div>
						</div>
					</div>
				</div> 
				
				<div class="col-md-2"></div>
				
				<div class="col-md-4">
					<div class="grp-full">
						<div class="form-group row">
							<label for="average_k2" class="col-md-4 col-form-label">Average k :</label>
							<div class="col-md-8">
								
								<input type="text" id="average_k2" name="average_k2" class="form-control" style="width: 200px;" value="<?php echo $refraction_data['average_k2'];?>">
							</div>
						</div>
					</div>
				</div> 
				<div class="col-md-4">
					<div class="grp-full">
						<div class="form-group row">
							<label for="eye1" class="col-md-4 col-form-label">Eye:</label>
							<div class="col-md-8">
								
								<input type="text" id="eye1" name="eye1" class="form-control" style="width: 200px;" value="<?php echo $refraction_data['eye1'];?>">
							</div>
						</div>
					</div>
				</div> 
				<div class="col-md-2"></div>

				<div class="col-md-4">
					<div class="grp-full">
						<div class="form-group row">
							<label for="eye2" class="col-md-4 col-form-label">Eye :</label>
							<div class="col-md-8">
								
								<input type="text" id="eye2" name="eye2" class="form-control" style="width: 200px;" value="<?php echo $refraction_data['eye2'];?>">
							</div>
						</div>
					</div>
				</div> 
		</div>
	</div>			
</section>

<script>
$(document).on('input', '#myRange_l', function() {
    $('#range_l').val($(this).val());
});
$(document).on('input', '#myRange_r', function() {
    $('#range_r').val($(this).val() );
});
$(document).ready(function(){
    var pres_id = '<?php echo $pres_id;?>';
    if(pres_id =='')
    {
    	$('.datepicker3').val('<?php echo date('h:i A');?>');
		$('.first_row').toggle();
		$('.kero_meter').toggle();
		$('.meter_pgp').toggle();
		$('.auto_ref').toggle();
		$('.con_sen').toggle();
		$('.contact_lens').toggle();
		$('.inter_glass').toggle();
		$('.glasses_pre').toggle();
		$('.pmt').toggle();
		$('.retin').toggle();
		$('.ref_dil').toggle();
		$('.dry_ref').toggle();
		$('.btn_edit').toggle();
	}
	else{
		$('.opm19').change(function() {
			  $('#opm19').val('red');
			});
		$('.opm20').change(function() {
			 $('#opm20').val('red');
			});
	}


	$('.refraction_va_ua_l').click(function(){
		$('.ua_l_txt').show();
		$('.refraction_va_ua_l').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
	$('.refraction_va_ua_r').click(function(){
		$('.ua_r_txt').show();
		$('.refraction_va_ua_r').parent().removeClass('active');
		$(this).parent().addClass('active');
	});

	$('.refraction_va_ua_l_2').click(function(){
		$('.ua_l2_txt').show();
		$('.refraction_va_ua_l_2').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
	$('.refraction_va_ua_r_2').click(function(){
		$('.ua_r2_txt').show();
		$('.refraction_va_ua_r_2').parent().removeClass('active');
		$(this).parent().addClass('active');
	});

    $('.refraction_va_ph_l').click(function(){
    	$('.ph_l_txt').show();
		$('.refraction_va_ph_l').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
	$('.refraction_va_ph_r').click(function(){
		$('.ph_r_txt').show();
		$('.refraction_va_ph_r').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
   $('.refraction_va_gls_l').click(function(){
   	    $('.gls_l_txt').show();
		$('.refraction_va_gls_l').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
    $('.refraction_va_gls_r').click(function(){
    	 $('.gls_r_txt').show();
		$('.refraction_va_gls_r').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
	$('.refraction_va_gls_l_2').click(function(){
		 $('.gls_l2_txt').show();
		$('.refraction_va_gls_l_2').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
	$('.refraction_va_gls_r_2').click(function(){
		 $('.gls_r2_txt').show();
		$('.refraction_va_gls_r_2').parent().removeClass('active');
		$(this).parent().addClass('active');
	});

	$('.refraction_va_cl_l').click(function(){
		 $('.cl_l_txt').show();
		$('.refraction_va_cl_l').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
	$('.refraction_va_cl_r').click(function(){
		 $('.cl_r_txt').show();
		$('.refraction_va_cl_r').parent().removeClass('active');
		$(this).parent().addClass('active');
	});

	$('.refraction_contra_sens_l').click(function(){
		$('.cons_clr_l').show();
		$('.refraction_contra_sens_l').parent().removeClass('active');
		$(this).parent().addClass('active');
	});

	$('.refraction_contra_sens_r').click(function(){
		$('.cons_clr_r').show();
		$('.refraction_contra_sens_r').parent().removeClass('active');
		$(this).parent().addClass('active');
	});

	$("#refraction_va_ua_l_p").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_ua_r_p").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_ua_l_p_2").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_ua_r_p_2").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_ph_l_p").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_ph_l_ni").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_ph_r_p").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_ph_r_ni").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });

    $("#refraction_va_gls_l_p").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_gls_r_p").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_gls_l_p_2").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_gls_r_p_2").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
   $("#refraction_va_cl_l_p").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_va_cl_r_p").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });

    $("#refraction_itgp_ad_check").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    $("#refraction_gps_ad_check").on('click',function(){
      $(this).parent().toggleClass('bg-theme');
    });
    
});
    
    function open_modals(modal_tab,title) {
			var $modal = $('#load_add_type_modal_popup');
			$modal.load('<?php echo base_url().'eye/add_eye_prescription/fill_eye_data/' ?>'+modal_tab+'/'+title,
			{
			},
			function(){
			$modal.modal('show');
			});
  	}

  	function open_modals_2(modal_tab) {
			var $modal = $('#load_add_type_modal_popup');
			$modal.load('<?php echo base_url().'eye/add_eye_prescription/fill_eye_data_auto_refraction/' ?>'+modal_tab,
			{
			},
			function(){
			$modal.modal('show');
			});
  	}
	function open_modals_3(modal_tab) {
			var $modal = $('#load_add_type_modal_popup_2');
			$modal.load('<?php echo base_url().'eye/add_eye_prescription/fill_eye_data_auto_refraction/' ?>'+modal_tab,
			{
			},
			function(){
			$modal.modal('show');
			});
  	}

  	function refraction_va_ltr()
  	{
  		  $('#refraction_va_ua_r_txt').val($('#refraction_va_ua_l_txt').val());
  		  $('#refraction_va_ua_r_2_txt').val($('#refraction_va_ua_l_2_txt').val());
  		  $('#refraction_va_ph_r_txt').val($('#refraction_va_ph_l_txt').val());
  		  $('#refraction_va_gls_r_txt').val($('#refraction_va_gls_l_txt').val());
  		  $('#refraction_va_gls_r_2_txt').val($('#refraction_va_gls_l_2_txt').val());
  		  $('#refraction_va_cl_r_txt').val($('#refraction_va_cl_l_txt').val());
  		  $('#refraction_va_r_comm').val($('#refraction_va_l_comm').val());

  		  $('#refraction_va_ua_r_pr_s').val($('#refraction_va_ua_l_pr_s').val());
  		  $('#refraction_va_ua_r_pr_i').val($('#refraction_va_ua_l_pr_i').val());
  		  $('#refraction_va_ua_r_pr_n').val($('#refraction_va_ua_l_pr_n').val());
  		  $('#refraction_va_ua_r_pr_t').val($('#refraction_va_ua_l_pr_t').val());

  		  if($('#refraction_va_ua_l_p').prop('checked') == true) {
			   $('#refraction_va_ua_r_p').prop('checked', true).parent().toggleClass('bg-theme');
			   $('.ua_r_txt').show();
			}
		 if($('#refraction_va_ua_l_p_2').prop('checked') == true) {
			   $('#refraction_va_ua_r_p_2').prop('checked', true).parent().toggleClass('bg-theme');
			   $('.ua_r2_txt').show();
			}  
  		 if($('#refraction_va_ph_l_p').prop('checked') == true) {
			   $('#refraction_va_ph_r_p').prop('checked', true).parent().toggleClass('bg-theme');
			   $('.ph_r_txt').show();
			} 
  		 if($('#refraction_va_ph_l_ni').prop('checked') == true) {
			   $('#refraction_va_ph_r_ni').prop('checked', true).parent().toggleClass('bg-theme');
			   $('.gls_r_txt').show();
			} 
		 if($('#refraction_va_gls_l_p').prop('checked') == true) {
		   $('#refraction_va_gls_r_p').prop('checked', true).parent().toggleClass('bg-theme');
		   $('.gls_r2_txt').show();
		} 
		if($('#refraction_va_gls_l_p_2').prop('checked') == true) {
		   $('#refraction_va_gls_r_p_2').prop('checked', true).parent().toggleClass('bg-theme');
		   $('.cl_r_txt').show();
		} 
		if($('#refraction_va_cl_l_p').prop('checked') == true) {
		   $('#refraction_va_cl_r_p').prop('checked', true).parent().toggleClass('bg-theme');
		   $('.cons_clr_r').show();
		}
  		  var radiosl1 = $('input[name=refraction_va_ua_l]');
  		  var radiosr1 = $('input[name=refraction_va_ua_r]');
  		  var vals1=$('input[name=refraction_va_ua_l]:checked').val();  		 
  		  if(radiosl1.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_ua_r').parent().removeClass('active');
		      radiosr1.filter('[value="'+vals1+'"]').prop('checked', true).parent().addClass('active');
		  }

		  var radiosl2 = $('input[name=refraction_va_ua_l_2]');
  		  var radiosr2 = $('input[name=refraction_va_ua_r_2]');
  		  var vals2=$('input[name=refraction_va_ua_l_2]:checked').val();  		 
  		  if(radiosl2.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_ua_r_2').parent().removeClass('active');
		      radiosr2.filter('[value="'+vals2+'"]').prop('checked', true).parent().addClass('active');
		  }
		  var radiosl3 = $('input[name=refraction_va_ph_l]');
  		  var radiosr3 = $('input[name=refraction_va_ph_r]');
  		  var vals3=$('input[name=refraction_va_ph_l]:checked').val();  		 
  		  if(radiosl3.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_ph_r').parent().removeClass('active');
		      radiosr3.filter('[value="'+vals3+'"]').prop('checked', true).parent().addClass('active');
		  }
		  var radiosl4 = $('input[name=refraction_va_gls_l]');
  		  var radiosr4 = $('input[name=refraction_va_gls_r]');
  		  var vals4=$('input[name=refraction_va_gls_l]:checked').val();  		 
  		  if(radiosl4.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_gls_r').parent().removeClass('active');
		      radiosr4.filter('[value="'+vals4+'"]').prop('checked', true).parent().addClass('active');
		  }
		  var radiosl5 = $('input[name=refraction_va_gls_l_2]');
  		  var radiosr5 = $('input[name=refraction_va_gls_r_2]');
  		  var vals5=$('input[name=refraction_va_gls_l_2]:checked').val();  		 
  		  if(radiosl5.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_gls_r_2').parent().removeClass('active');
		      radiosr5.filter('[value="'+vals5+'"]').prop('checked', true).parent().addClass('active');
		  }
		  var radiosl6 = $('input[name=refraction_va_cl_l]');
  		  var radiosr6 = $('input[name=refraction_va_cl_r]');
  		  var vals6=$('input[name=refraction_va_cl_l]:checked').val();  		 
  		  if(radiosl6.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_cl_r').parent().removeClass('active');
		      radiosr6.filter('[value="'+vals6+'"]').prop('checked', true).parent().addClass('active');
		  }
  	}
	function refraction_va_rtl()
	{
		 $('#refraction_va_ua_l_txt').val($('#refraction_va_ua_r_txt').val());
  		  $('#refraction_va_ua_l_2_txt').val($('#refraction_va_ua_r_2_txt').val());
  		  $('#refraction_va_ph_l_txt').val($('#refraction_va_ph_r_txt').val());
  		  $('#refraction_va_gls_l_txt').val($('#refraction_va_gls_r_txt').val());
  		  $('#refraction_va_gls_l_2_txt').val($('#refraction_va_gls_r_2_txt').val());
  		  $('#refraction_va_cl_l_txt').val($('#refraction_va_cl_r_txt').val());
  		  $('#refraction_va_l_comm').val($('#refraction_va_r_comm').val());

  		  $('#refraction_va_ua_l_pr_s').val($('#refraction_va_ua_r_pr_s').val());
  		  $('#refraction_va_ua_l_pr_i').val($('#refraction_va_ua_r_pr_i').val());
  		  $('#refraction_va_ua_l_pr_n').val($('#refraction_va_ua_r_pr_n').val());
  		  $('#refraction_va_ua_l_pr_t').val($('#refraction_va_ua_r_pr_t').val());

  		  if($('#refraction_va_ua_r_p').prop('checked') == true) {
			   $('#refraction_va_ua_l_p').prop('checked', true).parent().toggleClass('bg-theme');
			   $('.ua_l_txt').show();
			}
		 if($('#refraction_va_ua_r_p_2').prop('checked') == true) {
			   $('#refraction_va_ua_l_p_2').prop('checked', true).parent().toggleClass('bg-theme');
			   $('.ua_l2_txt').show();
			}  
  		 if($('#refraction_va_ph_r_p').prop('checked') == true) {
			   $('#refraction_va_ph_l_p').prop('checked', true).parent().toggleClass('bg-theme');
			   $('.ph_l_txt').show();
			} 
  		 if($('#refraction_va_ph_r_ni').prop('checked') == true) {
			   $('#refraction_va_ph_l_ni').prop('checked', true).parent().toggleClass('bg-theme');
			   $('.gls_l_txt').show();
			} 
		 if($('#refraction_va_gls_r_p').prop('checked') == true) {
		   $('#refraction_va_gls_l_p').prop('checked', true).parent().toggleClass('bg-theme');
		   $('.gls_l2_txt').show();
		} 
		if($('#refraction_va_gls_r_p_2').prop('checked') == true) {
		   $('#refraction_va_gls_l_p_2').prop('checked', true).parent().toggleClass('bg-theme');
		   $('.cl_l_txt').show();
		} 
		if($('#refraction_va_cl_r_p').prop('checked') == true) {
		   $('#refraction_va_cl_l_p').prop('checked', true).parent().toggleClass('bg-theme');
		   $('.cons_clr_l').show();
		}
  		  var radiosr1 = $('input[name=refraction_va_ua_r]');
  		  var radiosl1 = $('input[name=refraction_va_ua_l]');
  		  var vals1=$('input[name=refraction_va_ua_r]:checked').val();  		 
  		  if(radiosr1.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_ua_l').parent().removeClass('active');
		      radiosl1.filter('[value="'+vals1+'"]').prop('checked', true).parent().addClass('active');
		  }

		  var radiosr2 = $('input[name=refraction_va_ua_r_2]');
  		  var radiosl2 = $('input[name=refraction_va_ua_l_2]');
  		  var vals2=$('input[name=refraction_va_ua_r_2]:checked').val();  		 
  		  if(radiosr2.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_ua_l_2').parent().removeClass('active');
		      radiosl2.filter('[value="'+vals2+'"]').prop('checked', true).parent().addClass('active');
		  }
		  var radiosr3 = $('input[name=refraction_va_ph_r]');
  		  var radiosl3 = $('input[name=refraction_va_ph_l]');
  		  var vals3=$('input[name=refraction_va_ph_r]:checked').val();  		 
  		  if(radiosr3.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_ph_l').parent().removeClass('active');
		      radiosl3.filter('[value="'+vals3+'"]').prop('checked', true).parent().addClass('active');
		  }
		  var radiosr4 = $('input[name=refraction_va_gls_r]');
  		  var radiosl4 = $('input[name=refraction_va_gls_l]');
  		  var vals4=$('input[name=refraction_va_gls_r]:checked').val();  		 
  		  if(radiosr4.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_gls_l').parent().removeClass('active');
		      radiosl4.filter('[value="'+vals4+'"]').prop('checked', true).parent().addClass('active');
		  }
		  var radiosr5 = $('input[name=refraction_va_gls_r_2]');
  		  var radiosl5 = $('input[name=refraction_va_gls_l_2]');
  		  var vals5=$('input[name=refraction_va_gls_r_2]:checked').val();  		 
  		  if(radiosr5.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_gls_l_2').parent().removeClass('active');
		      radiosl5.filter('[value="'+vals5+'"]').prop('checked', true).parent().addClass('active');
		  }
		  var radiosr6 = $('input[name=refraction_va_cl_r]');
  		  var radiosl6 = $('input[name=refraction_va_cl_l]');
  		  var vals6=$('input[name=refraction_va_cl_r]:checked').val();  		 
  		  if(radiosr6.is(':checked') === true) 
  		  {
  		  	$('.refraction_va_cl_l').parent().removeClass('active');
		      radiosl6.filter('[value="'+vals6+'"]').prop('checked', true).parent().addClass('active');
		  }
	}

  	function refraction_km_ltr()
  	{
		$('#refraction_km_r_kh').val($('#refraction_km_l_kh').val());
		$('#refraction_km_r_kh_a').val($('#refraction_km_l_kh_a').val());
		$('#refraction_km_r_kv').val($('#refraction_km_l_kv').val());
		$('#refraction_km_r_kv_a').val($('#refraction_km_l_kv_a').val());
  	}
    function refraction_km_rtl()
    {
    	$('#refraction_km_l_kh').val($('#refraction_km_r_kh').val());
		$('#refraction_km_l_kh_a').val($('#refraction_km_r_kh_a').val());
		$('#refraction_km_l_kv').val($('#refraction_km_r_kv').val());
		$('#refraction_km_l_kv_a').val($('#refraction_km_r_kv_a').val());
    }

    function refraction_pgp_ltr(){
    	$('#refraction_pgp_r_dt_sph').val($('#refraction_pgp_l_dt_sph').val());
		$('#refraction_pgp_r_dt_cyl').val($('#refraction_pgp_l_dt_cyl').val());
		$('#refraction_pgp_r_dt_axis').val($('#refraction_pgp_l_dt_axis').val());
		$('#refraction_pgp_r_dt_vision').val($('#refraction_pgp_l_dt_vision').val());
		$('#refraction_pgp_r_ad_sph').val($('#refraction_pgp_l_ad_sph').val());
		$('#refraction_pgp_r_ad_cyl').val($('#refraction_pgp_l_ad_cyl').val());
		$('#refraction_pgp_r_ad_axis').val($('#refraction_pgp_l_ad_axis').val());
		$('#refraction_pgp_r_ad_vision').val($('#refraction_pgp_l_ad_vision').val());
		$('#refraction_pgp_r_nr_sph').val($('#refraction_pgp_l_nr_sph').val());
		$('#refraction_pgp_r_nr_cyl').val($('#refraction_pgp_l_nr_cyl').val());
		$('#refraction_pgp_r_nr_axis').val($('#refraction_pgp_l_nr_axis').val());
		$('#refraction_pgp_r_nr_vision').val($('#refraction_pgp_l_nr_vision').val());
		$('#refraction_pgp_r_lens').val($('#refraction_pgp_l_lens').val());
    }

     function refraction_pgp_rtl(){
    	$('#refraction_pgp_l_dt_sph').val($('#refraction_pgp_r_dt_sph').val());
		$('#refraction_pgp_l_dt_cyl').val($('#refraction_pgp_r_dt_cyl').val());
		$('#refraction_pgp_l_dt_axis').val($('#refraction_pgp_r_dt_axis').val());
		$('#refraction_pgp_l_dt_vision').val($('#refraction_pgp_r_dt_vision').val());
		$('#refraction_pgp_l_ad_sph').val($('#refraction_pgp_r_ad_sph').val());
		$('#refraction_pgp_l_ad_cyl').val($('#refraction_pgp_r_ad_cyl').val());
		$('#refraction_pgp_l_ad_axis').val($('#refraction_pgp_r_ad_axis').val());
		$('#refraction_pgp_l_ad_vision').val($('#refraction_pgp_r_ad_vision').val());
		$('#refraction_pgp_l_nr_sph').val($('#refraction_pgp_r_nr_sph').val());
		$('#refraction_pgp_l_nr_cyl').val($('#refraction_pgp_r_nr_cyl').val());
		$('#refraction_pgp_l_nr_axis').val($('#refraction_pgp_r_nr_axis').val());
		$('#refraction_pgp_l_nr_vision').val($('#refraction_pgp_r_nr_vision').val());
		$('#refraction_pgp_l_lens').val($('#refraction_pgp_r_lens').val());
    }

    function refraction_ar_ltr()
    {
    	$('#refraction_ar_r_dry_sph').val($('#refraction_ar_l_dry_sph').val());
		$('#refraction_ar_r_dry_cyl').val($('#refraction_ar_l_dry_cyl').val());
		$('#refraction_ar_r_dry_axis').val($('#refraction_ar_l_dry_axis').val());
		$('#refraction_ar_r_dd_sph').val($('#refraction_ar_l_dd_sph').val());
		$('#refraction_ar_r_dd_cyl').val($('#refraction_ar_l_dd_cyl').val());
		$('#refraction_ar_r_dd_axis').val($('#refraction_ar_l_dd_axis').val());
		$('#refraction_ar_r_b1_sph').val($('#refraction_ar_l_b1_sph').val());
		$('#refraction_ar_r_b1_cyl').val($('#refraction_ar_l_b1_cyl').val());
		$('#refraction_ar_r_b1_axis').val($('#refraction_ar_l_b1_axis').val());
		$('#refraction_ar_r_b2_sph').val($('#refraction_ar_l_b2_sph').val());
		$('#refraction_ar_r_b2_cyl').val($('#refraction_ar_l_b2_cyl').val());
		$('#refraction_ar_r_b2_axis').val($('#refraction_ar_l_b2_axis').val());
    }

	function refraction_ar_ltr_plated()
    {
    	$('#refraction_ar_r_dry_sph_plated').val($('#refraction_ar_l_dry_sph_plated').val());
		$('#refraction_ar_r_dry_cyl_plated').val($('#refraction_ar_l_dry_cyl_plated').val());
		$('#refraction_ar_r_dry_axis_plated').val($('#refraction_ar_l_dry_axis_plated').val());
		$('#refraction_ar_r_dd_sph_plated').val($('#refraction_ar_l_dd_sph_plated').val());
		$('#refraction_ar_r_dd_cyl_plated').val($('#refraction_ar_l_dd_cyl_plated').val());
		$('#refraction_ar_r_dd_axis_plated').val($('#refraction_ar_l_dd_axis_plated').val());
		// $('#refraction_ar_r_b1_sph_plated').val($('#refraction_ar_l_b1_sph_plated').val());
		// $('#refraction_ar_r_b1_cyl_plated').val($('#refraction_ar_l_b1_cyl_plated').val());
		// $('#refraction_ar_r_b1_axis_plated').val($('#refraction_ar_l_b1_axis_plated').val());
		// $('#refraction_ar_r_b2_sph_plated').val($('#refraction_ar_l_b2_sph_plated').val());
		// $('#refraction_ar_r_b2_cyl_plated').val($('#refraction_ar_l_b2_cyl_plated').val());
		// $('#refraction_ar_r_b2_axis_plated').val($('#refraction_ar_l_b2_axis_plated').val());
    }
    // function refraction_ar_rtl()
    // {
    // 	$('#refraction_ar_l_dry_sph').val($('#refraction_ar_r_dry_sph').val());
	// 	$('#refraction_ar_l_dry_cyl').val($('#refraction_ar_r_dry_cyl').val());
	// 	$('#refraction_ar_l_dry_axis').val($('#refraction_ar_r_dry_axis').val());
	// 	$('#refraction_ar_l_dd_sph').val($('#refraction_ar_r_dd_sph').val());
	// 	$('#refraction_ar_l_dd_cyl').val($('#refraction_ar_r_dd_cyl').val());
	// 	$('#refraction_ar_l_dd_axis').val($('#refraction_ar_r_dd_axis').val());
	// 	$('#refraction_ar_l_b1_sph').val($('#refraction_ar_r_b1_sph').val());
	// 	$('#refraction_ar_l_b1_cyl').val($('#refraction_ar_r_b1_cyl').val());
	// 	$('#refraction_ar_l_b1_axis').val($('#refraction_ar_r_b1_axis').val());
	// 	$('#refraction_ar_l_b2_sph').val($('#refraction_ar_r_b2_sph').val());
	// 	$('#refraction_ar_l_b2_cyl').val($('#refraction_ar_r_b2_cyl').val());
	// 	$('#refraction_ar_l_b2_axis').val($('#refraction_ar_r_b2_axis').val());
    // }
    function refraction_dry_ref_ltr()
    {
    	$('#refraction_dry_ref_r_dt_sph').val($('#refraction_dry_ref_l_dt_sph').val());
		$('#refraction_dry_ref_r_dt_cyl').val($('#refraction_dry_ref_l_dt_cyl').val());
		$('#refraction_dry_ref_r_dt_axis').val($('#refraction_dry_ref_l_dt_axis').val());
		$('#refraction_dry_ref_r_dt_vision').val($('#refraction_dry_ref_l_dt_vision').val());
		$('#refraction_dry_ref_r_ad_sph').val($('#refraction_dry_ref_l_ad_sph').val());
		$('#refraction_dry_ref_r_ad_cyl').val($('#refraction_dry_ref_l_ad_cyl').val());
		$('#refraction_dry_ref_r_ad_axis').val($('#refraction_dry_ref_l_ad_axis').val());
		$('#refraction_dry_ref_r_ad_vision').val($('#refraction_dry_ref_l_ad_vision').val());
		$('#refraction_dry_ref_r_nr_sph').val($('#refraction_dry_ref_l_nr_sph').val());
		$('#refraction_dry_ref_r_nr_cyl').val($('#refraction_dry_ref_l_nr_cyl').val());
		$('#refraction_dry_ref_r_nr_axis').val($('#refraction_dry_ref_l_nr_axis').val());
		$('#refraction_dry_ref_r_nr_vision').val($('#refraction_dry_ref_l_nr_vision').val());
		$('#refraction_dry_ref_r_comm').val($('#refraction_dry_ref_l_comm').val());
    }


     function refraction_dry_ref_rtl()
    {
    	$('#refraction_dry_ref_l_dt_sph').val($('#refraction_dry_ref_r_dt_sph').val());
		$('#refraction_dry_ref_l_dt_cyl').val($('#refraction_dry_ref_r_dt_cyl').val());
		$('#refraction_dry_ref_l_dt_axis').val($('#refraction_dry_ref_r_dt_axis').val());
		$('#refraction_dry_ref_l_dt_vision').val($('#refraction_dry_ref_r_dt_vision').val());
		$('#refraction_dry_ref_l_ad_sph').val($('#refraction_dry_ref_r_ad_sph').val());
		$('#refraction_dry_ref_l_ad_cyl').val($('#refraction_dry_ref_r_ad_cyl').val());
		$('#refraction_dry_ref_l_ad_axis').val($('#refraction_dry_ref_r_ad_axis').val());
		$('#refraction_dry_ref_l_ad_vision').val($('#refraction_dry_ref_r_ad_vision').val());
		$('#refraction_dry_ref_l_nr_sph').val($('#refraction_dry_ref_r_nr_sph').val());
		$('#refraction_dry_ref_l_nr_cyl').val($('#refraction_dry_ref_r_nr_cyl').val());
		$('#refraction_dry_ref_l_nr_axis').val($('#refraction_dry_ref_r_nr_axis').val());
		$('#refraction_dry_ref_l_nr_vision').val($('#refraction_dry_ref_r_nr_vision').val());
		$('#refraction_dry_ref_l_comm').val($('#refraction_dry_ref_r_comm').val());
    }
   function refraction_ref_dtd_ltr()
   {
   		$('#refraction_ref_dtd_r_dt_sph').val($('#refraction_ref_dtd_l_dt_sph').val());
		$('#refraction_ref_dtd_r_dt_cyl').val($('#refraction_ref_dtd_l_dt_cyl').val());
		$('#refraction_ref_dtd_r_dt_axis').val($('#refraction_ref_dtd_l_dt_axis').val());
		$('#refraction_ref_dtd_r_dt_vision').val($('#refraction_ref_dtd_l_dt_vision').val());
		$('#refraction_ref_dtd_r_ad_sph').val($('#refraction_ref_dtd_l_ad_sph').val());
		$('#refraction_ref_dtd_r_ad_cyl').val($('#refraction_ref_dtd_l_ad_cyl').val());
		$('#refraction_ref_dtd_r_ad_axis').val($('#refraction_ref_dtd_l_ad_axis').val());
		$('#refraction_ref_dtd_r_ad_vision').val($('#refraction_ref_dtd_l_ad_vision').val());
		$('#refraction_ref_dtd_r_nr_sph').val($('#refraction_ref_dtd_l_nr_sph').val());
		$('#refraction_ref_dtd_r_nr_cyl').val($('#refraction_ref_dtd_l_nr_cyl').val());
		$('#refraction_ref_dtd_r_nr_axis').val($('#refraction_ref_dtd_l_nr_axis').val());
		$('#refraction_ref_dtd_r_nr_vision').val($('#refraction_ref_dtd_l_nr_vision').val());
		$('#refraction_ref_dtd_r_du').val($('#refraction_ref_dtd_l_du').val());
		$('#refraction_ref_dtd_r_comm').val($('#refraction_ref_dtd_l_comm').val());
   }
   function refraction_ref_dtd_rtl()
   {
   	   	$('#refraction_ref_dtd_l_dt_sph').val($('#refraction_ref_dtd_r_dt_sph').val());
		$('#refraction_ref_dtd_l_dt_cyl').val($('#refraction_ref_dtd_r_dt_cyl').val());
		$('#refraction_ref_dtd_l_dt_axis').val($('#refraction_ref_dtd_r_dt_axis').val());
		$('#refraction_ref_dtd_l_dt_vision').val($('#refraction_ref_dtd_r_dt_vision').val());
		$('#refraction_ref_dtd_l_ad_sph').val($('#refraction_ref_dtd_r_ad_sph').val());
		$('#refraction_ref_dtd_l_ad_cyl').val($('#refraction_ref_dtd_r_ad_cyl').val());
		$('#refraction_ref_dtd_l_ad_axis').val($('#refraction_ref_dtd_r_ad_axis').val());
		$('#refraction_ref_dtd_l_ad_vision').val($('#refraction_ref_dtd_r_ad_vision').val());
		$('#refraction_ref_dtd_l_nr_sph').val($('#refraction_ref_dtd_r_nr_sph').val());
		$('#refraction_ref_dtd_l_nr_cyl').val($('#refraction_ref_dtd_r_nr_cyl').val());
		$('#refraction_ref_dtd_l_nr_axis').val($('#refraction_ref_dtd_r_nr_axis').val());
		$('#refraction_ref_dtd_l_nr_vision').val($('#refraction_ref_dtd_r_nr_vision').val());
		$('#refraction_ref_dtd_l_du').val($('#refraction_ref_dtd_r_du').val());
		$('#refraction_ref_dtd_l_comm').val($('#refraction_ref_dtd_r_comm').val());
   }

   function refraction_rtnp_ltr()
   {
   	$('#refraction_rtnp_r_t').val($('#refraction_rtnp_l_t').val());
	$('#refraction_rtnp_r_l').val($('#refraction_rtnp_l_l').val());
	$('#refraction_rtnp_r_r').val($('#refraction_rtnp_l_r').val());
	$('#refraction_rtnp_r_b').val($('#refraction_rtnp_l_b').val());
	$('#refraction_rtnp_r_va').val($('#refraction_rtnp_l_va').val());
	$('#refraction_rtnp_r_ha').val($('#refraction_rtnp_l_ha').val());
	$('#refraction_rtnp_r_at_dis').val($('#refraction_rtnp_l_at_dis').val());
	$('#refraction_rtnp_r_du').val($('#refraction_rtnp_l_du').val());
	$('#refraction_rtnp_r_comm').val($('#refraction_rtnp_l_comm').val());
   }
    function refraction_rtnp_rtl()
   {
   	$('#refraction_rtnp_l_t').val($('#refraction_rtnp_r_t').val());
	$('#refraction_rtnp_l_l').val($('#refraction_rtnp_r_l').val());
	$('#refraction_rtnp_l_r').val($('#refraction_rtnp_r_r').val());
	$('#refraction_rtnp_l_b').val($('#refraction_rtnp_r_b').val());
	$('#refraction_rtnp_l_va').val($('#refraction_rtnp_r_va').val());
	$('#refraction_rtnp_l_ha').val($('#refraction_rtnp_r_ha').val());
	$('#refraction_rtnp_l_at_dis').val($('#refraction_rtnp_r_at_dis').val());
	$('#refraction_rtnp_l_du').val($('#refraction_rtnp_r_du').val());
	$('#refraction_rtnp_l_comm').val($('#refraction_rtnp_r_comm').val());
   }
   function refraction_pmt_ltr(){
   	$('#refraction_pmt_r_dt_sph').val($('#refraction_pmt_l_dt_sph').val());
	$('#refraction_pmt_r_dt_cyl').val($('#refraction_pmt_l_dt_cyl').val());
	$('#refraction_pmt_r_dt_axis').val($('#refraction_pmt_l_dt_axis').val());
	$('#refraction_pmt_r_dt_vision').val($('#refraction_pmt_l_dt_vision').val());
	$('#refraction_pmt_r_ad_sph').val($('#refraction_pmt_l_ad_sph').val());
	$('#refraction_pmt_r_ad_cyl').val($('#refraction_pmt_l_ad_cyl').val());
	$('#refraction_pmt_r_ad_axis').val($('#refraction_pmt_l_ad_axis').val());
	$('#refraction_pmt_r_ad_vision').val($('#refraction_pmt_l_ad_vision').val());
	$('#refraction_pmt_r_nr_sph').val($('#refraction_pmt_l_nr_sph').val());
	$('#refraction_pmt_r_nr_cyl').val($('#refraction_pmt_l_nr_cyl').val());
	$('#refraction_pmt_r_nr_axis').val($('#refraction_pmt_l_nr_axis').val());
	$('#refraction_pmt_r_nr_vision').val($('#refraction_pmt_l_nr_vision').val());
   }

    function refraction_pmt_rtl()
    {
   	$('#refraction_pmt_l_dt_sph').val($('#refraction_pmt_r_dt_sph').val());
	$('#refraction_pmt_l_dt_cyl').val($('#refraction_pmt_r_dt_cyl').val());
	$('#refraction_pmt_l_dt_axis').val($('#refraction_pmt_r_dt_axis').val());
	$('#refraction_pmt_l_dt_vision').val($('#refraction_pmt_r_dt_vision').val());
	$('#refraction_pmt_l_ad_sph').val($('#refraction_pmt_r_ad_sph').val());
	$('#refraction_pmt_l_ad_cyl').val($('#refraction_pmt_r_ad_cyl').val());
	$('#refraction_pmt_l_ad_axis').val($('#refraction_pmt_r_ad_axis').val());
	$('#refraction_pmt_l_ad_vision').val($('#refraction_pmt_r_ad_vision').val());
	$('#refraction_pmt_l_nr_sph').val($('#refraction_pmt_r_nr_sph').val());
	$('#refraction_pmt_l_nr_cyl').val($('#refraction_pmt_r_nr_cyl').val());
	$('#refraction_pmt_l_nr_axis').val($('#refraction_pmt_r_nr_axis').val());
	$('#refraction_pmt_l_nr_vision').val($('#refraction_pmt_r_nr_vision').val());
   }
   function refraction_gps_ltr()
   {
   	$('#refraction_gps_r_dt_sph').val($('#refraction_gps_l_dt_sph').val());
	$('#refraction_gps_r_dt_cyl').val($('#refraction_gps_l_dt_cyl').val());
	$('#refraction_gps_r_dt_axis').val($('#refraction_gps_l_dt_axis').val());
	$('#refraction_gps_r_dt_vision').val($('#refraction_gps_l_dt_vision').val());
	$('#refraction_gps_r_ad_sph').val($('#refraction_gps_l_ad_sph').val());
	$('#refraction_gps_r_ad_cyl').val($('#refraction_gps_l_ad_cyl').val());
	$('#refraction_gps_r_ad_axis').val($('#refraction_gps_l_ad_axis').val());
	$('#refraction_gps_r_ad_vision').val($('#refraction_gps_l_ad_vision').val());
	$('#refraction_gps_r_nr_sph').val($('#refraction_gps_l_nr_sph').val());
	$('#refraction_gps_r_nr_cyl').val($('#refraction_gps_l_nr_cyl').val());
	$('#refraction_gps_r_nr_axis').val($('#refraction_gps_l_nr_axis').val());
	$('#refraction_gps_r_nr_vision').val($('#refraction_gps_l_nr_vision').val());
	$('#refraction_gps_r_tol').val($('#refraction_gps_l_tol').val());
	$('#refraction_gps_r_ipd').val($('#refraction_gps_l_ipd').val());
	$('#refraction_gps_r_lns_mat').val($('#refraction_gps_l_lns_mat').val());
	$('#refraction_gps_r_lns_tnt').val($('#refraction_gps_l_lns_tnt').val());
	$('#refraction_gps_r_fm').val($('#refraction_gps_l_fm').val());
	$('#refraction_gps_r_advs').val($('#refraction_gps_l_advs').val());
   }

   function refraction_gps_rtl()
   {
   	$('#refraction_gps_l_dt_sph').val($('#refraction_gps_r_dt_sph').val());
	$('#refraction_gps_l_dt_cyl').val($('#refraction_gps_r_dt_cyl').val());
	$('#refraction_gps_l_dt_axis').val($('#refraction_gps_r_dt_axis').val());
	$('#refraction_gps_l_dt_vision').val($('#refraction_gps_r_dt_vision').val());
	$('#refraction_gps_l_ad_sph').val($('#refraction_gps_r_ad_sph').val());
	$('#refraction_gps_l_ad_cyl').val($('#refraction_gps_r_ad_cyl').val());
	$('#refraction_gps_l_ad_axis').val($('#refraction_gps_r_ad_axis').val());
	$('#refraction_gps_l_ad_vision').val($('#refraction_gps_r_ad_vision').val());
	$('#refraction_gps_l_nr_sph').val($('#refraction_gps_r_nr_sph').val());
	$('#refraction_gps_l_nr_cyl').val($('#refraction_gps_r_nr_cyl').val());
	$('#refraction_gps_l_nr_axis').val($('#refraction_gps_r_nr_axis').val());
	$('#refraction_gps_l_nr_vision').val($('#refraction_gps_r_nr_vision').val());
	$('#refraction_gps_l_tol').val($('#refraction_gps_r_tol').val());
	$('#refraction_gps_l_ipd').val($('#refraction_gps_r_ipd').val());
	$('#refraction_gps_l_lns_mat').val($('#refraction_gps_r_lns_mat').val());
	$('#refraction_gps_l_lns_tnt').val($('#refraction_gps_r_lns_tnt').val());
	$('#refraction_gps_l_fm').val($('#refraction_gps_r_fm').val());
	$('#refraction_gps_l_advs').val($('#refraction_gps_r_advs').val());
   }

   function refraction_itgp_ltr()
   {
   	$('#refraction_itgp_r_dt_sph').val($('#refraction_itgp_l_dt_sph').val());
	$('#refraction_itgp_r_dt_cyl').val($('#refraction_itgp_l_dt_cyl').val());
	$('#refraction_itgp_r_dt_axis').val($('#refraction_itgp_l_dt_axis').val());
	$('#refraction_itgp_r_dt_vision').val($('#refraction_itgp_l_dt_vision').val());
	$('#refraction_itgp_r_ad_sph').val($('#refraction_itgp_l_ad_sph').val());
	$('#refraction_itgp_r_ad_cyl').val($('#refraction_itgp_l_ad_cyl').val());
	$('#refraction_itgp_r_ad_axis').val($('#refraction_itgp_l_ad_axis').val());
	$('#refraction_itgp_r_ad_vision').val($('#refraction_itgp_l_ad_vision').val());
	$('#refraction_itgp_r_nr_sph').val($('#refraction_itgp_l_nr_sph').val());
	$('#refraction_itgp_r_nr_cyl').val($('#refraction_itgp_l_nr_cyl').val());
	$('#refraction_itgp_r_nr_axis').val($('#refraction_itgp_l_nr_axis').val());
	$('#refraction_itgp_r_nr_vision').val($('#refraction_itgp_l_nr_vision').val());
	$('#refraction_itgp_r_tol').val($('#refraction_itgp_l_tol').val());
	$('#refraction_itgp_r_ipd').val($('#refraction_itgp_l_ipd').val());
	$('#refraction_itgp_r_lns_mat').val($('#refraction_itgp_l_lns_mat').val());
	$('#refraction_itgp_r_lns_tnt').val($('#refraction_itgp_l_lns_tnt').val());
	$('#refraction_itgp_r_fm').val($('#refraction_itgp_l_fm').val());
	$('#refraction_itgp_r_advs').val($('#refraction_itgp_l_advs').val());
   }

   function refraction_itgp_rtl()
   {
   	$('#refraction_itgp_l_dt_sph').val($('#refraction_itgp_r_dt_sph').val());
	$('#refraction_itgp_l_dt_cyl').val($('#refraction_itgp_r_dt_cyl').val());
	$('#refraction_itgp_l_dt_axis').val($('#refraction_itgp_r_dt_axis').val());
	$('#refraction_itgp_l_dt_vision').val($('#refraction_itgp_r_dt_vision').val());
	$('#refraction_itgp_l_ad_sph').val($('#refraction_itgp_r_ad_sph').val());
	$('#refraction_itgp_l_ad_cyl').val($('#refraction_itgp_r_ad_cyl').val());
	$('#refraction_itgp_l_ad_axis').val($('#refraction_itgp_r_ad_axis').val());
	$('#refraction_itgp_l_ad_vision').val($('#refraction_itgp_r_ad_vision').val());
	$('#refraction_itgp_l_nr_sph').val($('#refraction_itgp_r_nr_sph').val());
	$('#refraction_itgp_l_nr_cyl').val($('#refraction_itgp_r_nr_cyl').val());
	$('#refraction_itgp_l_nr_axis').val($('#refraction_itgp_r_nr_axis').val());
	$('#refraction_itgp_l_nr_vision').val($('#refraction_itgp_r_nr_vision').val());
	$('#refraction_itgp_l_tol').val($('#refraction_itgp_r_tol').val());
	$('#refraction_itgp_l_ipd').val($('#refraction_itgp_r_ipd').val());
	$('#refraction_itgp_l_lns_mat').val($('#refraction_itgp_r_lns_mat').val());
	$('#refraction_itgp_l_lns_tnt').val($('#refraction_itgp_r_lns_tnt').val());
	$('#refraction_itgp_l_fm').val($('#refraction_itgp_r_fm').val());
	$('#refraction_itgp_l_advs').val($('#refraction_itgp_r_advs').val());
   }

   function refraction_clp_ltr()
   {
   	 $('#refraction_clp_r_bc').val($('#refraction_clp_l_bc').val());
	 $('#refraction_clp_r_dia').val($('#refraction_clp_l_dia').val());
	 $('#refraction_clp_r_sph').val($('#refraction_clp_l_sph').val());
	 $('#refraction_clp_r_cyl').val($('#refraction_clp_l_cyl').val());
	 $('#refraction_clp_r_axis').val($('#refraction_clp_l_axis').val());
	 $('#refraction_clp_r_add').val($('#refraction_clp_l_add').val());
	 $('#refraction_clp_r_rv_date').val($('#refraction_clp_l_rv_date').val());
	 $('#refraction_clp_r_clr').val($('#refraction_clp_l_clr').val());
	 $('#refraction_clp_r_tp').val($('#refraction_clp_l_tp').val());
	 $('#refraction_clp_r_advice').val($('#refraction_clp_l_advice').val());
   }

   function refraction_clp_rtl()
   {
   	 $('#refraction_clp_l_bc').val($('#refraction_clp_r_bc').val());
	 $('#refraction_clp_l_dia').val($('#refraction_clp_r_dia').val());
	 $('#refraction_clp_l_sph').val($('#refraction_clp_r_sph').val());
	 $('#refraction_clp_l_cyl').val($('#refraction_clp_r_cyl').val());
	 $('#refraction_clp_l_axis').val($('#refraction_clp_r_axis').val());
	 $('#refraction_clp_l_add').val($('#refraction_clp_r_add').val());
	 $('#refraction_clp_l_rv_date').val($('#refraction_clp_r_rv_date').val());
	 $('#refraction_clp_l_clr').val($('#refraction_clp_r_clr').val());
	 $('#refraction_clp_l_tp').val($('#refraction_clp_r_tp').val());
	 $('#refraction_clp_l_advice').val($('#refraction_clp_r_advice').val());
   }

   	function refraction_col_vis_ltr(){
  		$('#refraction_col_vis_r').val($('#refraction_col_vis_l').val());
  	}
  	function refraction_col_vis_rtl(){
  		$('#refraction_col_vis_l').val($('#refraction_col_vis_r').val());
  	}

  	function refraction_contra_sens_ltr()
  	{
  		  var radiosl = $('input[name=refraction_contra_sens_l]');
  		  var radiosr = $('input[name=refraction_contra_sens_r]');
  		  var vals=$('input[name=refraction_contra_sens_l]:checked').val();
  		  if(radiosl.is(':checked') === true) 
  		  {
  		  	$('.refraction_contra_sens_r').parent().removeClass('active');
		      radiosr.filter('[value="'+vals+'"]').prop('checked', true).parent().addClass('active');
		  }
  	}
  	function refraction_contra_sens_rtl()
  	{
  		  var radiosr = $('input[name=refraction_contra_sens_r]');
  		  var radiosl = $('input[name=refraction_contra_sens_l]');
  		  var vals=$('input[name=refraction_contra_sens_r]:checked').val();
  		  if(radiosr.is(':checked') === true) 
  		  {
  		  	$('.refraction_contra_sens_l').parent().removeClass('active');
		      radiosl.filter('[value="'+vals+'"]').prop('checked', true).parent().addClass('active');
		  }
  	}  	

  	function refraction_intra_press_ltr(){
  		$('#myRange_r').val($('#myRange_l').val());
  		$('#range_r').val($('#range_l').val());
  		$('#refraction_intra_press_r_comm').val($('#refraction_intra_press_l_comm').val());
  		$('#refraction_intra_press_r_time').val($('#refraction_intra_press_l_time').val());
  	}
    function refraction_intra_press_rtl(){
    	$('#myRange_l').val($('#myRange_r').val());
 		$('#range_l').val($('#range_r').val());
 		$('#refraction_intra_press_l_comm').val($('#refraction_intra_press_r_comm').val());
 		$('#refraction_intra_press_l_time').val($('#refraction_intra_press_r_time').val());
    }

  	function refraction_ortho_ltr(){
  		$('#refraction_ortho_r').val($('#refraction_ortho_l').val());
  	}
    function refraction_ortho_rtl(){
    	$('#refraction_ortho_l').val($('#refraction_ortho_r').val());
    }

   $(document).ready(function(){
	var refraction_va_ua_l_p = '<?php echo $refrtsn_vl_act['refraction_va_ua_l_p'];?>';
	var refraction_va_ua_r_p = '<?php echo $refrtsn_vl_act['refraction_va_ua_r_p'];?>';
	var refraction_va_ua_l_p_2 = '<?php echo $refrtsn_vl_act['refraction_va_ua_l_p_2'];?>';
	var refraction_va_ua_r_p_2 = '<?php echo $refrtsn_vl_act['refraction_va_ua_r_p_2'];?>';
	var refraction_va_ph_l_p = '<?php echo $refrtsn_vl_act['refraction_va_ph_l_p'];?>';
	var refraction_va_ph_l_ni = '<?php echo $refrtsn_vl_act['refraction_va_ph_l_ni'];?>';
	var refraction_va_ph_r_p = '<?php echo $refrtsn_vl_act['refraction_va_ph_r_p'];?>';
	var refraction_va_ph_r_ni = '<?php echo $refrtsn_vl_act['refraction_va_ph_r_ni'];?>';
	var refraction_va_gls_l_p = '<?php echo $refrtsn_vl_act['refraction_va_gls_l_p'];?>';
	var refraction_va_gls_r_p = '<?php echo $refrtsn_vl_act['refraction_va_gls_r_p'];?>';
	var refraction_va_gls_l_p_2 = '<?php echo $refrtsn_vl_act['refraction_va_gls_l_p_2'];?>';
	var refraction_va_gls_r_p_2 = '<?php echo $refrtsn_vl_act['refraction_va_gls_r_p_2'];?>';
	var refraction_va_cl_l_p = '<?php echo $refrtsn_vl_act['refraction_va_cl_l_p'];?>';
	var refraction_va_cl_r_p = '<?php echo $refrtsn_vl_act['refraction_va_cl_r_p'];?>';
	var refraction_itgp_ad_check = '<?php echo $refrtsn_inter_glass['refraction_itgp_ad_check'];?>';
	var refraction_gps_ad_check = '<?php echo $refrtsn_glassp['refraction_gps_ad_check'];?>';
	var refraction_va_ua_l ='<?php echo $refrtsn_vl_act['refraction_va_ua_l'];?>';
	var refraction_va_ua_r ='<?php echo $refrtsn_vl_act['refraction_va_ua_r'];?>';
	var refraction_va_ua_l_2 ='<?php echo $refrtsn_vl_act['refraction_va_ua_l_2'];?>';
	var refraction_va_ua_r_2 ='<?php echo $refrtsn_vl_act['refraction_va_ua_r_2'];?>';
	var refraction_va_ph_l ='<?php echo $refrtsn_vl_act['refraction_va_ph_l'];?>';
	var refraction_va_ph_r ='<?php echo $refrtsn_vl_act['refraction_va_ph_r'];?>';
	var refraction_va_gls_l ='<?php echo $refrtsn_vl_act['refraction_va_gls_l'];?>';
	var refraction_va_gls_r ='<?php echo $refrtsn_vl_act['refraction_va_gls_r'];?>';
	var refraction_va_gls_l_2 ='<?php echo $refrtsn_vl_act['refraction_va_gls_l_2'];?>';
	var refraction_va_gls_r_2 ='<?php echo $refrtsn_vl_act['refraction_va_gls_r_2'];?>';
	var refraction_va_cl_l ='<?php echo $refrtsn_vl_act['refraction_va_cl_l'];?>';
	var refraction_va_cl_r ='<?php echo $refrtsn_vl_act['refraction_va_cl_r'];?>';
	var refraction_contra_sens_l ='<?php echo $refrtsn_const_sen['refraction_contra_sens_l'];?>';
	var refraction_contra_sens_r ='<?php echo $refrtsn_const_sen['refraction_contra_sens_r'];?>';

		if(refraction_va_ua_l !='')
			$('.ua_l_txt').show();
		if(refraction_va_ua_r !='')
		    $('.ua_r_txt').show();
		if(refraction_va_ua_l_2 !='')
			$('.ua_l2_txt').show();
		if(refraction_va_ua_r_2 !='')
			$('.ua_r2_txt').show();
		if(refraction_va_ph_l !='')
			$('.ph_l_txt').show();
		if(refraction_va_ph_r !='')
			$('.ph_r_txt').show();
		if(refraction_va_gls_l !='')
			$('.gls_l_txt').show();
		if(refraction_va_gls_r !='')
			$('.gls_r_txt').show();
		if(refraction_va_gls_l_2 !='')
			$('.gls_l2_txt').show();
		if(refraction_va_gls_r_2 !='')
			$('.gls_r2_txt').show();
		if(refraction_va_cl_l !='')
			$('.cl_l_txt').show();
		if(refraction_va_cl_r !='')
		    $('.cl_r_txt').show();

		if(refraction_va_ua_l_p=='P'){
	      $('#refraction_va_ua_l_p').parent().toggleClass('bg-theme');
	       $('#refraction_va_ua_l_p').prop('checked', true);
	    }
	    if(refraction_va_ua_r_p=='P'){
	      $('#refraction_va_ua_r_p').parent().toggleClass('bg-theme');
	      $('#refraction_va_ua_r_p').prop('checked', true);
	    }
	    if(refraction_va_ua_l_p_2=='P'){
	      $('#refraction_va_ua_l_p_2').parent().toggleClass('bg-theme');
	      $('#refraction_va_ua_l_p_2').prop('checked', true);
	    }
	    if(refraction_va_ua_r_p_2=='P'){
	      $('#refraction_va_ua_r_p_2').parent().toggleClass('bg-theme');
	      $('#refraction_va_ua_r_p_2').prop('checked', true);
	    }
	    if(refraction_va_ph_l_p=='P'){
	      $('#refraction_va_ph_l_p').parent().toggleClass('bg-theme');
	      $('#refraction_va_ph_l_p').prop('checked', true);
	    }
	    if(refraction_va_ph_l_ni=='NI'){
	      $('#refraction_va_ph_l_ni').parent().toggleClass('bg-theme');
	      $('#refraction_va_ph_l_ni').prop('checked', true);
	    }
	    if(refraction_va_ph_r_p=='P'){
	      $('#refraction_va_ph_r_p').parent().toggleClass('bg-theme');
	      $('#refraction_va_ph_r_p').prop('checked', true);
	    }
	    if(refraction_va_ph_r_ni=='NI'){
	      $('#refraction_va_ph_r_ni').parent().toggleClass('bg-theme');
	      $('#refraction_va_ph_r_ni').prop('checked', true);
	    }

	    if(refraction_va_gls_l_p=='P'){
	      $('#refraction_va_gls_l_p').parent().toggleClass('bg-theme');
	      $('#refraction_va_gls_l_p').prop('checked', true);
	    }
	    if(refraction_va_gls_r_p=='P'){
	      $('#refraction_va_gls_r_p').parent().toggleClass('bg-theme');
	      $('#refraction_va_gls_r_p').prop('checked', true);
	    }
	    if(refraction_va_gls_l_p_2=='P'){
	      $('#refraction_va_gls_l_p_2').parent().toggleClass('bg-theme');
	      $('#refraction_va_gls_l_p_2').prop('checked', true);
	    }
	    if(refraction_va_gls_r_p_2=='P'){
	      $('#refraction_va_gls_r_p_2').parent().toggleClass('bg-theme');
	      $('#refraction_va_gls_r_p_2').prop('checked', true);
	    }
	   if(refraction_va_cl_l_p=='P'){
	      $('#refraction_va_cl_l_p').parent().toggleClass('bg-theme');
	      $('#refraction_va_cl_l_p').prop('checked', true);
	    }
	    if(refraction_va_cl_r_p=='P'){
	      $('#refraction_va_cl_r_p').parent().toggleClass('bg-theme');
	      $('#refraction_va_cl_r_p').prop('checked', true);
	    }

	    if(refraction_itgp_ad_check==1){
	      $('#refraction_itgp_ad_check').parent().toggleClass('bg-theme');
	      $('#refraction_itgp_ad_check').prop('checked', true);
	    }
	    if(refraction_gps_ad_check==1){
	      $('#refraction_gps_ad_check').parent().toggleClass('bg-theme');
	      $('#refraction_gps_ad_check').prop('checked', true);
	    }

	    var radios1 = $('input[name=refraction_va_ua_l]');
		radios1.filter('[value="'+refraction_va_ua_l+'"]').prop('checked', true).parent().addClass('active');
		var radios2 = $('input[name=refraction_va_ua_r]');
		radios2.filter('[value="'+refraction_va_ua_r+'"]').prop('checked', true).parent().addClass('active');
		var radios3 = $('input[name=refraction_va_ua_l_2]');
		radios3.filter('[value="'+refraction_va_ua_l_2+'"]').prop('checked', true).parent().addClass('active');
		var radios4 = $('input[name=refraction_va_ua_r_2]');
		radios4.filter('[value="'+refraction_va_ua_r_2+'"]').prop('checked', true).parent().addClass('active');
		var radios5 = $('input[name=refraction_va_ph_l]');
		radios5.filter('[value="'+refraction_va_ph_l+'"]').prop('checked', true).parent().addClass('active');
		var radios6 = $('input[name=refraction_va_ph_r]');
		radios6.filter('[value="'+refraction_va_ph_r+'"]').prop('checked', true).parent().addClass('active');
		var radios7 = $('input[name=refraction_va_gls_l]');
		radios7.filter('[value="'+refraction_va_gls_l+'"]').prop('checked', true).parent().addClass('active');
		var radios8 = $('input[name=refraction_va_gls_r]');
		radios8.filter('[value="'+refraction_va_gls_r+'"]').prop('checked', true).parent().addClass('active');
		var radios9 = $('input[name=refraction_va_gls_l_2]');
		radios9.filter('[value="'+refraction_va_gls_l_2+'"]').prop('checked', true).parent().addClass('active');
		var radios10 = $('input[name=refraction_va_gls_r_2]');
		radios10.filter('[value="'+refraction_va_gls_r_2+'"]').prop('checked', true).parent().addClass('active');
		var radios11 = $('input[name=refraction_va_cl_l]');
		radios11.filter('[value="'+refraction_va_cl_l+'"]').prop('checked', true).parent().addClass('active');
		var radios12 = $('input[name=refraction_va_cl_r]');
		radios12.filter('[value="'+refraction_va_cl_r+'"]').prop('checked', true).parent().addClass('active');
		var radios13 = $('input[name=refraction_contra_sens_l]');
		radios13.filter('[value="'+refraction_contra_sens_l+'"]').prop('checked', true).parent().addClass('active');
  		var radios14 = $('input[name=refraction_contra_sens_r]');
		radios14.filter('[value="'+refraction_contra_sens_r+'"]').prop('checked', true).parent().addClass('active');
	});


	function cpoy_to_glass_pres(tab_name)
	{
		  $('#refraction_gps_l_dt_sph').val($('#'+tab_name+'_l_dt_sph').val());
		  $('#refraction_gps_l_dt_cyl').val($('#'+tab_name+'_l_dt_cyl').val());
		  $('#refraction_gps_l_dt_axis').val($('#'+tab_name+'_l_dt_axis').val());
		  $('#refraction_gps_l_dt_vision').val($('#'+tab_name+'_l_dt_vision').val());
		  $('#refraction_gps_l_ad_sph').val($('#'+tab_name+'_l_nr_sph').val());
		  $('#refraction_gps_l_ad_vision').val($('#'+tab_name+'_l_ad_vision').val());
		  $('#refraction_gps_l_nr_sph').val($('#'+tab_name+'_l_nr_sph').val());
		  $('#refraction_gps_l_nr_cyl').val($('#'+tab_name+'_l_nr_cyl').val());
		  $('#refraction_gps_l_nr_axis').val($('#'+tab_name+'_l_nr_axis').val());
		  $('#refraction_gps_l_nr_vision').val($('#'+tab_name+'_l_nr_vision').val());

		  $('#refraction_gps_r_dt_sph').val($('#'+tab_name+'_r_dt_sph').val());
		  $('#refraction_gps_r_dt_cyl').val($('#'+tab_name+'_r_dt_cyl').val());
		  $('#refraction_gps_r_dt_axis').val($('#'+tab_name+'_r_dt_axis').val());
		  $('#refraction_gps_r_dt_vision').val($('#'+tab_name+'_r_dt_vision').val());
		  $('#refraction_gps_r_ad_sph').val($('#'+tab_name+'_r_ad_sph').val());
		  $('#refraction_gps_r_ad_vision').val($('#'+tab_name+'_r_ad_vision').val());
		  $('#refraction_gps_r_nr_sph').val($('#'+tab_name+'_r_nr_sph').val());
		  $('#refraction_gps_r_nr_cyl').val($('#'+tab_name+'_r_nr_cyl').val());
		  $('#refraction_gps_r_nr_axis').val($('#'+tab_name+'_r_nr_axis').val());
		  $('#refraction_gps_r_nr_vision').val($('#'+tab_name+'_r_nr_vision').val());
	}
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
</script>



<div id="load_add_type_modal_popup" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>
<div id="load_add_type_modal_popup2" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false"></div>
