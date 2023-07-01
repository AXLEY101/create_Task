<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User as UserModel;

class UserController extends Controller{
    /**
     * トップページを表示する
     * 
     * @return \Illuminate\View\View
     * 
    */
    
    public function list(){
        $group_by_column = ['users.id','users.name'];
        $list = UserModel::select($group_by_column)
                        ->selectRaw('count(tasks.id) AS task_num')//Rawが付くメソッドは危険なので、外部からの変数は絶対に埋め込まない事
                        ->leftJoin('tasks','users.id','=','tasks.user_id')
                        ->groupBy($group_by_column)
                        ->orderBy('users.id')
                        ->get();
                        
      return view('admin.user.list',['users' => $list]);
    }
}

?>