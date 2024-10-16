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
            .modal-footer, a, button {
                display: none !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid black;
                padding: 8px;
            }

            .form-signatures div {
                width: 100%;
                text-align: left;
            }

            body {
                margin: 0;
                padding: 0;
            }

            * {
                background-color: transparent !important;
                color: black !important;
            }

            label, input, textarea, p {
                font-size: 12pt;
            }

            .form-signatures, .form-section {
                page-break-inside: avoid;
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
        <h2 class="text-center" style="margin-bottom:30px;">Informed concent for fundus fluorescein angiography</h2> <!-- Centered title -->
        <div class="form-group">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <label class="font-weight-bold mb-0 small">Name of the patient:</label> <!-- Make label text small -->
                    <p class="small d-inline-block" style="margin-left: 10px;">
                        <?php echo isset($form_data['patient_name']) ? htmlspecialchars($form_data['patient_name']) : ''; ?>
                    </p> <!-- Make paragraph text small -->
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold mb-0 small">Regn No:</label> <!-- Reg No label -->
                    <p class="small d-inline-block" style="margin-left: 10px;">
                        <?php echo isset($form_data['patient_code']) ? htmlspecialchars($form_data['patient_code']) : ''; ?>
                    </p> <!-- Reg No value -->
                </div>
            </div>
        </div>



        <div class="form-group">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label class="font-weight-bold mb-0 small">Purpose of the Procedure: </label> <!-- Make label text small -->
                </div>
                <div class="col-md-6 mt-3">
                    <p class="small"><?php echo isset($form_data['procedure_purpose']) ? htmlspecialchars($form_data['procedure_purpose']) : ''; ?></p> <!-- Make paragraph text small -->
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label class="font-weight-bold mb-0 small">Side Effects: </label> <!-- Make label text small -->
                </div>
                <div class="col-md-6 mt-3">
                    <p class="small "><?php echo isset($form_data['side_effect_name']) ? htmlspecialchars($form_data['side_effect_name']) : ''; ?></p> <!-- Make paragraph text small -->
                </div>
            </div>
        </div>

        <p class="mt-3 small">I have been informed about the procedure, benefits, and risks, and hereby consent to proceed with the investigation.</p> <!-- Make paragraph text small -->

        <div class="form-signatures">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="border-top pt-2">
                        <span></span>
                    </div>
                    <p class="font-weight-bold small">Signature / LTI of patient</p> <!-- Make label text small -->
                </div>
                <div class="col-md-6">
                    <div class="border-top pt-2">
                        <span></span>
                    </div>
                    <p class="font-weight-bold small">Signature / LTI of relative</p> <!-- Make label text small -->
                </div>
            </div>
        </div>

        <div class="form-section mt-5">
            <p class="font-weight-bold text-center">Check List Prior to FFA - for the evaluating Doctor and Assistant</p> <!-- Changed to a paragraph -->
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Question</th> <!-- Retaining question column header -->
                        <td></td>
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
                                <p class="font-weight-bold mb-0 small"><?php echo isset($form_data[$name]) && $form_data[$name] == 'yes' ? 'Yes' : 'No'; ?></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
            <div class="grp-full" style="">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <label class="font-weight-bold mb-0 small">FFA not done due to:</label> <!-- Label styled similarly -->
                    </div>
                    <div class="col-md-6 mt-3">
                        <p class="small"><?php echo isset($form_data['reason_ffa_not_done']) ? htmlspecialchars($form_data['reason_ffa_not_done']) : ''; ?></p>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-signatures mt-5">
            <div class="row mb-4">
                <div class="col-md-4">
                    <p class="font-weight-bold small">Optometrist's Signature</p> <!-- Make label text small -->
                    <div class="border-top pt-2">______________________</div>
                    <p class="mt-2 small">Date: <?php echo isset($form_data['optometrist_date']) ? date('F j, Y', strtotime($form_data['optometrist_date'])) : '__________________'; ?></p> <!-- Make date text small -->
                </div>
                <div class="col-md-4">
                    <p class="font-weight-bold small">Anaesthetist's Signature</p> <!-- Make label text small -->
                    <div class="border-top pt-2">______________________</div>
                    <p class="mt-2 small">Date: <?php echo isset($form_data['anaesthetist_date']) ? date('F j, Y', strtotime($form_data['anaesthetist_date'])) : '__________________'; ?></p> <!-- Make date text small -->
                </div>
                <div class="col-md-4">
                    <p class="font-weight-bold small">Doctor's Signature</p> <!-- Make label text small -->
                    <div class="border-top pt-2">______________________</div>
                    <p class="mt-2 small">Date: <?php echo isset($form_data['doctor_date']) ? date('F j, Y', strtotime($form_data['doctor_date'])) : '__________________'; ?></p> <!-- Make date text small -->
                </div>
            </div>
        </div>

    </section>
</div>

</body>
</html>
