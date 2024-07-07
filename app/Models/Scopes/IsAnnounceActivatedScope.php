<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IsAnnounceActivatedScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(function ($query){
            $query->where('is_active', true)->where('end_date', null);
        })->orWhere(function ($query){
            $query->where('end_date','>=',now()->format('Y-m-d'))->where('is_active',true);
        });
    }
}
