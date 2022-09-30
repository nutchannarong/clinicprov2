<?php

$naturename = '';
$k = 0;
if ($datas->num_rows() > 0) {
    foreach ($datas->result() as $nature) {
        if ($k == 0) {
            $naturename .= $nature->shop_nature_name;
        } else {
            $naturename .= ', ' . $nature->shop_nature_name;
        }
        $k++;
    }
    echo $naturename;
} else {
    echo $naturename;
}
?>