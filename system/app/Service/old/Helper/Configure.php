<?php

namespace App\Source\Helper;

use Validator;
use App\Helpers\Helpers;

class Configure
{
    public static function getRolerAutoData($def_value)
    {
        switch ($def_value) {
            case 'auth_id':
                return auth()->user()->id ?? false;
                break;

            default:
                return false;
                break;
        }
    }
    public static function CostumAutoData($case, $def_val)
    {
        switch ($case) {
            case 'data_by_model':
                return $def_val["model_id"]::where($def_val['where'], self::getRolerAutoData($def_val['role_value']))->{$def_val['get']}()->{$def_val['obj']} ?? "";
                break;
            case 'date':
                return date("Y-m-d");
                break;

            case 'date_time':
                return date("Y-m-d H:s:i");
                break;

            default:
                return false;
                break;
        }
    }
}
