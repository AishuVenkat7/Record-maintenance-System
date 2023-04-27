<?php

include_once 'database.php';
//print_r($_POST);

if (isset($_POST['item_id'])) {

    $name = $_POST['name'];
    $phone_number = $_POST["phone_num"];
    //$current_date = $_POST['current_date'];
    $city = $_POST['city'];
    $item_id = $_POST['item_id'];
    $service_type = $_POST['service_type'];

    $totalCost = 0;
    $laborCost = 0;
    $partCost = 0;
    if ($service_type == 'hardware' || $service_type == 'peripheral')
        $partCost = rand(0, 100);


    $query3 = oci_parse($conn, "select service_type from service_registered where item_id= :itemId");

    oci_bind_by_name($query3, ":itemId", $item_id);
    oci_execute($query3, OCI_DEFAULT);

    $found = 0;
    while ($row = oci_fetch_array($query3, OCI_ASSOC + OCI_RETURN_NULLS)) {
        foreach ($row as $item) {
            if ($item == $service_type) {
                $found = 1;
                break;
            }
        }
        if ($found == 1)
            break;
    }
    oci_free_statement($query3);

    if ($found == 0) {
        $query4 = oci_parse($conn, "select * from coverage where service_type= :serviceType");
        oci_bind_by_name($query4, ":serviceType", $service_type);
        oci_execute($query4, OCI_DEFAULT);

        while (($row = oci_fetch_row($query4)) != false) {
            $laborCost = $row[2];
        }
        oci_free_statement($query4);

        $totalCost = $partCost + $laborCost;
    } else {
        $totalCost = $partCost;
    }


    $query5 = oci_parse($conn, "select rno from repair_item where item_id = :itemId
    and service_type = :serviceType and phone_num = :phoneNum");
    oci_bind_by_name($query5, ":itemId", $item_id);
    oci_bind_by_name($query5, ":serviceType", $service_type);
    oci_bind_by_name($query5, ":phoneNum", $phone_number);
    oci_execute($query5, OCI_DEFAULT);

    $rno = null;
    while (($row = oci_fetch_row($query5)) != false) {
        $rno = $row[0];
    }

    if ($rno == null) {
        $query6 = oci_parse($conn, "insert into repair_item(item_id,service_type, phone_num)
        values($item_id, '$service_type', $phone_number)");
        oci_execute($query6);

        $query = oci_parse($conn, "
                    DECLARE
                    v_rno NUMBER;
                    BEGIN
                        SELECT rno_seq.CURRVAL INTO v_rno FROM DUAL;
                        :rno := v_rno;
                    END;");
        oci_bind_by_name($query, ":rno", $rno, -1, SQLT_INT);
        oci_execute($query);
    }

    $current_date = date("Y-m-d");
    $query7 = oci_parse($conn, "insert into repair_charge_details(labor_cost,part_cost, total_repair_cost, 
    date_of_service, rno)values($laborCost, $partCost, $totalCost,DATE '$current_date',$rno)");
    oci_execute($query7);

    oci_close($conn);

    $response = array(
        'status' => 'success',
        'rno' => $rno
    );

    $json_response = json_encode($response);
    header('Content-Type: application/json');
    echo $json_response;
}
