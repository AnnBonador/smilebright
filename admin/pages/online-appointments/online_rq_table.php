<?php

include('../../config/dbconn.php');

$status = $_POST['status'];
$table = <<<EOT
    (
        SELECT
            patient_id,
            patient_name,
            created_at,
            schedule,
            starttime,
            status,
            payment_option,
            id
        FROM tblappointment
        WHERE schedtype ='Online Schedule' AND status LIKE '$status'
    ) temp
    EOT;
$primaryKey = 'id';

$columns = array(
    array('db' => 'patient_id', 'dt' => 'patient_id'),
    array('db' => 'patient_name', 'dt' => 'patient_name'),
    array('db' => 'created_at',  'dt' => 'created_at'),
    array('db' => 'schedule',   'dt' => 'schedule'),
    array('db' => 'starttime',  'dt' => 'starttime'),
    array('db' => 'status',   'dt' => 'status'),
    array('db' => 'payment_option',   'dt' => 'payment_option'),
    array('db' => 'id',   'dt' => 'id'),
);

require('../../config/sspconn.php');

require('../../ssp.class.php');
echo json_encode(
    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns)
);
