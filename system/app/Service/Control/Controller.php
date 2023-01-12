<?php

namespace App\Service\Control;

// **** use migration ****************************
use Illuminate\Database\Schema\Blueprint;
// ******************************************
use Validator;
use App\Helpers\Helpers;

// permission *******************************
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Service\Control\Template;

// ******************************************

class Controller
{
    use Template;
    public $Init = [];
    public $table = "";
    public $primary = "";
    public $model_name_space;
    public $controller_name_space;
    public $jsonName = "";
    public function __construct($json)
    {
        $this->jsonName = $json;
    }
    public function instance($path)
    {
        $instance = json_decode(file_get_contents($path . $this->jsonName . ".json"), true);
        $this->Init = $instance;
        $this->table = $instance['Inisial']['table'];
        $this->primary = $instance['Inisial']['primary'];
    }
    public function setNameSpaceModel($name_space)
    {
        $this->model_name_space = $name_space;
    }
    public function getNameSpaceModel($modelName)
    {
        if (empty($this->model_name_space)) {
            if (!empty($this->Init["Namespace"]["namespace_model"])) {
                return $this->Init["Namespace"]["namespace_model"] . $modelName;
            } else {
                return false;
            }
        }
        return $this->model_name_space . $modelName;
    }
    public function setNameSpaceController($name_space)
    {
        $this->controller_name_space = $name_space;
    }
    public function getNameSpaceController($classes)
    {
        if (empty($this->controller_name_space))
            return false;
        return $this->controller_name_space . $classes;
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
    public function getFileRelation($path)
    {
        $hub = json_decode(file_get_contents(config('generator_crud_config.scema_path') . $path . ".json"), true);
        if (!$hub)
            return false;
        return $hub;
    }
    public function getRelationData($use = null)
    {
        $master = $this->Init;
        $__func = [];
        if (!array_key_exists('Relation',  $this->Init))
            return false;
        if (!empty($us))
            return $master['Relation'][$use] ?? false;
        return $master['Relation'];
    }
    public function getRelation()
    {
        $master = $this->Init;
        $__func = [];
        if (!array_key_exists('Relation',  $this->Init))
            return false;
        foreach ($master['Relation'] as $key => $value) {
            // $__func
            array_push($__func, $key);
        }
        return $__func;
    }
    public function getQuery($methods = null)
    {
        if (!array_key_exists('Query',  $this->Init))
            return false;
        if (array_key_exists($methods,  $this->Init["Query"])) {
            return $this->Init["Query"][$methods];
        }
        return $this->Init["Query"];
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
        $c = $this->Init['Namespace']['Controller'];
        return $this->getNameSpaceController($c);
    }
    public function getModel()
    {
        if (!array_key_exists('Namespace',  $this->Init))
            return false;
        if (!array_key_exists('Model',  $this->Init['Namespace']))
            return false;
        $modelName = $this->Init['Namespace']['Model'];
        return $this->getNameSpaceModel($modelName);
    }
    public function getModelName()
    {
        if (!array_key_exists('Namespace',  $this->Init))
            return false;
        if (!array_key_exists('Model',  $this->Init['Namespace']))
            return false;
        $modelName = $this->Init['Namespace']['Model'];
        return $modelName;
    }
    public function getUseModel(): array
    {
        if (!array_key_exists('Namespace',  $this->Init))
            return false;
        if (!array_key_exists('Use_Model',  $this->Init['Namespace']))
            return false;
        $model = $this->Init['Namespace']['Use_Model'];
        $listModel = [];
        foreach ($model as $key => $value) {
            $listModel[] = $this->getNameSpaceModel($value);
        }
        return $listModel;
    }
    public function getRelationByMethod($met)
    {
        $master = $this->Init;
        if (!array_key_exists('Relation',  $master))
            return false;
        if (!array_key_exists($met,  $master['Relation']))
            return false;
        $func = $master['Relation'][$met];
        $mod = $this->getNameSpaceModel($master['Relation'][$met]["model"]);
        if (!empty($master['Relation'][$met]["namespace"]))
            $mod = $master['Relation'][$met]["namespace"] . $master['Relation'][$met]["model"];
        $func["model"] = $mod;

        return $func;
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
        $create_data = $this->create_fild($master['Data']);
        return $create_data;
    }
    public function migration($table)
    {
        $master = $this->Init;
        $data = $master['Data'];
        $table->bigIncrements($master['Inisial']['primary']);
        foreach ($data as $key => $value) {
            $data_tipe = gettype($value['migration']);
            // dd($data_tipe);
            $migration = $data_tipe == "integer" ? $this->getTemplateMigration()[$value['migration']] : $value['migration'];
            if (!empty($migration['size'])) {
                $tt = $table->{$migration['type']}($key, $migration['size']);
            } else {
                $tt = $table->{$migration['type']}($key);
            }

            if (!empty($migration['param'])) {
                $ex = explode(",", $migration['param']);
                if (count($ex) > 0) {
                    foreach ($ex as $x) {
                        $xs = explode("|", $x);
                        if (count($xs) > 1) {
                            $tt->{$xs[0]}($xs[1]);
                        } else {
                            $tt->{$x}();
                        }
                    }
                }
            }

            if (!empty($value['relation']['foreign'])) {
                if ($value['relation']['foreign']['auto_delete_relation']) {
                    $table->foreign($key)
                        ->references($value['relation']['foreign']['key'])
                        ->on($value['relation']['foreign']['table'])
                        ->onDelete('cascade');
                } else {
                    $table->foreign($key)
                        ->references($value['relation']['foreign']['key'])
                        ->on($value['relation']['foreign']['table']);
                }
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
                $key => $this->getTemplateValidation()[$value['validate']]
            ];
        } else if ($data_tipe == "integer" && $value['request'] == false) {
            if ($auto_data == true) {
                $va = [
                    $key => $this->getTemplateValidation()[$value['validate']]
                ];
            } else {
                if (array_key_exists('type',  $value)) {
                    if ($value['type'] == "paret_value") {
                        $va = [
                            $key => $this->getTemplateValidation()[$value['validate']]
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
                $key => $this->getTemplateValidation()[$value['validate']]
            ];
        } else if ($data_tipe == "integer" && $value['request'] == false) {
            if ($auto_data == true) {
                $va = [
                    $key => $this->getTemplateValidation()[$value['validate']]
                ];
            } else {
                if (array_key_exists('type',  $value)) {
                    if ($value['type'] == "paret_value") {
                        $va = [
                            $key => $this->getTemplateValidation()[$value['validate']]
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
    public function getSoftDeletesStatus()
    {
        if (!array_key_exists('softdeletes', $this->Init))
            return false;
        return $this->Init["softdeletes"];
    }
    public function getQueryData()
    {
        if (!array_key_exists('Query_get', $this->Init))
            return false;
        return $this->Init["Query_get"];
    }
}
