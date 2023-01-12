<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Rocky\Eloquent\HasDynamicRelation;

use App\Service\Control\Controller as ControllerSource;

class JabatanFungsional extends Model
{
    use HasFactory;
    use HasDynamicRelation;

    // use SoftDeletes;
    public function __construct(array $attributes = [])
    {
        Model::__construct($attributes);
        /*
        |--------------------------------------------------------------------------
        | INSTANCE MODEL GENERATE
        */
        $instace = new ControllerSource("JabatanFungsional");
        $pathJson =  config('generator_crud_config.scema_path');
        $instace->instance($pathJson);
        $instace->setNameSpaceModel("App\Models\\");
        /*
        | end 
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | SETTER DATA MODEL
        */
        $this->fillable = array_merge($instace->getFild());
        $this->table = $instace->table;
        $this->primaryKey = $instace->primary;
        /*
        | end
        |--------------------------------------------------------------------------

        /*
        |--------------------------------------------------------------------------
        | CREATE PROTECTED MODEL
        */
        if ($instace->created_protected()) {
            foreach ($instace->created_protected() as $name_protect => $protect) {
                $this->{$name_protect} = $protect;
            }
        }
        /*
        | end
        |--------------------------------------------------------------------------
       /*

        |--------------------------------------------------------------------------
        | CREATE RELATION FUNCTION
        */
        $this->initial_relation($instace);
        /*
        | end
        |--------------------------------------------------------------------------
        */
    }
    /**
     * .
     * function create relationship
     * @return void
     */
    public function initial_relation($instace)
    {
        if ($instace->getRelation()) {
            foreach ($instace->getRelation() as $model_name) {
                $RelationShip = $instace->getRelationByMethod($model_name);
                if ($RelationShip) {
                    $this->addDynamicRelation($model_name, function (JabatanFungsional $this_model) use ($RelationShip) {
                        return $this_model->{$RelationShip["relation"]}($RelationShip["model"], $RelationShip["foreign"]);
                    });
                }
            }
        }
    }
}
