<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'description', 'status'])]
class Course extends Model
{
    use HasFactory;

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
