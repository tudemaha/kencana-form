<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FormQuestion extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'choices' => 'array',
        ];
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function answers()
    {
        return $this->hasMany(FormAnswer::class, 'question_id');
    }
}
