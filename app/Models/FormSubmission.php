<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function answers()
    {
        return $this->hasMany(FormAnswer::class, 'submission_id');
    }
}
