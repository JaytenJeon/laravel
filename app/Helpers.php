<?php

function elapsedTime($storedTime){
    $diff = (int)((time()-$storedTime) / 60);
    if($diff == 0){
        $result = "방금";
    }elseif ($diff < 60){
        $result = $diff ." 분";

    }elseif ($diff < (60*24)){
        $diff = (int)($diff / 60);
        $result = $diff . " 시간";
    }elseif ($diff < (60*24*30)){
        $diff = (int)($diff / 60 *24);
        $result = $diff . " 일";
    }elseif ($diff < (60*24*30*12)){
        $diff = (int)($diff / 60 * 24 * 30);
        $result = $diff . " 달";
    }else{
        $diff = (int)($diff / 60 * 24 * 30 * 12);
        $result = $diff . " 년";
    }


    return $result . ' 전에 작성되었습니다.';
}