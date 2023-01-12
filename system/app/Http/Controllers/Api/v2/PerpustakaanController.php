<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Control\ManagementCrud;
use App\Traits\ManagementRoler;

class PerpustakaanController extends Controller
{
    use ManagementRoler;
    private $data;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }
    public function index(Request $request)
    {
        // return $this->newRole("api", "perpustakaan");
        // return config('generator_crud_config.file_location');
        return auth()->user();
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
