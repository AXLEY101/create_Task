<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;

class TaskController extends Controller{
    /**
     * タスク一覧を表示する
     * 
     * @return \Illuminate\View\View
     * 
    */
    public function list(){
        // 一覧の表示
        $list = TaskModel::where('user_id', Auth::id())
                            ->orderBy('priority','DESC')
                            ->orderBy('period')
                            ->orderBy('created_at')
                            ->get();
        // $sql = TaskModel::where('user_id', Auth::id())->orderBy('priority','DESC')->orderBy('period')->orderBy('created_at')->toSql();
        // echo "<pre>\n"; var_dump($sql,$list); exit;
        // var_dump($sql);
        return view('task.list', ['list' => $list]);
    }
    
    public function register(TaskRegisterPostRequest $request){
        //validate済みデータの取得
        $datum = $request->validated();
        
        // $user = Auth::user();
        // $id = Auth::id();
        // var_dump($datum,$user,$id); exit;
        // user_idの追加
        $datum['user_id'] = Auth::id();
        
        //テーブルへのinsert
        try{
            $r = TaskModel::create($datum);
        } catch(\Throwable $e){
            // ここで実際にはエラーログなどに書く処理をする 今回は出力のみ
            echo $e->getMessage();
            exit;
        }
        
        // タスク登録成功
        $request->session()->flash('front.task_register_success',true);
        
        //
        return redirect('/task/list');
        
    }
    
}

?>