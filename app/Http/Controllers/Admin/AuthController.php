<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginPostRequest;
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
        return view('admin.index');
    }
    
    public function login(AdminLoginPostRequest $request){
        //validate済み
        $datum = $request->validated();
        //認証
        if(Auth::guard('admin')->attempt($datum) === false){
            return back()
                ->withInput()//入力値の保持
                ->withErrors(['auth' => 'ログインIDかパスワードに誤りがあります。',]);//エラーメッセージ
        }
        //
        $request->session()->regenerate();
        return redirect()->intended('/admin/top');
        
    }
    
    public function logout(Request $request){
        Auth::guard('admin')->logout();
        //$request->session()->invalidate();//こちらの全セッション情報破棄する実装は避けています。
        $request->session()->regenerateToken();//CSRFトークンの再生成
        $request->session()->regenerate();//セッションIDの再生成
        return redirect(route('admin.index'));
    }
}

?>