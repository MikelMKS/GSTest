<?php

function dateFormat($date){
    if (empty($date)) {
        $dateRet = '';
    }else{
        $day = date('d', strtotime($date));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
        $hour = date('G', strtotime($date));
        $minute = date('i', strtotime($date));
        $dateRet = $day.'-'.$month.'-'.$year.' '.$hour.':'.$minute;
    }
    return $dateRet;
}

function noEmpty($val,$nombre,$response){
    if($response['sta'] == '0'){
        if(empty($val)){
            $response['sta'] = '1';
            $response['msg'] = "YOU MUST COMPLETE THE FIELD '".$nombre."'";
        }else{
            $response['sta'] = '0';
            $response['msg'] = "";
        }
    }

    return $response;
}

function existeArchivo($ruta,$nombre){
    $busca = '../public/'.$ruta.'/'.$nombre;
    return file_exists($busca)?TRUE:FALSE;
}

?>
