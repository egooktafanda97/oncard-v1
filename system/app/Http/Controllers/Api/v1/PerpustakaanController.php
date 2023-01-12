<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Service\Control\ManagementCrud;
use App\Traits\ManagementRoler;
use Perpustakaan;

class PerpustakaanController extends Controller
{
    use ManagementRoler;
    private $data;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }
    public function index()
    {
        if (!$roler = $this->newRole("api", "perpustakaan"))
            return false;
        $m = User::find(3);
        return $this->createRole($m, $roler);

        // return config('generator_crud_config.scema_path');
    }

    public function store(Request $request)
    {
        $data = new ManagementCrud("Perpustakaan");
        $hndelAction = $data->generate_data_insert($request);
        return response()->json($hndelAction, $hndelAction['status'] ?? 401);
    }
    public function update(Request $request, $id)
    {
        $data = new ManagementCrud("Perpustakaan");
        $hndelAction = $data->generate_data_update($request, $id);
        return response()->json($hndelAction, $hndelAction['status'] ?? 401);
    }
    public function delete($id)
    {
        $data = new ManagementCrud("Perpustakaan");
        $hndelAction = $data->deleted($id);
        return response()->json($hndelAction, $hndelAction['status'] ?? 401);
    }
}
