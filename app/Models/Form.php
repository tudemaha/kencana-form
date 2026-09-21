<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasUuids;

    protected static function booted(): void
    {
        static::creating(function (Form $form) {
            $form->nanoid = $form->nanoid ?? Str::random(10);
        });
    }

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tour_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function questions()
    {
        return $this->hasMany(FormQuestion::class);
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }
}
