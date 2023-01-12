<?php

namespace App\Source\Control;

// **** use migration ****************************
use Illuminate\Database\Schema\Blueprint;
// ******************************************
use Validator;
use App\Helpers\Helpers;

// permission *******************************
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
// ******************************************

class Controller
{
    public $Init = [];
    public $table = "";
    public $primary = "";
    public function __construct($json)
    {
        $instance = json_decode(file_get_contents(app_path("Source/data/" . $json . ".json")), true);
        $this->Init = $instance;
        $this->table = $instance['Inisial']['table'];
        $this->primary = $instance['Inisial']['primary'];
    }
    public function getData()
    {
        if (!array_key_exists('Data',  $this->Init))
            return false;
        return $this->Init["Data"];
    }
    public function getResource()
    {
        if (count($this->Init) == 0)
            return false;
        return $this->Init;
    }
    public function getDataRelation($table = null)
    {
        if (!array_key_exists('Relation',  $this->Init))
            return false;
        if (!empty($table))
            return $this->Init['Relation'][$table];
        return $this->Init['Relation'];
    }
    public function getRelation()
    {
        $master = $this->Init;
        $__func = [];
        if (!array_key_exists('Relation',  $this->Init))
            return false;
        foreach ($master['Relation'] as $key => $value) {
            $__func += [$key];
        }
        return $__func;
    }

    public function getTemplate()
    {
        if (!array_key_exists('Template',  $this->Init))
            return false;
        return $this->Init['Template'];
    }
    public function getRouter()
    {
        if (!array_key_exists('Router',  $this->Init))
            return false;
        return $this->Init['Router'];
    }
    public function getController()
    {
        if (!array_key_exists('Namespace',  $this->Init))
            return false;
        if (!array_key_exists('Controller',  $this->Init['Namespace']))
            return false;
        return $this->Init['Namespace']['Controller'];
    }
    public function getModel()
    {
        if (!array_key_exists('Namespace',  $this->Init))
            return false;
        if (!array_key_exists('Model',  $this->Init['Namespace']))
            return false;
        return $this->Init['Namespace']['Model'];
    }
    public function getUseModel(): array
    {
        if (!array_key_exists('Namespace',  $this->Init))
            return false;
        if (!array_key_exists('Use_Model',  $this->Init['Namespace']))
            return false;
        return $this->Init['Namespace']['Use_Model'];
    }
    public function getRelationByMethod($met)
    {
        $master = $this->Init;
        if (!array_key_exists('Relation',  $master))
            return false;
        if (!array_key_exists($met,  $master['Relation']))
            return false;
        if (!array_key_exists('function', $master['Relation'][$met]))
            return false;
        return $master['Relation'][$met]['function'];
    }
    public function getRelationshipStrings($arr)
    {
        $str = "";
        foreach ($arr as $value) {
            $str .= "public function " . $value[0] . "(){ return " . "$" . "this->" .  $value[1] . "(" . $value[2] . ",'" . $value[3] . "');}";
        }
        return $str;
    }
    public function getFild()
    {
        $master = $this->Init;
        return $this->create_fild($master['Data']);
    }
    public function migration($table)
    {
        $master = $this->Init;
        $data = $master['Data'];
        $table->bigIncrements($master['Inisial']['primary']);
        foreach ($data as $key => $value) {
            $data_tipe = gettype($value['migration']);
            // dd($data_tipe);
            $migration = $data_tipe == "integer" ? $master['Template']['migration'][$value['migration']] : $value['migration'];
            if (!empty($migration['size'])) {
                $tt = $table->{$migration['type']}($key, $migration['size']);
            } else {
                $tt = $table->{$migration['type']}($key);
            }

            if (!empty($migration['param'])) {
                $ex = explode(",", $migration['param']);
                if (count($ex) > 0) {
                    foreach ($ex as $x)
                        $tt->{$x}();
                }
            }

            if (!empty($migration['foreign'])) {
                $table->foreign($key)
                    ->references($migration['foreign']['key'])
                    ->on($migration['foreign']['table'])
                    ->onDelete('cascade');
            }
        }
    }
    public function created_protected()
    {
        $master = $this->Init;
        if (empty($master['Inisial'])) return false;
        if (empty($master['Inisial']['Protected'])) return false;
        return $master['Inisial']['Protected'];
    }
    public function create_fild($data)
    {
        $arr = [];
        foreach ($data as $key => $value) {
            array_push($arr, $key);
        }
        return $arr;
    }
    public function create_master_validation($master, $data)
    {
        $va = [];
        foreach ($data as $key => $value) {
            if (array_key_exists('validate', $value)) {
                $va += $this->getValidationResource($data, $key, $master);
            }
        }
        return $va;
    }
    public function getValidationResource($data, $key, $master, $auto_data = false)
    {
        $value = $data[$key];
        $data_tipe = gettype($value['validate']) ?? false;
        $va = [];
        if ($data_tipe == "array" && $value['request'] == true) {
            $va = [
                $key => $value['validate']
            ];
        } else if ($data_tipe == "integer" && $value['request'] == true) {
            $va = [
                $key => $master['Template']['validation'][$value['validate']]
            ];
        } else if ($data_tipe == "integer" && $value['request'] == false) {
            if ($auto_data == true) {
                $va = [
                    $key => $master['Template']['validation'][$value['validate']]
                ];
            } else {
                if (array_key_exists('type',  $value)) {
                    if ($value['type'] == "paret_value") {
                        $va = [
                            $key => $master['Template']['validation'][$value['validate']]
                        ];
                    }
                }
            }
        } else if ($data_tipe == "string") {
            $va = [
                $key => $value
            ];
        }
        return $va;
    }
    public function getValidationResourceUpdated($data, $key, $master, $auto_data = false)
    {
        $value = $data[$key];
        $data_tipe = gettype($value['validate']) ?? false;
        $va = [];
        if ($data_tipe == "array" && $value['request'] == true) {
            $va = [
                $key => $value['validate']
            ];
        } else if ($data_tipe == "integer" && $value['request'] == true) {
            $va = [
                $key => $master['Template']['validation'][$value['validate']]
            ];
        } else if ($data_tipe == "integer" && $value['request'] == false) {
            if ($auto_data == true) {
                $va = [
                    $key => $master['Template']['validation'][$value['validate']]
                ];
            } else {
                if (array_key_exists('type',  $value)) {
                    if ($value['type'] == "paret_value") {
                        $va = [
                            $key => $master['Template']['validation'][$value['validate']]
                        ];
                    }
                }
            }
        } else if ($data_tipe == "string") {
            $va = [
                $key => $value
            ];
        }
        return $va;
    }
    public function create_router_variable($router)
    {
        $master = $this->Init;
    }
}
