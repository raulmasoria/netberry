<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_task extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category_id',
        'task_id'
    ];
}
