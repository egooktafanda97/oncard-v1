<?php

namespace App\Traits;

use Rocky\Eloquent\HasDynamicRelation;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

trait ManagementModel
{
    use HasDynamicRelation;
    use LogsActivity;

    /**
     * .
     * function create relationship
     * @return void
     */
    public function initial_function_relationship($model, $instace)
    {
        if ($instace->getRelation()) {
            foreach ($instace->getRelation() as $model_name) {
                $RelationShip = $instace->getRelationByMethod($model_name);
                if ($RelationShip) {
                    $model->addDynamicRelation($model_name, function ($this_model) use ($RelationShip) {
                        return $this_model->{$RelationShip["relation"]}($RelationShip["model"], $RelationShip["foreign"]);
                    });
                }
            }
        }
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
