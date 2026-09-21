<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'answer' => 'array',
        ];
    }

    public function submission()
    {
        return $this->belongsTo(FormSubmission::class, 'submission_id');
    }

    public function question()
    {
        return $this->belongsTo(FormQuestion::class, 'question_id');
    }
}
