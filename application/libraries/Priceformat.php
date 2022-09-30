<?php

class Priceformat {

    public function p2f($p = '') {
        $f = '0.00';
        if (!empty($p)) {
            $filter_var = filter_var($p, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $f = number_format($filter_var, 2, '.', '');
        }
        return $f;
    }

    public function f2p($f = '') {
        $p = '0.00';
        if (!empty($f)) {
            $filter_var = filter_var($f, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $p = number_format($filter_var, 2, '.', ',');
        }
        return $p;
    }

}
