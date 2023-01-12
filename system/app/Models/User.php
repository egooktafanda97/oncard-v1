<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Rocky\Eloquent\HasDynamicRelation;

use App\Service\Control\Controller as ControllerSource;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use HasDynamicRelation;

    // use SoftDeletes;

    public function __construct(array $attributes = [])
    {

        /*
        |--------------------------------------------------------------------------
        | INSTANCE MODEL GENERATE
        */
        $instace = new ControllerSource("User");
        $pathJson =  config('generator_crud_config.scema_path');
        $instace->instance($pathJson);
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
        Model::__construct($attributes);
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
                    $this->addDynamicRelation($model_name, function (User $this_model) use ($RelationShip) {
                        return $this_model->{$RelationShip["relation"]}($RelationShip["model"], $RelationShip["foreign"]);
                    });
                }
            }
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
