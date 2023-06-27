<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedTask extends Model
{
    use HasFactory;
    
    /**
     * 複数代入不可能な属性
     * createは「何か書いていないと」エラーになるので、その対策で記載
     * Add [id] to fillable property to allow mass assignment on[]の
    */
    protected $guarded = [];
}
