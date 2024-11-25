<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informed Consent for Fundus Fluorescein Angiography</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            /* Setting the page size to Tabloid */
            @page {
                size: 11in 17in; /* Tabloid dimensions */
                margin: 1in; /* Adjust margins as needed */
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                zoom: 1; /* Scale for better fit */
            }

            /* Ensure the container fits the page */
            .container-fluid {
                max-width: 100%;
                width: 100%;
                margin: 0;
            }

            table {
                width: 100% !important;
                border-collapse: collapse;
                page-break-inside: avoid; /* Avoid breaking tables */
            }

            /* th, td {
                border: 1px solid black;
                padding: 8px;
                word-wrap: break-word; /* Ensure text breaks to fit */
            } */

            label, input, textarea, p {
                font-size: 10pt; /* Adjust font size for printing */
            }

            .form-signatures, .form-section {
                page-break-inside: avoid; /* Avoid breaking signatures across pages */
            }

            /* Hide buttons and links during printing */
            .modal-footer, a, button {
                display: none !important;
            }
        }

        .container-fluid {
            padding: 50px;
        }

        .form-signatures .border-top {
            width: 200px;
        }

        .form-signatures p {
            margin-bottom: 0;
        }
    </style>
     <style>
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
        /* table {s */
        td{
            /* width: auto !important;
            text-align: unset !important; */
        }

        .itemTable th,
        .itemTable td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            width: 20%;
        }


        th {
            /* background-color: #f0f0f0; */
        }

        input[type="text"],
        /* input[type="select"], */
        input[type="number"] {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
            outline: none;
        }

        td {
            /* padding: 6px; */
        }

        button {
            margin-top: 10px;
        }

        .pat-col {
            width: 100% !important;
        }

        h5 {
            text-align: left;
        }

        h3 {
            text-align: center;
        }
        select {
            width: 300px!important;
        }
        span#select2-medicine_name_dropdown-container,
        span#select2-salt_dropdown-container {
            text-align: left;
            width: 300px;
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
        .left-column,
        .right-column {
            width: 15%;
        }

        /* Ensure all labels and contents in both columns align vertically */
        .left-column td,
        .right-column td {
            padding: 2px;
        }

        /* Ensure that the tables in both columns align to the top */
        .left-column table, 
        .right-column table {
            width: 100%; 
            /* border-collapse: collapse; */
        }
        
    </style>
</head>
<body>
<div class="container-fluid">
    <section class="content">
    <p style="text-align: center; font-size: 7px;"><strong>Sara Eye HOSPITALS</strong></p>
        <!-- <p class="font-weight-bold">Mobile no.: <?php echo isset($billing_data['mobile_no']) ? htmlspecialchars($billing_data['mobile_no']) : ''; ?></p> -->
        <?php
        // Loop through the contact lens data
        $age_y = $form_data['age_y']??'';
        $age_m = $form_data['age_m']??'';
        $age_d = $form_data['age_d']??'';

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
        <div class="panel-body"  style="">
            <table class="patient-info-table" style="margin-top: 20px; ">
                <tr>
                    <td class="left-column">
                        <table>
                            <tr>
                                <td class="info-label">Patient</td>
                                <td class="info-content">: <?php echo $form_data['patient_name']??''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Patient Reg. No</td>
                                <td class="info-content">: <?php echo $form_data['patient_code']??''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">OPD No</td>
                                <td class="info-content">: <?php echo $form_data['booking_code']??''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Token No</td>
                                <td class="info-content">: <?php echo $form_data['token_no'] ?? ''; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td class="right-column">
                        <table>
                            <tr>
                                <td class="info-label">Mobile no.</td>
                                <td class="info-content">: <?php echo $form_data['mobile_no']??''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Age</td>
                                <td class="info-content">: <?php echo $age??''; ?></td>
                            </tr>
                            <tr>
                                <td class="info-label">Gender</td>
                                <td class="info-content">: <?php echo ($form_data['gender'] == '0') ? 'Female' : 'Male'; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td>
                            <span class="font-weight-bold">Name of the patient:</span> 
                            <?php echo isset($form_data['patient_name']) ? htmlspecialchars($form_data['patient_name']) : ''; ?>
                        </td>
                        <td>
                            <span class="font-weight-bold">Regn No:</span> 
                            <?php echo isset($form_data['patient_code']) ? htmlspecialchars($form_data['patient_code']) : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="font-weight-bold">Token No:</span> <?php echo isset($billing_data['token_no']) ? htmlspecialchars($billing_data['token_no']) : ''; ?>
                        </td>
                        <td>
                            <span class="font-weight-bold">Billing No:</span> <?php echo isset($billing_data['booking_code']) ? htmlspecialchars($billing_data['booking_code']) : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="font-weight-bold">Age:</span> <?php echo isset($billing_data['age']) ? htmlspecialchars($billing_data['age']) : ''; ?>
                        </td>
                        <td>
                            <span class="font-weight-bold">Patient Category:</span> <?php echo isset($billing_data['patient_category']) ? htmlspecialchars($billing_data['patient_category']) : ''; ?>
                        </td>
                    </tr>

                </tbody>
            </table> -->
        </div>


        <h3 class="text-center" style="margin-bottom:30px;">Informed Consent for Fundus Fluorescein Angiography</h3>

        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td class="small">
                        <span class="font-weight-bold">Purpose of the Procedure : </span> 
                        <?php echo isset($form_data['procedure_purpose']) ? htmlspecialchars($form_data['procedure_purpose']) : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td class="small">
                        <span class="font-weight-bold">Side Effects : </span> 
                        <?php echo isset($form_data['side_effect_name']) ? htmlspecialchars($form_data['side_effect_name']) : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td class="small mt-3 text-left" colspan="1">
                        I have been informed about the procedure, benefits, and risks, and hereby consent to proceed with the investigation.
                    </td>
                </tr>
            </tbody>
        </table>


        <div class="form-signatures">
            <table class="table table-borderless mb-4">
                <tbody>
                    <tr>
                        <td class="small text-center">
                            <div class="pt-5"> 
                                <span></span>
                                <span></span>
                            </div>
                            <span class="font-weight-bold">Signature / LTI of patient</span>
                        </td>
                        <td class="small text-center">
                            <div class="pt-5"> 
                                <span></span>
                                <span></span>
                            </div>
                            <span class="font-weight-bold">Signature / LTI of relative</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>




        <div class="form-section mt-5">
            <p class="font-weight-bold text-center">Check List Prior to FFA - for the evaluating Doctor and Assistant</p>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $questions = [
                        'Informed Consent' => 'informed_consent',
                        'Previous FFA' => 'previous_ffa',
                        'History of Allergy' => 'history_allergy',
                        'History of Asthma' => 'history_asthma',
                        'History of Epilepsy (Flash photography)' => 'history_epilepsy',
                        'Accompanied by Attendant' => 'accompanied_attendant',
                        'S Creatinine' => 's_creatinine',
                        'Blood Sugar' => 'blood_sugar',
                        'Blood Pressure' => 'blood_pressure'
                    ];

                    foreach ($questions as $question => $name): ?>
                        <tr>
                            <th class="font-weight-bold mb-0 small"><?php echo $question; ?></th>
                            <td>
                                <p class="font-weight-bold mb-0 small">
                                    <?php 
                                    if (isset($form_data[$name])) {
                                        echo ($form_data[$name] == 'yes') ? 'Yes' : (($form_data[$name] == 'no') ? 'No' : '');
                                    } else {
                                        echo ''; // If the value is not set at all
                                    }
                                    ?>
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="grp-full">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                <span class="font-weight-bold">FFA not done due to : </span> 
                                <?php echo isset($form_data['reason_ffa_not_done']) ? htmlspecialchars($form_data['reason_ffa_not_done']) : ''; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>

        <div class="form-signatures mt-5">
            <table class="table table-borderless mb-4">
                <tbody>
                    <tr>
                        <td class="small text-center">
                            <p class="font-weight-bold pt-4">Optometrist's Signature</p>
                            <br />
                            <span class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;"><strong><?php echo isset($form_data['optometrist_signature_name']) ? htmlspecialchars($form_data['optometrist_signature_name']) : ''; ?></strong></span>
                            <!-- <div class="border-top pt-4">______________________</div> Increased padding for more space -->
                            <p class="mt-2 small"><?php echo isset($form_data['optometrist_date']) ? date('d-m-Y', strtotime($form_data['optometrist_date'])) : '__________________'; ?></p>
                        </td>
                        <td class="small text-center">
                            <p class="font-weight-bold pt-4">Anaesthetist's Signature</p>
                            <br />
                            <span class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;"><strong><?php echo isset($form_data['anaesthetist_signature']) ? htmlspecialchars($form_data['anaesthetist_signature']) : ''; ?></strong></span>
                            <!-- <div class="border-top pt-4">______________________</div> Increased padding for more space -->
                            <p class="mt-2 small"><?php echo isset($form_data['anaesthetist_date']) ? date('d-m-Y', strtotime($form_data['anaesthetist_date'])) : '__________________'; ?></p>
                        </td>
                        <td class="small text-center">
                            <p class="font-weight-bold pt-4">Doctor's Signature</p>
                            <br />
                            <span class="border-top pt-2 mx-auto" style="display: inline-block; width: 200px; border-top:1px solid black; margin-top: 24px;"><strong><?php echo isset($form_data['doctor_signature_name']) ? htmlspecialchars($form_data['doctor_signature_name']) : ''; ?></strong></span>
                            <!-- <div class="border-top pt-4">______________________</div> Increased padding for more space -->
                            <p class="mt-2 small"><?php echo isset($form_data['doctor_date']) ? date('d-m-Y', strtotime($form_data['doctor_date'])) : '__________________'; ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </section>
</div>

</body>
</html>
