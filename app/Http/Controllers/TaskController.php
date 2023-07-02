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

class TaskController extends Controller{
    /**
     * タスク一覧を表示する
     * 
     * @return \Illuminate\View\View
     * 
    */
    public function list(){
        // 1page辺りの表示アイテム数を設定
        $per_page = 20;
        
        // 一覧の表示
        $list = $this->getListBuilder()
                            ->paginate($per_page);
                        //    ->get();  //get()だと「レコード全件取得」paginate(3)だと指定数分のみデータとして取得し、ページネーションように必要な次へと前へのリンクなどを取得するメソッドを実行する事もできるようにする。
        // $sql = TaskModel::where('user_id', Auth::id())->orderBy('priority','DESC')->orderBy('period')->orderBy('created_at')->toSql();
        // echo "<pre>\n"; var_dump($sql,$list); exit;
        // var_dump($sql);
        return view('task.list', ['list' => $list]);
    }
    
    /**
     * 一覧用の Illuminate\Database\Eloquent\Builder インスタンスの取得
     * かつ、一覧表示とCSVダウンロードの羅列を一致
    */
    public function getListBuilder(){
        return TaskModel::where('user_id', Auth::id())
                            ->orderBy('priority', 'DESC')
                            ->orderBy('period')
                            ->orderBy('created_at');
                            
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
    
    /**
     * タスクの詳細閲覧
    */
    public function detail($task_id){
        //
        return $this->singleTaskRender($task_id,'task.detail');
    }
    
    /**
     * タスクの編集画面表示
    */
    public function edit($task_id){
        // task_idのレコードを取得する
        // テンプレートに「取得したレコード」の情報を渡す
        return $this->singleTaskRender($task_id,'task.edit');
    }
    
    /**
     * タスクの編集処理
    */
    public function editSave(TaskRegisterPostRequest $request,$task_id){
        // formからの情報を取得する
        $datum = $request->validated();
        // task_idのレコードを取得する
        $task = $this->getTaskModel($task_id);
        if($task === null){
            return redirect('/task/list');
        }
        // レコードの内容をUPDATEする
        $task->name = $datum['name'];
        $task->period = $datum['period'];
        $task->detail = $datum['detail'];
        $task->priority = $datum['priority'];
        // レコードを更新
        $task->save();
        // タスク編集成功
        $request->session()->flash('front.task_edit_success',true);
        // 詳細閲覧画面にリダイレクトする
        return redirect(route('detail',['task_id' => $task->id]));
    }
    
    /**
     * 単一のタスクModelの取得
    */
    protected function getTaskModel($task_id){
        //task_idのレコードを取得
        $task = TaskModel::find($task_id);
        if($task === null){
            return null;
        }
        // 本人以外のタスクならNGとする
        if($task->user_id !== Auth::id()){
            return null;
        }
        return $task;
    }
    
    
    
    /**
     * 単一のタスクの表示
    */
    protected function singleTaskRender($task_id, $template_name){
        // task_idのレコードを取得
        $task = $this->getTaskModel($task_id);
        if($task === null){
            return redirect('/task/list');
        }
        //テンプレートに取得したレコードの情報を渡す
        return view($template_name, ['task' => $task]);
    }
    
    /**
     * 削除処理
    */
    public function delete(Request $request, $task_id){
        //task_idのレコードを取得
        $task = $this->getTaskModel($task_id);
        //タスクを削除
        if($task !== null){
            $task->delete();
            $request->session()->flash('front.task_delete_success',true);
        }
        //一覧に遷移する
        return redirect('/task/list');
        
    }
    
    /**
     * タスクの完了
    */
    public function complete(Request $request, $task_id){
        //　タスクを完了テーブルに移動
        // トランザクションはDB::transaction(function () {});ではなく手動入力で作成
        try{
            // トランザクション開始
            DB::beginTransaction();
        
            //task_idのレコードを取得する
            $task = $this->getTaskModel($task_id);
            if($task === null){
                //異常あり　トランザクション終了
                throw new \Exception('');
            }
            //tasks側を削除する
            $task->delete();
            //completed_tasks側にinsert
            $dask_datum = $task->toArray();
            // このままでは、$taskに既に入っている作成日更新日と今から書き込む作成日更新日がダブつくため、前回入力した作成日更新日はなしでもいいので除外
            unset($dask_datum['created_at']);
            unset($dask_datum['updated_at']);
            $r = CompletedTaskModel::create($dask_datum);
            if($r === null){
                //インサート処理失敗してるのでトランザクション終了
                throw new \Exception('');
            }
        
            // トランザクション終了
            DB::commit();
            // 完了メッセージ出力
            $request->session()->flash('front.task_completed_success',true);
        } catch(\Throwable $e){
            // トランザクション異常終了
            DB::rollBack();
            // エラーしロールバックしたメッセージ出力
            $request->session()->flash('front.task_completed_failure',true);
        }
        //一覧に遷移する
        return redirect('/task/list');
    }
    
    /**
     * CSV　ダウンロード
    */
    public function csvDownload(){
        //excelのヘッダーに当たる部分を作る　同時に、記述がないものは取得しないので「不要なデータ出力制限」になる
        $data_list =[
                'id' => 'タスクID',
                'name' => 'タスク名',
                'priority' => '重要度',
                'period' => '期限',
                'detail' => 'タスク詳細',
                'created_at' => 'タスク作成日',
                'updated_at' => 'タスク修正日',
            ];
        //ダウンロードさせたいCSVを作成
        //一覧を取得
        $list = $this->getListBuilder()->get();
        
        //バッファリング開始
        ob_start();
        
        //「書き込み先を出力にした」ファイルハンドルを作成 \SplFileObjectの'php://output'は「echoと同じように出力する」ためのファイル
        $file = new \SplFileObject('php://output', 'w');
        // ヘッダを書き込む
        $file->fputcsv(array_values($data_list));
        //CSVをファイルに書き込む（出力する）
        foreach($list as $datum){
            $awk = [];//作業領域の確保
            // $data_listに書いてある順番に、かいてある要素だけを$awkに格納する
            foreach($data_list as $k => $v){
                if($k === 'priority'){
                    $awk[] = $datum->getPriorityString();
                }else{
                    $awk[] = $datum->$k;
                }
            }
            $file->fputcsv($awk);
        }
        //現在のバッファの中身を取得し、出力バッファを削除する
        $csv_string = ob_get_clean();
        
        //文字コードを変換する　csv:SJIS php:UTF-8のため
        $csv_string_sjis = mb_convert_encoding($csv_string, 'SJIS','UTF-8');
        //　ダウンロードファイルネームの作成
        $download_filename = 'task_list' . date('Ymd') . '.csv';
        //csvを出力
        return response($csv_string_sjis)
                    ->header('Content-Type', 'text/csv')
                    ->header('Content-Disposition', 'attachment; filename="' . $download_filename . '"');
    }
    
}

?>