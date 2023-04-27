<?php
// Initialize the session
session_start();

include_once 'database.php';
//print_r($_POST);

if(isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['item_id']) && isset($_POST['make'])
&& isset($_POST['model']) && isset($_POST['year']) && isset($_POST['machine_tye']))
{	 
	$phone_number = $_SESSION["phone_num"];
	$start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $number = count($_POST['item_id']); 
    $item_id = $_POST['item_id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $machine_tye = $_POST['machine_tye'];

    $hardware =-1;
    $harnum = -1;
    if(isset($_POST['hardware'])){
    $hardware = $_POST['hardware'];
    $harnum = count($_POST['hardware']);
    }
    
    $software =-1;
    $sofnum = -1;
    if(isset($_POST['software'])){
    $software = $_POST['software'];
    $sofnum = count($_POST['software']);
    }
    

    $peripheral = -1;
    $perinum = -1;
    if(isset($_POST['peripheral'])){
    $peripheral = $_POST['peripheral'];
    $perinum = count($_POST['peripheral']);
    }

    $query1 = oci_parse($conn, "call insert_service_contract(DATE '$start_date', DATE '$end_date',
    'active',$phone_number)");
    oci_execute($query1);


    if($number > 0)  
    {  
        for($j=0; $j<$number; $j++)  
        {    
            $yr = intval($year[$j]);
            $query2 = oci_parse($conn, "call insert_service_item('$item_id[$j]','$make[$j]', '$model[$j]', $yr,'$machine_tye[$j]')");
            oci_execute($query2);
        }    

        if($harnum != -1){
            for($j=0; $j<$harnum; $j++)  
            {    
                if($hardware != -1){
                $i = substr($hardware[$j],1);
                $itmid =  $item_id[$i - 1];
                $query3 = oci_parse($conn, "INSERT INTO service_registered(item_id,service_type)
                values($itmid,'hardware')");
                oci_execute($query3);
                }  
            }
        }

        if($sofnum != -1){
            for($j=0; $j<$sofnum; $j++)  
            {    
                if($software != -1){
                $i = substr($software[$j],1);
                $itmid =  $item_id[$i - 1];
                $query4 = oci_parse($conn, "INSERT INTO service_registered(item_id,service_type)
                values($itmid,'software')");
                oci_execute($query4);
                }  
            }
        }

        if($perinum != -1){
            for($j=0; $j<$perinum; $j++)  
            {    
                if($peripheral != -1){
                $i = substr($peripheral[$j],1);
                $itmid =  $item_id[$i - 1];
                $query5 = oci_parse($conn, "INSERT INTO service_registered(item_id,service_type)
                values($itmid,'peripheral')");
                oci_execute($query5);
                }  
            }
        } 
    } 

    $query6 = oci_parse($conn, "
        DECLARE
        v_cid NUMBER;
        BEGIN
            SELECT contract_id_seq.CURRVAL INTO v_cid FROM DUAL;
            :cid := v_cid;
        END;");
    oci_bind_by_name($query6, ":cid", $cid, -1, SQLT_INT);
    oci_execute($query6);

    $response = array(
        'status' => 'success',
        'cid' => $cid
      );
      // encode the array as JSON
    $json_response = json_encode($response);

    // set the response header to indicate that the response is JSON-encoded
    header('Content-Type: application/json');

    // send the JSON-encoded response to the client
    echo $json_response;

   
}
?>