<?php

namespace App\Traits;

trait ManagementControl
{
    public $source;
    public function RolesGetterData($cases, $param = null)
    {
        switch ($cases) {
            case 'auth_id':
                return auth()->user()->id;
                break;
            case 'kode_instansi':
                return auth()->user()->kode_instansi;
                break;
            case 'args':
                return $param;
                break;

            default:
                # code...
                break;
        }
    }
    public function Querys($Query, $param = null)
    {
        try {
            $model = $this->source->getModel();
            $m = new $model;
            if (!empty($Query["where"])) {
                foreach ($Query["where"] as $ky => $v) {
                    $m = $m->where($ky, $this->RolesGetterData($v, $param));
                }
            }
            if (!empty($Query["with"])) {
                $m = $m->with($Query["with"]);
            }
            if (request()->header("search")) {
                $queryUri = request()->query();
                foreach ($queryUri as $key_search => $val) {
                    $m = $m->orWhere($key_search, 'LIKE', '%' . $val . '%');
                }
            }
            if (!empty($Query["pagination"]))
                $result = $m->paginate($Query["pagination"]["number_show"]);
            else
                $result = $m->{$Query["result"]}();
            return $result;
        } catch (\Throwable $th) {
            return [
                // "error"  => "fatal error Query.",
                "error"  => $th->getMessage(),
                "status" => 501
            ];
        }
    }
    public function setSource($data)
    {
        $this->source = $data;
    }
    public function __call($name, $param)
    {
        if ($Query = $this->source->getQuery($name)) {
            return response()->json($this->Querys($Query, $param[0] ?? null));
        } else {
            return response()->json(["error" => "not found."], 404);
        }
    }

    // public function get()
    // {
    //     if ($Query = $this->source->getQuery(__FUNCTION__)) {
    //         return response()->json($this->Querys($Query));
    //     }
    // }
    // public function getById($id)
    // {
    //     if ($Query = $this->source->getQuery(__FUNCTION__)) {
    //         return response()->json($this->Querys($Query, $id));
    //     }
    // }
    // public function getByAuth()
    // {
    //     if ($Query = $this->source->getQuery(__FUNCTION__)) {
    //         return response()->json($this->Querys($Query));
    //     }
    // }
}


// if (!$request->code_reference)
//             $request->merge([
//                 'code_reference' => Str::random(40),
//                 'role' => 'instansi'
//             ]);