<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller{
    /**
     * トップページを表示する
     * 
     * @return \Illuminate\View\View
     * 
    */
    public function index(){
        return view('index');
    }
    
    public function login(LoginPostRequest $request){
        //validate済み
        $datum = $request->validated();
        
        //
        //var_dump($datum); exit;
        if(Auth::attempt($datum) === false){
            return back()
                ->withInput()//入力値の保持
                ->withErrors(['auth' => 'emailかパスワードに誤りがあります。',]);//エラーメッセージ
                
        
        }
        //
        $request->session()->regenerate();
        return redirect()->intended('/task/list');
        
    }
    
    public function logout(Request $request){
        Auth::logout();
        //$request->session()->invalidate();//こちらの全セッション情報破棄する実装は避けています。
        $request->session()->regenerateToken();//CSRFトークンの再生成
        $request->session()->regenerate();//セッションIDの再生成
        return redirect(route('front.index'));
    }
    
}

?>