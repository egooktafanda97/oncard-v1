<?php

namespace App\Service\Helper;

use Validator;
use App\Helpers\Helpers;
use Illuminate\Support\Str;

trait Configure
{

    public function getRolerAutoData($def_value)
    {
        switch ($def_value) {
            case 'auth_id':
                return auth()->user()->id ?? false;
                break;
                // costum config
            case 'kode_instansi':
                return auth()->user()->kode_instansi ?? false;
                break;
            case 'request':
                break;
            default:
                return false;
                break;
        }
    }
    public function CostumAutoData($case, $def_val, $testing = false)
    {
        switch ($case) {
            case 'data_by_model':
                if ($testing)
                    return false;
                return $this->getNameSpaceModel($def_val["model_id"])::where($def_val['where'], $this->getRolerAutoData($def_val['role_value']))->{$def_val['get']}()->{$def_val['obj']} ?? "";
                break;
            case 'data_by_user_auth':
                if ($testing)
                    return false;
                return $this->getRolerAutoData($def_val['role_value']);
                break;
            case 'auto_data_config':
                if ($testing)
                    return false;
                return $this->getRolerAutoData($def_val['role_value']);
                break;
            case 'data_random_unique':
                return Str::random(10);
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
