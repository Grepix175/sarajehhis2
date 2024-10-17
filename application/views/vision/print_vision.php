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

            th, td {
                border: 1px solid black;
                padding: 8px;
                word-wrap: break-word; /* Ensure text breaks to fit */
            }

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
</head>
<body>
<div class="container-fluid">
    <section class="content">
        <p class="text-center">Sara Eye HOSPITALS</p>
        <p class="font-weight-bold">Mobile no.: <?php echo isset($billing_data['mobile_no']) ? htmlspecialchars($billing_data['mobile_no']) : ''; ?></p>
        
        <div class="form-group border p-3 rounded">
            <table class="table table-borderless">
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
                            <span class="font-weight-bold">Age:</span> <?php echo isset($billing_data['age']) ? htmlspecialchars($billing_data['age']) : 'Not Defined'; ?>
                        </td>
                        <td>
                            <span class="font-weight-bold">Patient Category:</span> <?php echo isset($billing_data['patient_category']) ? htmlspecialchars($billing_data['patient_category']) : ''; ?>
                        </td>
                    </tr>

                </tbody>
            </table>
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
                                        echo ($form_data[$name] == 'yes') ? 'Yes' : (($form_data[$name] == 'no') ? 'No' : 'null');
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
                            <!-- <div class="border-top pt-4">______________________</div> Increased padding for more space -->
                            <p class="mt-2 small">Date: <?php echo isset($form_data['optometrist_date']) ? date('F j, Y', strtotime($form_data['optometrist_date'])) : '__________________'; ?></p>
                        </td>
                        <td class="small text-center">
                            <p class="font-weight-bold pt-4">Anaesthetist's Signature</p>
                            <!-- <div class="border-top pt-4">______________________</div> Increased padding for more space -->
                            <p class="mt-2 small">Date: <?php echo isset($form_data['anaesthetist_date']) ? date('F j, Y', strtotime($form_data['anaesthetist_date'])) : '__________________'; ?></p>
                        </td>
                        <td class="small text-center">
                            <p class="font-weight-bold pt-4">Doctor's Signature</p>
                            <!-- <div class="border-top pt-4">______________________</div> Increased padding for more space -->
                            <p class="mt-2 small">Date: <?php echo isset($form_data['doctor_date']) ? date('F j, Y', strtotime($form_data['doctor_date'])) : '__________________'; ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </section>
</div>

</body>
</html>
