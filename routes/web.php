<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

// テスト
use App\Models\Company;

Route::get('/companies', function () {
    // Companyモデルから全てのレコードを取得
    $companies = Company::all();

    // index.blade.phpに$companiesを渡す
    return view('index', ['companies' => $companies]);
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// step7内容
Route::get('/', function () {
    // ウェブサイトのホームページ（'/'のURL）にアクセスした場合のルートです
    if (Auth::check()) {
        // ログイン状態ならば
        return redirect()->route('products.index');
        // 商品一覧ページ（ProductControllerのindexメソッドが処理）へリダイレクトします
    } else {
        // ログイン状態でなければ
        return redirect()->route('login');
        //　ログイン画面へリダイレクトします
    }
});
// // もしCompanyControllerだった場合は
// // companies.index のように、英語の正しい複数形になります。


Auth::routes();

// // Auth::routes();はLaravelが提供している便利な機能で
// // 一般的な認証に関するルーティングを自動的に定義してくれます
// // この一行を書くだけで、ログインやログアウト
// // パスワードのリセット、新規ユーザー登録などのための
// // ルートが作成されます。
// //　つまりログイン画面に用意されたビューのリンク先がこの1行で済みます

// Route::group(['middleware' => 'auth'], function () {
//     Route::resource('products', ProductController::class);

// });

// // Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/product', [ProductController::class, 'index'])->name('product');

// テスト
// 商品一覧表示
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品作成フォーム表示
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// 商品作成
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// 商品詳細表示
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// 商品編集フォーム表示
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// 商品更新
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// 商品削除
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
