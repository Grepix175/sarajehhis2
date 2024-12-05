<!DOCTYPE html>

<head>
	<meta charset="euc-kr">

</head>
<?php

?>

<body style="font:8px 'Arial';">
	<page size="A4">
		<h3 style="float:left;width:100%;text-align:center;margin:2px 2px;position:relative;">
			<span style="position:absolute;height:2px;width:40%;background:#eee;"></span>
			<span style="font-size:11px">OPD SUMMARY</span>
		</h3>
		<?php
	// 	   echo "<pre>";
    // print_r($drawing_list);
    // print_r(!empty($form_data['drawing_flag']));
    // die;
		if (!empty($form_data['drawing_flag'])) {
			if (!empty($drawing_list)) {
				?>
				<section style="float:left;width:100%;">
					<strong style="font-size: 11px;">HESS CHART</strong>
					<table class="table table-bordered text-center" id="set_drawing"
						style="width:500px; margin-left:100px; text-align:center;" border="1px" cellpading="0" cellspacing="0">
						<thead>
							<tr>
								<th class="text-center" width="200px;">Image</th>
								<th class="text-center" width="200px;">Remark</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($drawing_list as $key => $drawing) {
								echo '<tr>
	                               <td><a href="' . ROOT_UPLOADS_PATH . 'eye/prescription_drawing/' . $drawing['image'] . '"  target="_blank"><img src="' . ROOT_UPLOADS_PATH . 'eye/prescription_drawing/' . $drawing['image'] . '" width="80px"/></a></td>
	                               <td>' . $drawing['remark'] . '</td> 
	                             </tr>';
							}
							?>
						</tbody>
					</table>
				</section>
				<?php
			}
		}

		//echo $advice_adv['advice_txt']; die;
		?>



		<?php if ($form_data['biometry_flag'] && $flag !== 'hess_chart') { ?>
			<section class=" panel panel-default">
				<div class="panel-body">
					<div class="row">




						<div class="container bg-white pt-3">
							<h3 class="text-center">BIOMETRY </h3>

							<table class="table table-bordered">
								<tr>
									<td style="width:200px"><b>RIGHT <br> EYE</b></td>
									<td>K1</td>
									<td>K2</td>
									<td>AL</td>
								</tr>
								<tr>
									<td style="width:200px" rowspan="3">OB</td>
									<td><?php echo $biometry_ob_k1_one; ?></td>
									<td><?php echo $biometry_ob_k1_two; ?></td>
									<td><?php echo $biometry_ob_k1_three; ?></td>
								</tr>
								<tr>
									<td><?php echo $biometry_ob_k2_one; ?></td>
									<td><?php echo $biometry_ob_k2_two; ?></td>
									<td><?php echo $biometry_ob_k2_three; ?></td>
								</tr>
								<tr>
									<td><?php echo $biometry_ob_al_one; ?></td>
									<td><?php echo $biometry_ob_al_two; ?></td>
									<td><?php echo $biometry_ob_al_three; ?></td>
								</tr>
								<tr>
									<td style="width:200px" rowspan="3">ASCAN <br> & <br>AUTO-K</td>
									<td><?php echo $biometry_ascan_one; ?></td>
									<td><?php echo $biometry_ascan_two; ?></td>
									<td><?php echo $biometry_ascan_three; ?></td>
								</tr>
								<tr>
									<td><?php echo $biometry_ascan_sec_one; ?></td>
									<td><?php echo $biometry_ascan_sec_two; ?></td>
									<td><?php echo $biometry_ascan_sec_three; ?></td>
								</tr>
								<tr>
									<td><?php echo $biometry_ascan_thr_one; ?></td>
									<td><?php echo $biometry_ascan_thr_two; ?></td>
									<td><?php echo $biometry_ascan_thr_three; ?></td>
								</tr>
							</table>

							<table class="table table-bordered">
								<tr>
									<td style="width:200px"> IOL </td>
									<td>SRK-T</td>
									<td>ERROR</td>
									<td>BARETT</td>
									<td>ERROR</td>
								</tr>
								<tr>
									<td style="padding:1px;">
										<?php if ($biometry_iol_one == 'RYCF') { ?> RYCF <?php } ?>
										<?php if ($biometry_iol_one == 'AUROFLEX') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_one == 'ULTIMA') { ?> ULTIMA <?php } ?>
										<?php if ($biometry_iol_one == 'AUROFLEX EV') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_one == 'ACRIOL') { ?> ACRIOL <?php } ?>
										<?php if ($biometry_iol_one == 'AUROVUE') { ?> AUROVUE <?php } ?>
										<?php if ($biometry_iol_one == 'SP') { ?> SP <?php } ?>
										<?php if ($biometry_iol_one == 'ACRIVISION') { ?> ACRIVISION <?php } ?>
										<?php if ($biometry_iol_one == 'IQ') { ?> IQ <?php } ?>
										<?php if ($biometry_iol_one == 'CT LUCIA') { ?> CT LUCIA <?php } ?>
										<?php if ($biometry_iol_one == 'CT ASPHINA') { ?> CT ASPHINA <?php } ?>
										<?php if ($biometry_iol_one == 'ULTRASERT') { ?> ULTRASERT <?php } ?>
										<?php if ($biometry_iol_one == 'RAYONE CFLEX') { ?> RAYONE CFLEX
										<?php } ?>
										<?php if ($biometry_iol_one == 'RAYONE ASPHERIC') { ?> RAYONE ASPHERIC
										<?php } ?>
										<?php if ($biometry_iol_one == 'RAYONE') { ?> RAYONE <?php } ?>
										<?php if ($biometry_iol_one == 'HYDROPHOBIC') { ?> HYDROPHOBIC
										<?php } ?>
										<?php if ($biometry_iol_one == 'PANOPTIX') { ?> PANOPTIX <?php } ?>
										<?php if ($biometry_iol_one == 'TORIC') { ?> TORIC <?php } ?>

									</td>

									<td><?php echo $biometry_srk_one; ?></td>
									<td><?php echo $biometry_error_one; ?></td>
									<td><?php echo $biometry_barett_one; ?></td>

									<td><?php echo $biometry_error_one_two; ?></td>

								</tr>
								<tr>
									<td style="padding:1px;">
										<?php if ($biometry_iol_two == 'RYCF') { ?> RYCF <?php } ?>
										<?php if ($biometry_iol_two == 'AUROFLEX') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_two == 'ULTIMA') { ?> ULTIMA <?php } ?>
										<?php if ($biometry_iol_two == 'AUROFLEX EV') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_two == 'ACRIOL') { ?> ACRIOL <?php } ?>
										<?php if ($biometry_iol_two == 'AUROVUE') { ?> AUROVUE <?php } ?>
										<?php if ($biometry_iol_two == 'SP') { ?> SP <?php } ?>
										<?php if ($biometry_iol_two == 'ACRIVISION') { ?> ACRIVISION <?php } ?>
										<?php if ($biometry_iol_two == 'IQ') { ?> IQ <?php } ?>
										<?php if ($biometry_iol_two == 'CT LUCIA') { ?> CT LUCIA <?php } ?>
										<?php if ($biometry_iol_two == 'CT ASPHINA') { ?> CT ASPHINA <?php } ?>
										<?php if ($biometry_iol_two == 'ULTRASERT') { ?> ULTRASERT <?php } ?>
										<?php if ($biometry_iol_two == 'RAYONE CFLEX') { ?> RAYONE CFLEX
										<?php } ?>
										<?php if ($biometry_iol_two == 'RAYONE ASPHERIC') { ?> RAYONE ASPHERIC
										<?php } ?>
										<?php if ($biometry_iol_two == 'RAYONE') { ?> RAYONE <?php } ?>
										<?php if ($biometry_iol_two == 'HYDROPHOBIC') { ?> HYDROPHOBIC
										<?php } ?>
										<?php if ($biometry_iol_two == 'PANOPTIX') { ?> PANOPTIX <?php } ?>
										<?php if ($biometry_iol_two == 'TORIC') { ?> TORIC <?php } ?>
									</td>
									<td><?php echo $biometry_ascan_sec_sec; ?></td>
									<td><?php echo $biometry_error_sec; ?></td>
									<td><?php echo $biometry_barett_sec; ?></td>

									<td><?php echo $biometry_error_one_sec; ?></td>
								</tr>
								<tr>
									<td style="padding:1px;">
										<?php if ($biometry_iol_thr == 'RYCF') { ?> RYCF <?php } ?>
										<?php if ($biometry_iol_thr == 'AUROFLEX') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_thr == 'ULTIMA') { ?> ULTIMA <?php } ?>
										<?php if ($biometry_iol_thr == 'AUROFLEX EV') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_thr == 'ACRIOL') { ?> ACRIOL <?php } ?>
										<?php if ($biometry_iol_thr == 'AUROVUE') { ?> AUROVUE <?php } ?>
										<?php if ($biometry_iol_thr == 'SP') { ?> SP <?php } ?>
										<?php if ($biometry_iol_thr == 'ACRIVISION') { ?> ACRIVISION <?php } ?>
										<?php if ($biometry_iol_thr == 'IQ') { ?> IQ <?php } ?>
										<?php if ($biometry_iol_thr == 'CT LUCIA') { ?> CT LUCIA <?php } ?>
										<?php if ($biometry_iol_thr == 'CT ASPHINA') { ?> CT ASPHINA <?php } ?>
										<?php if ($biometry_iol_thr == 'ULTRASERT') { ?> ULTRASERT <?php } ?>
										<?php if ($biometry_iol_thr == 'RAYONE CFLEX') { ?> RAYONE CFLEX
										<?php } ?>
										<?php if ($biometry_iol_thr == 'RAYONE ASPHERIC') { ?> RAYONE ASPHERIC
										<?php } ?>
										<?php if ($biometry_iol_thr == 'RAYONE') { ?> RAYONE <?php } ?>
										<?php if ($biometry_iol_thr == 'HYDROPHOBIC') { ?> HYDROPHOBIC
										<?php } ?>
										<?php if ($biometry_iol_thr == 'PANOPTIX') { ?> PANOPTIX <?php } ?>
										<?php if ($biometry_iol_thr == 'TORIC') { ?> TORIC <?php } ?>
									</td>
									<td><?php echo $biometry_ascan_sec_thr; ?></td>
									<td><?php echo $biometry_error_thr; ?></td>
									<td><?php echo $biometry_barett_thr; ?></td>

									<td><?php echo $biometry_error_one_thr; ?></td>
								</tr>
								<tr>
									<td style="padding:1px;">
										<?php if ($biometry_iol_four == 'RYCF') { ?> RYCF <?php } ?>
										<?php if ($biometry_iol_four == 'AUROFLEX') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_four == 'ULTIMA') { ?> ULTIMA <?php } ?>
										<?php if ($biometry_iol_four == 'AUROFLEX EV') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_four == 'ACRIOL') { ?> ACRIOL <?php } ?>
										<?php if ($biometry_iol_four == 'AUROVUE') { ?> AUROVUE <?php } ?>
										<?php if ($biometry_iol_four == 'SP') { ?> SP <?php } ?>
										<?php if ($biometry_iol_four == 'ACRIVISION') { ?> ACRIVISION <?php } ?>
										<?php if ($biometry_iol_four == 'IQ') { ?> IQ <?php } ?>
										<?php if ($biometry_iol_four == 'CT LUCIA') { ?> CT LUCIA <?php } ?>
										<?php if ($biometry_iol_four == 'CT ASPHINA') { ?> CT ASPHINA <?php } ?>
										<?php if ($biometry_iol_four == 'ULTRASERT') { ?> ULTRASERT <?php } ?>
										<?php if ($biometry_iol_four == 'RAYONE CFLEX') { ?> RAYONE CFLEX
										<?php } ?>
										<?php if ($biometry_iol_four == 'RAYONE ASPHERIC') { ?> RAYONE ASPHERIC
										<?php } ?>
										<?php if ($biometry_iol_four == 'RAYONE') { ?> RAYONE <?php } ?>
										<?php if ($biometry_iol_four == 'HYDROPHOBIC') { ?> HYDROPHOBIC
										<?php } ?>
										<?php if ($biometry_iol_four == 'PANOPTIX') { ?> PANOPTIX <?php } ?>
										<?php if ($biometry_iol_four == 'TORIC') { ?> TORIC <?php } ?>
									</td>
									<td><?php echo $biometry_ascan_sec_four; ?></td>
									<td><?php echo $biometry_error_four; ?></td>
									<td><?php echo $biometry_barett_four; ?></td>

									<td><?php echo $biometry_error_one_four; ?></td>
								</tr>
								<tr>
									<td style="padding:1px;">
										<?php if ($biometry_iol_five == 'RYCF') { ?> RYCF <?php } ?>
										<?php if ($biometry_iol_five == 'AUROFLEX') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_five == 'ULTIMA') { ?> ULTIMA <?php } ?>
										<?php if ($biometry_iol_five == 'AUROFLEX EV') { ?> AUROFLEX <?php } ?>
										<?php if ($biometry_iol_five == 'ACRIOL') { ?> ACRIOL <?php } ?>
										<?php if ($biometry_iol_five == 'AUROVUE') { ?> AUROVUE <?php } ?>
										<?php if ($biometry_iol_five == 'SP') { ?> SP <?php } ?>
										<?php if ($biometry_iol_five == 'ACRIVISION') { ?> ACRIVISION <?php } ?>
										<?php if ($biometry_iol_five == 'IQ') { ?> IQ <?php } ?>
										<?php if ($biometry_iol_five == 'CT LUCIA') { ?> CT LUCIA <?php } ?>
										<?php if ($biometry_iol_five == 'CT ASPHINA') { ?> CT ASPHINA <?php } ?>
										<?php if ($biometry_iol_five == 'ULTRASERT') { ?> ULTRASERT <?php } ?>
										<?php if ($biometry_iol_five == 'RAYONE CFLEX') { ?> RAYONE CFLEX
										<?php } ?>
										<?php if ($biometry_iol_five == 'RAYONE ASPHERIC') { ?> RAYONE ASPHERIC
										<?php } ?>
										<?php if ($biometry_iol_five == 'RAYONE') { ?> RAYONE <?php } ?>
										<?php if ($biometry_iol_five == 'HYDROPHOBIC') { ?> HYDROPHOBIC
										<?php } ?>
										<?php if ($biometry_iol_five == 'PANOPTIX') { ?> PANOPTIX <?php } ?>
										<?php if ($biometry_iol_five == 'TORIC') { ?> TORIC <?php } ?>
									</td>
									<td><?php echo $biometry_ascan_sec_five; ?></td>
									<td><?php echo $biometry_error_five; ?></td>
									<td><?php echo $biometry_barett_five; ?></td>

									<td><?php echo $biometry_error_one_five; ?></td>
								</tr>
								<?php if (!empty($biometry_remarks)) { ?>
									<tfoot>
										<tr>
											<td colspan="5">
												<strong style="font-size: 10px;">REMARKS:</strong> <br>
												<?php echo $biometry_remarks; ?>
											</td>
										</tr>
									</tfoot>
								<?php } ?>
							</table>

						</div>
					</div>
				</div>
			</section>
		<?php } ?>

		<!--	<section>
		< ?php if(!empty($form_data['ref_doctor_name'])){
		 $ref_address=$form_data['address'];
		if(!empty($form_data['address2']))
		{
		  $ref_address.= ', '.$form_data['address2'];
		}
		 if(!empty($form_data['address3']))
		{
		  $ref_address.= ', '.$form_data['address3'];
		}
		if(!empty($form_data['ref_doctor_name']))
		{
		?>
		
		
	   <b> Refferal Doctor Details : </b> <br/> <div> <b>Name :</b> < ?php echo $form_data['ref_doctor_name']; if(!empty($form_data['ref_mobile_no'])){ ?> <br/> <b> Contact No. : </b>  < ?php echo $form_data['ref_mobile_no']; } if(!empty($ref_address)){ ?><br/>  <b> Address : </b>< ?php echo $ref_address;
   } }?> </div>
   
   < ?php  } ?>
	</section>  -->
	</page>
</body>

</html>