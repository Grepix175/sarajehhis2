<!DOCTYPE html>

<head>
	<meta charset="euc-kr">

</head>
<body style="font:8px 'Arial';">
	<page size="A4">
		<br>
		
		<h3 style="float:left;width:100%;text-align:center;margin:2px 2px;position:relative;">
			<span style="position:absolute;height:2px;width:40%;background:#eee;"></span>
			<span style="font-size:11px">Refraction Below 8 Year</span>
		</h3>
		<br>
		<section style="float:left;width:48%;margin-right: 10px;">
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
					<tr>
						<th width="25%"></th>
						<th width="25%">OD</th>
						<th width="25%">OS</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>UnVn</b></td>
						<!-- <td><input type="text" id="unvn_od" name="unvn_od" class="w-50px"></td> -->
						<td><?php echo $UnVn['unvn_od'];?></td>
						<td><?php echo $UnVn['unvn_os'];?></td>
						<!-- <td><input type="text" id="unvn_os" name="unvn_os" class="w-50px"></td> -->
					</tr>
				</tbody>
			</table>
		</section>
		<section style="float:right;width:50%;margin-left: 10px;">
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
					<tr>
						<th width="25%"></th>
						<th width="25%">OD</th>
						<th width="25%">OS</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>PgVnq</b></td>
						<!-- <td><input type="text" id="unvn_od" name="unvn_od" class="w-50px"></td> -->
						<td><?php echo $PgVnq['pgvnq_od'];?></td>
						<td><?php echo $PgVnq['pgvnq_os'];?></td>
						<!-- <td><input type="text" id="unvn_os" name="unvn_os" class="w-50px"></td> -->
					</tr>
				</tbody>
			</table>
		</section>

		<br>
		<section style="float:left;width:48%;margin-right: 10px;">
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
					<tr>
						<th width="25%"></th>
						<th width="25%">OD</th>
						<th width="25%">OS</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>Pupillary Reaction</b></td>
						<!-- <td><input type="text" id="unvn_od" name="unvn_od" class="w-50px"></td> -->
						<td><?php echo $pupillary_reaction['pupillary_reaction_od'];?></td>
						<td><?php echo $pupillary_reaction['pupillary_reaction_os'];?></td>
						<!-- <td><input type="text" id="unvn_os" name="unvn_os" class="w-50px"></td> -->
					</tr>
				</tbody>
			</table>
		</section>
		<section style="float:right;width:50%;margin-left: 10px;">
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
					<tr>
						<th width="25%"></th>
						<th width="25%">OD</th>
						<th width="25%">OS</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>ROPGAS</b></td>
						<!-- <td><input type="text" id="unvn_od" name="unvn_od" class="w-50px"></td> -->
						<td><?php echo $ropgas['ropgas_od'];?></td>
						<td><?php echo $ropgas['ropgas_os'];?></td>
						<!-- <td><input type="text" id="unvn_os" name="unvn_os" class="w-50px"></td> -->
					</tr>
				</tbody>
			</table>
		</section>
		<br>
		<section class="panel panel-default">

			<div class="panel-body">
				<div class="row">
					<!-- Vision with CL Row -->
					<div class="col-md-4">
						<div class="grp-full">
							<div class="form-group row">
								<b><label for="vision_with_cl" class="col-md-4 col-form-label">Vision with CL:</label></b>
									<?php echo $refraction_data['vision_with_cl'];?>
							</div>
						</div>
					</div>  
				</div>
				<br>
				<div class="row">
					<!-- Hirschberg Test Row -->
					<div class="col-md-4">
						<div class="grp-full">
							<div class="form-group row">
								<b><label for="hirschberg_test" class="col-md-4 col-form-label">Hirschberg Test - Ortho:</label> </b>
									<?php echo $refraction_data['hirschberg_test']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<br>
		<br>
		
		<section style="float:left;width:48%;margin-right: 10px;">
			<b>AUTO REFRACTION (DRY)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
					<tr>
						<th width="25%"></th>
						<th width="25%">Sph</th>
						<th width="25%">Cyl</th>
						<th width="25%">Axis</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>OD</b></td>
						<td><?php echo $refrtsn_auto_ref['refraction_ar_l_dry_sph'];?></td>
						<td><?php echo $refrtsn_auto_ref['refraction_ar_l_dry_cyl'];?></td>
						<td><?php echo $refrtsn_auto_ref['refraction_ar_l_dry_axis'];?></td>
					</tr>
					<tr>
						<td><b>OS</b></td>
						<td><?php echo $refrtsn_auto_ref['refraction_ar_l_dd_sph'];?></td>
						<td><?php echo $refrtsn_auto_ref['refraction_ar_l_dd_cyl'];?></td>
						<td><?php echo $refrtsn_auto_ref['refraction_ar_l_dd_axis'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<section style="float:right;width:50%;margin-left: 10px;">
			<b>AUTO REFRACTION (DIALTED)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
					<tr>
						<th width="25%"></th>
						<th width="25%">Sph</th>
						<th width="25%">Cyl</th>
						<th width="25%">Axis</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>OD</b></td>
						<td><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_sph_plated'];?></td>
						<td><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_cyl_plated'];?></td>
						<td><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dry_axis_plated'];?></td>
					</tr>
					<tr>
						<td><b>OS</b></td>
						<td><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_sph_plated'];?></td>
						<td><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_cyl_plated'];?></td>
						<td><?php echo $refrtsn_auto_ref_dilted['refraction_ar_l_dd_axis_plated'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<br>
		<br>
		
		<section style="float:left;width:48%;margin-right: 10px;">
			<b>DRY REFRACTION (OD)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
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
						<td><b>Distant</b></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_sph'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_cyl'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_axis'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_dt_vision'];?></td>
					</tr>
					<tr>
						<td><b>Prism</</b>td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_sph'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_cyl'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_axis'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_ad_vision'];?></td>
					</tr>
					<tr>
						<td><b>Near</t</b>d>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_sph'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_cyl'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_axis'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_l_nr_vision'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<section style="float:right;width:50%;margin-left: 10px;">
			<b>DRY REFRACTION (OS)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
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
						<td><b>Distant</b></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_sph'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_cyl'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_axis'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_dt_vision'];?></td>
					</tr>
					<tr>
						<td><b>Prism</b></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_sph'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_cyl'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_axis'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_ad_vision'];?></td>
					</tr>
					<tr>
						<td><b>Near</b></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_sph'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_cyl'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_axis'];?></td>
						<td><?php echo $refrtsn_dry_ref['refraction_dry_ref_r_nr_vision'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<br>
		<br>


		<section style="float:left;width:48%;margin-right: 10px;">
			<b>REFRACTION (DILATED) (OD)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
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
						<td><b>Distant</b></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_sph'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_cyl'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_axis'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_l_dt_vision'];?></td>
					</tr>
					<tr>
						<td><b>Near</b></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_sph'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_cyl'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_axis'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_l_nr_vision'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<section style="float:right;width:50%;margin-left: 10px;">
			<b>REFRACTION (DILATED) (OS)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
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
						<td><b>Distant</b></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_sph'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_cyl'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_axis'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_r_dt_vision'];?></td>
					</tr>
					<tr>
						<td><b>Near</b></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_sph'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_cyl'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_axis'];?></td>
						<td><?php echo $refrtsn_dltd['refraction_ref_dtd_r_nr_vision'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<br>
		<br>


		<section style="float:left;width:48%;margin-right: 10px;">
			<b>PMT (OD)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
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
						<td><b>Distant</b></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_dt_sph'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_dt_cyl'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_dt_axis'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_dt_vision'];?></td>
					</tr>
					<tr>
						<td><b>Prism</b></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_ad_sph'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_ad_cyl'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_ad_axis'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_ad_vision'];?></td>
					</tr>
					<tr>
						<td><b>Near</b></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_nr_sph'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_nr_cyl'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_nr_axis'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_l_nr_vision'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<section style="float:right;width:50%;margin-left: 10px;">
			<b>PMT (OS)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
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
						<td><b>Distant</b></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_dt_sph'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_dt_cyl'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_dt_axis'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_dt_vision'];?></td>
					</tr>
					<tr>
						<td><b>Prism</b></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_ad_sph'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_ad_cyl'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_ad_axis'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_ad_vision'];?></td>
					</tr>
					<tr>
						<td><b>Near</b></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_nr_sph'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_nr_cyl'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_nr_axis'];?></td>
						<td><?php echo $refrtsn_pmt['refraction_pmt_r_nr_vision'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<br>
		<br>


		<section style="float:left;width:48%;margin-right: 10px;">
			<b>PGP (OD)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
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
						<td><b>Distant</b></td> 
						<td><?php echo $refrtsn_pgp['refraction_pgp_l_dt_sph'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_l_dt_cyl'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_l_dt_axis'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_l_dt_vision'];?></td>
					</tr>
					<tr>
						<td><b>Near</b></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_l_nr_sph'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_l_nr_cyl'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_l_nr_axis'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_l_nr_vision'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<section style="float:right;width:50%;margin-left: 10px;">
			<b>PGP (OS)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
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
						<td><b>Distant</b></td> 
						<td><?php echo $refrtsn_pgp['refraction_pgp_r_dt_sph'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_r_dt_cyl'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_r_dt_axis'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_r_dt_vision'];?></td>
					</tr>
					<tr>
						<td><b>Near</b></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_r_nr_sph'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_r_nr_cyl'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_r_nr_axis'];?></td>
						<td><?php echo $refrtsn_pgp['refraction_pgp_r_nr_vision'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<br>
		<br>


		<section style="float:left;width:48%;margin-right: 10px;">
			<b>KERATOMETRY (K)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
					<tr>
						<th width="33.33%"></th>
						<th width="33.33%">Value</th>
						<th width="33.33%">Axis</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>k1</b></td>
						<td><?php echo $refrtsn_kerat['refraction_km_l_kh'];?></td>
						<td><?php echo $refrtsn_kerat['refraction_km_l_kh_a'];?></td>
					</tr>
					<tr>
						<td><b>K2</b></td>
						
						<td><?php echo $refrtsn_kerat['refraction_km_l_kv'];?></td>
						<td><?php echo $refrtsn_kerat['refraction_km_l_kv_a'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<section style="float:right;width:50%;margin-left: 10px;">
			<b>KERATOMETRY (K)<b>
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="1" cellpadding="0" cellspacing="0">
				<thead  class="bg-info">
					<tr>
						<th width="33.33%"></th>
						<th width="33.33%">Value</th>
						<th width="33.33%">Axis</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>K1</b></td>
						<td><?php echo $refrtsn_kerat['refraction_km_r_kh'];?></td>
						<td><?php echo $refrtsn_kerat['refraction_km_r_kh_a'];?></td>
					</tr>
					<tr>
						<td><b>K2</b></td>
						<td><?php echo $refrtsn_kerat['refraction_km_r_kv'];?></td>
						<td><?php echo $refrtsn_kerat['refraction_km_r_kv_a'];?></td>
					</tr>
				</tbody>
			</table>
		</section>

		<br>
		<br>


		<section style="float:left;width:48%;margin-right: 10px;">
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="text-align:right;"><b>Average K :</b></td>
						<td style="text-align:left;"><?php echo $refraction_data['average_k1'];?></td>
					</tr>
					<tr>
						<td style="text-align:right;"><b>Eye:</b></td>
						<td style="text-align:left;"><?php echo $refraction_data['eye1'];?></td>
					</tr>
				</tbody>
			</table>
		</section>
		<section style="float:right;width:50%;margin-left: 10px;">
			<table class="table table-bordered text-center" id="set_drawing" style="width: 500px; text-align: center;" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="text-align:right;"><b>Average K :</b></td>
						<td style="text-align:left;"><?php echo $refraction_data['average_k2'];?></td>
					</tr>
					<tr>
						<td style="text-align:right;"><b>Eye:</b></td>
						<td style="text-align:left;"><?php echo $refraction_data['eye2'];?></td>
					</tr>
				</tbody>
			</table>
		</section>
		<br>
		<br>
		<br>
		
	</page>
</body>
</html>


