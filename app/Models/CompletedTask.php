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
    
    /**
     * 重要度用の定数
    */
    const PRIORITY_VALUE = [
            1 => '低い',
            2 => '普通',
            3 => '高い',
        ];
    
    /**
     * 重要度の文字列を取得
     * 
    */
    public function getPriorityString(){
        return $this::PRIORITY_VALUE[$this->priority] ?? '';
    }
    
}
