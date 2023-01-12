<?php

namespace Modules\V1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*
| class costum crud management
*/
use App\Service\Control\ManagementCrud;
use App\Traits\ManagementRoler;
use App\Traits\ManagementControl;
use Modules\V1\Providers\ManagementServiceProvider;
/*
| end
*/

/*
| USE MODEL
*/
// use App\Models\User;
/*
| end
*/

class ProdukController extends Controller
{
    use ManagementRoler;
    use ManagementControl;


    public  $resources;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
        $resources = new ManagementCrud(str_replace('Controller', '', "ProdukController"));
        $pathJson =  ManagementServiceProvider::getScemaPath();
        $resources->instance($pathJson);
        $resources->setNameSpaceModel("\Modules\V1\Entities\\");
        $this->resources = $resources;

        /*
        | ManagementControl
        */
        $this->setSource($resources);
        /*
        | end
        */
    }

    /**
     * .
     * function insert
     * @return void
     */
    public function store(Request $request)
    {
        if (empty($this->resources))
            return response()->json(["error" => "resource not found"],  501);
        $save =  $this->resources->generate_data_insert($request);
        if (!empty($save['status']) && $save['status'] == 200) {
            /*
            | AKTIFKAN JIKA AKAN MEMBUAT ROLE PADA USER
            */
            // $this->create_role_users($save);
            /*
            | end
            */
            return response()->json($save, $save['status'] ?? 401);
        } else {
            return response()->json($save, $save['status'] ?? 401);
        }
    }

    /**
     * .
     * FUNCTION UPDATE DATA
     * @return void
     */
    public function update(Request $request, $id)
    {
        if (empty($this->resources))
            return response()->json(["error" => "resource not found"],  501);
        $request->merge([
            "code_reference" => Str::random(40),
            "role" => "instansi",
        ]);
        $save =  $this->resources->generate_data_update($request, $id);
        return response()->json($save, $save['status'] ?? 401);
    }

    /**
     * .
     * FUNCTION DELETE DATA
     * @return void
     */
    public function delete($id)
    {
        if (empty($this->resources))
            return response()->json(["error" => "resource not found"],  501);
        $hndelAction = $this->resources->deleted($id);
        return response()->json($hndelAction, $hndelAction['status'] ?? 401);
    }
}
