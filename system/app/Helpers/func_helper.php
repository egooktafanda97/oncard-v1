<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists("user_auth")) {
    function user_auth()
    {
        // if (Auth::user()->hasRole("perpustakaan")) {
        //     $get =  App\Models\Perpustakaan::where("user_id", auth()->user()->id)->first();
        //     return $get;
        // } else {
        //     $get =   auth()->user();
        //     return $get;
        // }
    }
}
if (!function_exists("from_camel_case")) {
    function from_camel_case($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}


if (!function_exists("table_roler")) {
    function table_roler($item, $items, $ky)
    {
        $item_val = $item;
        $itType = gettype($items['table']);
        if ($itType == 'array') {
            if (!empty($items['table']['obj_child'])) {
                try {
                    foreach ($items['table']['obj_child'] as $x => $y) {
                        $item_val = $item_val->{$y};
                    }
                } catch (\Throwable $th) {
                    $item_val = $item[$ky];
                }
            } elseif (!empty($items['table']['add_ons'])) {
                switch ($items['table']['add_ons']['type']) {
                    case 'img':
                        $item_val = '<img src=' . $item[$ky] . ' width="100px" />';
                        break;

                    default:
                        $item_val = $item[$ky];
                        break;
                }
            } else {
                $item_val = $item[$ky];
            }
        } else {
            $item_val = $item[$ky];
        }
        return $item_val;
    }
}
if (!function_exists("tgl_i")) {
    // format tanggal indonesia
    function tgl_i($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }
}
