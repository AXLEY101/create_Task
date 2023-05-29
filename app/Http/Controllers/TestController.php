<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TestPostRequest;

class TestController extends Controller{
    /**
     * トップページを表示する
     * 
     * @return \Illuminate\View\View
     * 
    */
    public function index(){
        return view('test.index');
    }
    /**
     * 入力の受け取りテスト
     * 
     * @return \Illuminate\View\View
     * 
    */
    public function input(TestPostRequest $request){
        //validate済み
        //データの取得
        $validateData = $request->validated();
        
        // var_dump($validateData);
        // exit;
        return view('test.input',['datum' => $validateData]);
    }
    
}

?>