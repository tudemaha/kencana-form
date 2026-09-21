<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
