<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedTask as CompletedTaskModel;
use App\Http\Requests\UserRegisterPostRequest;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
    /**
     * タスク一覧を表示する
     * 
     * @return \Illuminate\View\View
     * 
    */
    public function index(){
        return view('user.register');
    }
    
    
    
    public function register(UserRegisterPostRequest $request){
        //validate済みデータの取得
        $datum = $request->validated();
        
        // $user = Auth::user();
        // $id = Auth::id();
        // var_dump($datum,$user,$id); exit;
        
        //パスワードをハッシュ化
        $datum['password'] = Hash::make($datum['password']);
        
        //テーブルへのinsert
        try{
            $r = UserModel::create($datum);
        } catch(\Throwable $e){
            // ここで実際にはエラーログなどに書く処理をする 今回は出力のみ
            echo $e->getMessage();
            exit;
        }
        
        // タスク登録成功
        $request->session()->flash('front.user_register_success',true);
        
        //
        return redirect('/');
        
    }
    
    
    
}

?>