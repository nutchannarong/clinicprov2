<?php

class Libs {

    // assets //

    public function css( $path_and_filename, $attr = array() ) {
        return '<link href="' . base_url() . 'assets/css/' . $path_and_filename . '" rel="stylesheet" type="text/css" ' . $this->conv_to_text( $attr ) . '/>' . "\r\n\t";
    }

    public function css_full( $path_and_filename, $attr = array() ) {
        return '<link href="' . base_url() . 'assets/' . $path_and_filename . '" rel="stylesheet" type="text/css" ' . $this->conv_to_text( $attr ) . '/>' . "\r\n\t";
    }

    public function js( $path_and_filename, $attr = array() ) {
        return '<script src="' . base_url() . 'assets/js/' . $path_and_filename . '" type="text/javascript" ' . $this->conv_to_text( $attr ) . '></script>' . "\r\n\t";
    }

    public function js_full( $path_and_filename, $attr = array() ) {
        return '<script src="' . base_url() . 'assets/' . $path_and_filename . '" type="text/javascript" ' . $this->conv_to_text( $attr ) . '></script>' . "\r\n\t";
    }

    public function img( $path_and_filename, $attr = array() ) {
        return '<img src="' . base_url() . 'assets/img/' . $path_and_filename . '"' . $this->conv_to_text( $attr ) . ' />' . "\r\n\t";
    }

    public function img_full( $path_and_filename, $attr = array() ) {
        return '<img src="' . base_url() . 'assets/' . $path_and_filename . '"' . $this->conv_to_text( $attr ) . ' />' . "\r\n\t";
    }

    public function full( $path_and_filename ) {
        return $path_and_filename . "\r\n\t";
    }

    public function conv_to_text( $array ) {
        return implode( ' ', array_map( function ($value, $key) {
                    return $key . '="' . $value . '"';
                }, $array, array_keys( $array ) ) );
    }

    public function meta( $property, $content ) {
        return '<meta property="' . $property . '" content="' . $content . '" />' . "\r\n\t";
    }

    // number and price //

    public function formatPrice( $text ) {
        return number_format( $text, 2 );
    }

    public function formatFloat( $text ) {
        $number = floatval( str_replace( ',', '', $text ) );
        $number = $number != 0 ? $number : 0;
        return number_format( $number, 2, '.', '' );
    }

    public function p2f( $p = '' ) {
        $f = '0.00';
        if ( !empty( $p ) ) {
            $filter_var = filter_var( $p, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            $f = number_format( $filter_var, 2, '.', '' );
        }
        return $f;
    }

    public function f2p( $f = '' ) {
        $p = '0.00';
        if ( !empty( $f ) ) {
            $filter_var = filter_var( $f, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            $p = number_format( $filter_var, 2, '.', ',' );
        }
        return $p;
    }

    // date //

    public function getDate() {
        return date( 'Y-m-d H:i:s' );
    }

    public function date2thai( $str_date, $format = NULL, $short = NULL ) {
        $str_year = date( 'Y', strtotime( $str_date ) ) + 543;
        $str_month = date( 'n', strtotime( $str_date ) );
        $str_day = date( 'j', strtotime( $str_date ) );
        $str_hour = date( 'H', strtotime( $str_date ) );
        $str_minute = date( 'i', strtotime( $str_date ) );
        $str_second = date( 's', strtotime( $str_date ) );
        if ( $short == NULL ) {
            $str_month_array = Array( '', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม' );
        } else {
            $str_month_array = Array( '', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.' );
        }
        $str_month_thai = $str_month_array[$str_month];
        if ( $format == NULL ) {
            $format = '%d %m %y, %h %i %s';
        }
        $find = array( '%d', '%m', '%y', '%h', '%i', '%s' );
        $replace = array( $str_day, $str_month_thai, $str_year, $str_hour, $str_minute, $str_second );
        return str_replace( $find, $replace, $format );
    }

    public function endate2thdate( $date, $short = 0 ) {
        if ( $date != '' && $date != '0000-00-00' ) {
            if ( $short == 0 ) {
                $str_month = array( '', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม' );
            } else {
                $str_month = array( '', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.' );
            }
            $date_explode = explode( '-', $date );
            $y = intval( $date_explode[0] ) + 543;
            $m = intval( $date_explode[1] );
            $d = intval( $date_explode[2] );
            return $d . ' ' . $str_month[$m] . ' ' . $y;
        } else {
            return 'ไม่ระบุ';
        }
    }

    public function dateprint( $strDate, $time = null ) {
        $strYear = date( "Y", strtotime( $strDate ) );
        $strMonth = date( "m", strtotime( $strDate ) );
        $strDay = date( "j", strtotime( $strDate ) );
        $strHour = date( "H", strtotime( $strDate ) );
        $strMinute = date( "i", strtotime( $strDate ) );
        if ( $time == 1 ) {
            return $strYear . '-' . $strMonth . '-' . $strDay . ' ' . $strHour . ':' . $strMinute;
        } else {
            return $strYear . '-' . $strMonth . '-' . $strDay;
        }
    }

    public function offsetyear( $date, $offset ) {
        if ( $date != '' ) {
            $date_explode = explode( '-', $date );
            $y = intval( $date_explode[0] ) + $offset;
            $m = intval( $date_explode[1] );
            $d = intval( $date_explode[2] );
            return sprintf( '%02d', $d ) . '/' . sprintf( '%02d', $m ) . '/' . $y;
        } else {
            return '';
        }
    }

}
