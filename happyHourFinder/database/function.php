<?php
require_once('connect.php');

function SQLI_Prepare($connect, $query, & $param_arr){
    $format="";
    $format = str_pad($format,count($param_arr),'s');
    array_unshift($param_arr, $format);

    if($stmt = $connect->prepare($query)){
        call_user_func_array(array($stmt, 'bind_param'), refValues($param_arr));
        $stmt->execute();
    }
    return $stmt;
}

function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) 
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}