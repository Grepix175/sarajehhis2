<html><head>
<!--<title>Patient Report</title>-->
<?php
if($print_status==1)
{
?>
<script type="text/javascript">
window.print();
window.onfocus=function(){ window.close();}
</script>
<?php	
}
?>
<style>
body
{
	font-size: 10px;
}	
td
{
	padding-left:15px;
}
 .header-title {
        text-align: center;  /* Center the text */
        font-weight: bold;   /* Make the text bold */
        font-size: 18px;     /* Increase font size */
        padding: 10px;       /* Add padding inside the div */
        border: 2px solid black;  /* Add a solid border */
        margin-bottom: 20px; /* Add margin below for spacing */
        display: inline-block;
        width: 100%;
        box-sizing: border-box; /* Ensure padding does not affect width */
    }
</style>
</head><body>
    <div class="header-title"><?php echo $mainHeader; ?></div>
    <table width="100%" cellpadding="0" cellspacing="0" border="1px">
        <tr>
            <th>Token No</th>
            <th>OPD No</th>
            <th>Patient Reg No</th>
            <th>Patient Name</th>
            <th>Patient Category</th>
            <th>Patient Category</th>
            <th>Mobile No</th>
            <th>Consultant</th>
            <th>Lens</th>
            <th>Comment</th>
            <th>Status</th>
        </tr>
        <?php
        if (!empty($data_list)) {
            foreach ($data_list as $refraction) {
        ?>
                <tr>
                    <td><?php echo $refraction->token_no; ?></td>
                    <td><?php echo $refraction->booking_code; ?></td>
                    <td><?php echo $refraction->patient_code; ?></td>
                    <td><?php echo $refraction->patient_name; ?></td>
                    <td><?php echo $refraction->patient_category_name; ?></td>
                    <td><?php echo $refraction->mobile_no; ?></td>
                    <td><?php echo $refraction->doctor_name; ?></td>
                    <td><?php echo $refraction->lens; ?></td>
                    <td><?php echo $refraction->comment; ?></td>
                    <td><?php echo $refraction->status == 1 ? 'Active' : 'Not Active'; ?></td>
                    <td><?php echo date('d-m-Y H:i', strtotime($form_data['created_date'])) ?></td>
                </tr>
        <?php
            }
        }
        ?> 
    </table>
</body></html>