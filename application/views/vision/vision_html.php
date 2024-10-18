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
            <th>Patient Name</th>
            <th>Procedure Purpose</th>
            <th>Side Effects</th>
            <th>Created At</th>
        </tr>
        <?php
        if (!empty($data_list)) {
            foreach ($data_list as $opds) {
        ?>
                <tr>
                    <td><?php echo $opds->patient_name; ?></td>
                    <td><?php echo $opds->procedure_purpose; ?></td>
                    <td><?php echo $opds->side_effect_name; ?></td>
                    <td><?php echo $opds->created_at; ?></td>
                </tr>
        <?php
            }
        }
        ?> 
    </table>
</body></html>