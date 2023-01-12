<?php

namespace App\Source\Control;

use Validator;
use App\Helpers\Helpers;

// permission *******************************
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
// ******************************************

// costum config
use App\Source\Helper\Configure;

class ManagementCrud extends Controller
{

    private $main = [];
    public function __construct($json)
    {
        parent::__construct($json);
    }
    /**
     * .
     * fungsi yang berperan untuk insert data
     * @return void
     */
    public function selection_type_value($type, $request, $key, $value, $data)
    {
        switch ($type) {
                /**
             * .
             * tipe gambar
             */
            case 'image':
                $uploads = Helpers::Upgambar($request, $key, $value['path']);
                if (!$uploads['status'])
                    return $value['path'] . "/" . "default.jpg";
                $_get = $uploads["full-path"] ?? $value['path'] . "/" . "default.jpg";
                return $_get;
                break;
                /**
                 * .
                 * tipe static
                 */
            case 'static':
                return $value['value'] ?? "";
                break;
                /**
                 * .
                 * tipe forgn key
                 */
            case 'key':
                if (array_key_exists('relation', $value)) {
                    $key_id = $this->generate_data_relaation_insert($request, $value['relation']);
                    if (array_key_exists('status', $value) && $key_id['status'] == 401)
                        return [
                            "error"  => $key_id['error'],
                            "status" => 401,
                        ];
                    return $key_id;
                }
                return  $request[$key];
                break;
                /**
                 * .
                 * tipe otomatis terisi , setingan ada pada configure pada heper
                 */
            case 'auto':
                /**
                 * .
                 * cek config
                 */
                if (array_key_exists('config', $value)) {
                    /**
                     * .
                     * cek value
                     */
                    if (array_key_exists('def_value',  $value['config'])) {
                        $def_val = $value['config']['def_value'];
                        /**
                         * .
                         * compile data, ada pada configure Helper 
                         */
                        $v = Configure::CostumAutoData($value['config']['case'], $def_val);
                        $master = $this->getResource();
                        /**
                         * .
                         * validasi 
                         */
                        $validator = Validator::make([$key => $v], $this->getValidationResource($data, $key, $master, true));
                        if ($validator->fails()) {
                            return [
                                "error"  => $validator->errors(),
                                "status" => 401,
                            ];
                        }
                        return $v ? $v : '';
                    } else {
                        return [
                            "error"  => "error automatic data",
                            "status" => 401,
                        ];
                    }
                }
                return  "";
                break;
                /**
                 * .
                 * encrypt pada password
                 */
            case 'ecrypt':
                return bcrypt($request[$key]) ?? "";
                break;
                /**
                 * .
                 * ambil pada parent value nya
                 */
            case 'paret_value':
                return $request->{$value['value_parent']} ?? "";
                break;
                /**
                 * .
                 * jika case tidak ada
                 */
            default:
                if (empty($request[$key]))
                    return "";
                return $request[$key];

                break;
        }
    }
    /**
     * .
     * control data masuk
     * @return void
     */
    public function getControllData($request, $data)
    {

        $result = [];
        foreach ($data as $key => $value) {
            $_type_data = gettype($data); /* array, integer, string */
            $_value_type = $value['type'] ?? false;
            $status_request = $value['request'] ?? false; // apakah input post atau tidak
            if ($_type_data == "array" && !empty($request[$key])) {
                $res = $this->selection_type_value($_value_type, $request, $key, $value, $data);
                if (!empty($res['error']))
                    return $res;
                $result[$key] = $res;
            }
        }
        return $result;
    }
    /**
     * .
     * fungsi yang berperan untuk insert data
     * @return void
     */
    public  function generate_data_insert($request, $insert = true, $request_obj = true)
    {
        $data = $this->getData();
        $master = $this->getResource();
        try {
            // ===========================================================================
            /**
             * .
             * validasi data $request dan data fild json 
             */
            if (!$this->create_master_validation($master, $data))
                return [
                    "error"  => "resource error from validation data 'create_master_validation' function",
                    "status" => 401,
                ];

            // if ($request_obj == false) {
            $r_validate = $request;
            // }
            // else {
            //     $r_validate = $request->all();
            // }
            $validator = Validator::make($r_validate, $this->create_master_validation($master, $data));
            if ($validator->fails()) {
                return [
                    "error"  => $validator->errors(),
                    "status" => 401,
                ];
            }

            // // =================================================================================

            $result_data = $this->getControllData($request, $data);
            if ($insert == true) {
                if (!empty($result_data['error']))
                    return $result_data;
                if (!$result_data)
                    return [
                        "status" => 401,
                        "response" => $result_data,
                        "error" => 'something wrong..!'
                    ];

                foreach ($result_data as $k => $d) {
                    if (array_key_exists('type', $data[$k]) && array_key_exists('control_insert', $data[$k])) {
                        if ($data[$k]['type'] == 'key' && $data[$k]['control_insert'] == 'before') {
                            $index_relation = $master["Relation"][$data[$k]['relation']['relation_index']];
                            $id = $index_relation['model']::create($result_data[$k]);
                            $result_data[$k] = $id->id;
                        }
                    }
                }
                $result_data = $master["Namespace"]["Model"]::create($result_data);
                $gate = $master["Namespace"]["Model"]::where('id', $result_data['id']);
                foreach ($master["Relation"] as $z => $zz) {
                    $gate = $gate->with($z);
                }
                $gate = $gate->first();
                if ($result_data) {
                    $dataName = $master['Public_name'][1] ?? "";
                    return [
                        "status" => 200,
                        "data" => $gate,
                        "msg" => "data " . $dataName . " successfully input."
                    ];
                } else {
                    return [
                        "status" => 403,
                        "error" => 'something wrong insert error..! ',
                        "data" => $result_data,
                    ];
                }
            }



            /**
             * .
             * mengembalikan hasil pada controller
             */
            return [
                "status" => 200,
                "data" => $result_data,
                "msg" => "insert false, this data validate"
            ];
        } catch (\Exception $e) {
            /**
             * .
             * jika gagal query
             */
            return [
                "error"  => json_encode($e->getMessage(), true),
                "status" => 501
            ];
        }
    }
    /**
     * .
     * insert relasi beriringan
     * @return void
     */
    public function generate_data_relaation_insert($request, $relation_config, $request_obj = true)
    {

        try {
            $data = $this->getDataRelation($relation_config['relation_index'])['data'];
            $master = $this->getResource();
            // return $data;
            if (!$data)
                return [
                    "error"  => [],
                    "status" => 401,
                ];
            // ===========================================================================
            $mainerData = [];
            /**
             * .
             * inisiasi data utama pada fild_relation ship json
             */

            if (!$this->create_master_validation($master, $data))
                return [
                    "error"  => "resource error from validation data 'create_master_validation' function",
                    "status" => 401,
                ];
            // if ($request_obj == false) {
            $r_validate = $request;
            // } 
            // else {
            //     $r_validate = $request->all();
            // }
            $validator = Validator::make($r_validate, $this->create_master_validation($master, $data));
            if ($validator->fails()) {
                return [
                    "error"  => $validator->errors(),
                    "status" => 401,
                ];
            }

            return $this->getControllData($request, $data);
        } catch (\Exception $e) {
            /**
             * .
             * jika gagal query
             */
            return [
                "error"  => json_encode($e->getMessage(), true),
                "status" => 501
            ];
        }
    }

    /**
     * .
     * select type pada update data
     * @return void
     */
    public function selection_type_value_update($type, $request, $key, $value, $data)
    {
        switch ($type) {
                /**
             * .
             * tipe gambar
             */
            case 'image':
                $uploads = Helpers::Upgambar($request, $key, $value['path']);
                if (!$uploads['status'])
                    return $value['path'] . "/" . "default.jpg";
                $_get = $uploads["full-path"] ?? $value['path'] . "/" . "default.jpg";
                return $_get;
                break;
                /**
                 * .
                 * tipe static
                 */
            case 'static':
                return $value['value'] ?? "";
                break;
                /**
                 * .
                 * tipe forgn key
                 */
            case 'key':
                if (array_key_exists('relation', $value)) {
                    $key_id = $this->generate_data_relaation_insert($request, $value['relation']);
                    if (array_key_exists('status', $value) && $key_id['status'] == 401)
                        return [
                            "error"  => $key_id['error'],
                            "status" => 401,
                        ];
                    return $key_id;
                }
                return  $request[$key];
                break;
                /**
                 * .
                 * tipe otomatis terisi , setingan ada pada configure pada heper
                 */
            case 'auto':
                /**
                 * .
                 * cek config
                 */
                if (array_key_exists('config', $value)) {
                    /**
                     * .
                     * cek value
                     */
                    if (array_key_exists('def_value',  $value['config'])) {
                        $def_val = $value['config']['def_value'];
                        /**
                         * .
                         * compile data, ada pada configure Helper 
                         */
                        $v = Configure::CostumAutoData($value['config']['case'], $def_val);
                        $master = $this->getResource();
                        /**
                         * .
                         * validasi 
                         */
                        $validator = Validator::make([$key => $v], $this->getValidationResourceUpdated($data, $key, $master, true));
                        if ($validator->fails()) {
                            return [
                                "error"  => $validator->errors(),
                                "status" => 401,
                            ];
                        }
                        return $v ? $v : '';
                    } else {
                        return [
                            "error"  => "error automatic data",
                            "status" => 401,
                        ];
                    }
                }
                return  "";
                break;
                /**
                 * .
                 * encrypt pada password
                 */
            case 'ecrypt':
                return bcrypt($request[$key]) ?? "";
                break;
                /**
                 * .
                 * ambil pada parent value nya
                 */
            case 'paret_value':
                return $request->{$value['value_parent']} ?? "";
                break;
                /**
                 * .
                 * jika case tidak ada
                 */
            default:
                if (empty($request[$key]))
                    return "";
                return $request[$key];

                break;
        }
    }
    /**
     * .
     * update data relasi beriringan
     * @return void
     */
    public function generate_data_update($request, $id)
    {
        /**
         * .
         * inisiasi data json
         */
        $data = $this->getData();
        $master = $this->getResource();
        $model = $master["Namespace"]["Model"];

        try {
            /**
             * .
             * get data by id model json
             */
            $Q = $model::find($id);
            /**
             * .
             * inisiasi compilasi data
             */
            $fungsi_berelasi = [];
            /**
             * .
             * loop data json key fild
             */

            $data_result = [];

            if (!$valids = $this->create_master_validation($master, $data))
                return [
                    "error"  => "resource error from validation data 'create_master_validation' function",
                    "status" => 401,
                ];

            foreach ($data as $key => $value) {
                /**
                 * .
                 * inisiasi variabel
                 */
                $getTypeData = gettype($value) ?? null;
                $type = $value['type'] ?? "string";

                if ($request->{$key} !== null && $getTypeData == "array") {
                    if (!empty($valids[$key])) {
                        $validator = Validator::make([$key => $request->{$key}], [$key => $valids[$key]]);
                        if ($validator->fails()) {
                            return [
                                "error"  => $validator->errors(),
                                "status" => 401,
                            ];
                        }
                        $res = $this->selection_type_value_update($type, $request, $key, $value, $data);
                        if ($res)
                            $Q->{$key} = $res;
                    }
                }
            }

            if (array_key_exists('Relation',  $master)) {
                foreach ($master['Relation'] as $keys => $r) {
                    $getTypeData = gettype($r) ?? null;
                    $type = $r['type'] ?? "string";
                    if ($Q->{$keys} !== null) {
                        if (!$r_valid = $this->create_master_validation($master, $r['data']))
                            return [
                                "error"  => "resource error from validation data 'create_master_validation' function",
                                "status" => 401,
                            ];
                        foreach ($r['data'] as $ky => $va) {
                            if (!empty($r_valid[$ky])) {
                                if ($request->{$ky}) {
                                    $roler_validation = $r_valid[$ky];
                                    if (!empty($va['validate_unique'])) {
                                        $roler_validation = $roler_validation . "," . $ky . "," . $Q->{$keys}->id;
                                    }
                                    $validators = Validator::make([$ky => $request->{$ky}], [$ky => $roler_validation]);
                                    if ($validators->fails()) {
                                        return [
                                            "error"  => $validators->errors(),
                                            "status" => 401,
                                        ];
                                    }
                                    $this->getValidationResourceUpdated($r['data'], $ky, $master,);
                                    $res = $this->selection_type_value_update($type, $request, $ky, $va, $data);
                                    if ($res)
                                        $Q->{$keys}->{$ky} = $res;
                                }
                            }
                        }
                        $Q->{$keys}->save();
                    }
                }
            }

            $saves =  $Q->save();
            if ($saves) {
                return [
                    "data" => $Q,
                    "status" => 200,
                    "msg" => "success updated"
                ];
            }
            /**
             * .
             * jika save gagal
             */
            else {
                return [
                    "status" => 401,
                    "msg" => "something wrong!!!"
                ];
            }
        }
        /**
         * .
         * error server
         */
        catch (\Exception $e) {
            return [
                "error"  => json_encode($e->getMessage(), true),
                "status" => 501
            ];
        }
    }

    public function getInstanceRouter()
    {
        $router = $this->getRouter();
        $arr_route = [];
        foreach ($router as $key_rout => $v_rout) {
            $middelType = gettype($v_rout['middleware']);
            $middel = [];
            $prefix = $v_rout['prefix'];
            $method = $v_rout['method'];
            $rout = $v_rout['router'];
            if ($middelType == 'integer') {
                $template = $this->getTemplate()['middleware'][$v_rout['middleware']];
                if (!$template)
                    return [
                        "error"  => 'error router format invalid..!',
                        "status" => 401,
                    ];
                $middel = $template;
            } else {
                $middel = $v_rout['middleware'];
            }
            if (count($arr_route) > 0) {
                $switch_group = false;
                $indexs = 0;
                foreach ($arr_route as  $va) {
                    if ($va['middleware'] == $middel) {
                        $switch_group = true;
                        $arr_route[$indexs]['rute'][] = [
                            "method" => $method,
                            "rout" => $rout,
                            "function" => $key_rout,
                            "class" => $v_rout['controller'] == 'this' ? $this->getController() : $v_rout['controller']
                        ];
                    }
                    $indexs++;
                }
                if ($switch_group == false) {
                    array_push($arr_route, [
                        "middleware" => $middel,
                        "prefix" => $prefix,
                        "rute" => [
                            [
                                "method" => $method,
                                "rout" => $rout,
                                "function" => $key_rout,
                                "class" => $v_rout['controller'] == 'this' ? $this->getController() : $v_rout['controller']
                            ]
                        ],
                    ]);
                }
            } else {
                array_push($arr_route, [
                    "middleware" => $middel,
                    "prefix" => $prefix,
                    "rute" => [
                        [
                            "method" => $method,
                            "rout" => $rout,
                            "function" => $key_rout,
                            "class" => $v_rout['controller'] == 'this' ? $this->getController() : $v_rout['controller']
                        ]
                    ],
                ]);
            }
        }
        return $arr_route;
    }
    public function deleted($id)
    {
        try {

            $model =  $this->getModel();
            $relation = $this->getRelation();
            $deletes = $model::find($id);
            if (!$deletes)
                return [
                    "status" => 401,
                    "error" => "something wrong.! data fonud"
                ];
            if (count($relation) > 0)
                foreach ($relation as  $func) {
                    $deletes->{$func}()->delete();
                }
            $deleted =  $deletes->delete();
            if ($deleted) {
                return [
                    "data" => $deletes,
                    "status" => 200,
                    "msg" => "delete success!"
                ];
            }
        }
        /**
         * .
         * error server
         */
        catch (\Exception $e) {
            return [
                "error"  => json_encode($e->getMessage(), true),
                "status" => 501
            ];
        }
    }
}
