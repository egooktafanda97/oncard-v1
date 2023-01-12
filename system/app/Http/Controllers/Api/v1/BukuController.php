<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Control\ManagementCrud;

class BukuController extends Controller
{
    public $data;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $objk = new ManagementCrud('Buku');
    }
    public function index(Request $request)
    {
        return config('generator_crud_config.scema_path');
    }

    public function store(Request $request)
    {
        $hndelAction = $this->data->generate_data_insert($request, false);
        return response()->json($hndelAction);
        // return response()->json($hndelAction, $hndelAction['status'] ?? 401);
    }
    public function update(Request $request, $id)
    {
        $hndelAction = $this->data->generate_data_update($request, $id);
        // return response()->json($hndelAction);
        return response()->json($hndelAction, $hndelAction['status'] ?? 401);
    }
    public function delete($id)
    {
        $hndelAction = $this->data->deleted($id);
        return response()->json($hndelAction, $hndelAction['status'] ?? 401);
    }
}
