<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Company;
use Illuminate\Http\Request; 

class ProductController extends Controller 
{


    public function index(Request $request)
    {
        $products = Product::all();
        $companies = Company::all();
        $query = Product::query();

        // if ($search = $request->search) {
        //     $query->where('product_name', 'LIKE', "%{$search}%");
        // }

        // return view('index', [
        //     'products' => $products,
        //     'companies' => $companies,
        // ]);
        
        // テスト
        if ($request->has('product_name')) {
            $query->where('product_name', 'like', '%'.$request->input('product_name').'%');
        }
        
        if ($request->has('company_name')) {
            $query->where('company_name', 'like', '%'.$request->input('company_name').'%');
        }
        
        $results = $query->get();
        
        return view('index', [
            'products' => $products,
            'companies' => $companies,
        ]);
        
    }


    public function create()
    {
        // 商品作成画面で会社の情報が必要なので、全ての会社の情報を取得します。
        $companies = Company::all();

        // 商品作成画面を表示します。その際に、先ほど取得した全ての会社情報を画面に渡します。
        return view('create', compact('companies'));
    }

    // 送られたデータをデータベースに保存するメソッドです
    public function store(Request $request) // フォームから送られたデータを　$requestに代入して引数として渡している
    {
        $request->validate([
            'product_name' => 'required', //requiredは必須という意味です
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', //'nullable'はそのフィールドが未入力でもOKという意味です
            'img_path' => 'nullable|image|max:2048',
        ]);

        // 新しく商品を作ります。そのための情報はリクエストから取得します。
        try {
            $product = new Product([
                'product_name' => $request->get('product_name'),
                'company_id' => $request->get('company_id'),
                'price' => $request->get('price'),
                'stock' => $request->get('stock'),
                'comment' => $request->get('comment'),
            ]);
            //new Product([]) によって新しい「Product」（レコード）を作成しています。
            //new を使うことで新しいインスタンスを作成することができます



            // リクエストに画像が含まれている場合、その画像を保存します。
            if ($request->hasFile('img_path')) {
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('products', $filename, 'public');
                $product->img_path = '/storage/' . $filePath;
            }
            // 作成したデータベースに新しいレコードとして保存します。
            $product->save();

            // 全ての処理が終わったら、商品一覧画面に戻ります。
            return redirect('products');
        } catch (\Exception $e) {
            return response()->json(['error' => 'エラーが発生しました: ' . $e->getMessage()], 500);
        }
    }



    public function show(Product $product)
    //(Product $product) 指定されたIDで商品をデータベースから自動的に検索し、その結果を $product に割り当てます。
    {
        // 商品詳細画面を表示します。その際に、商品の詳細情報を画面に渡します。
        return view('show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        // 商品編集画面で会社の情報が必要なので、全ての会社の情報を取得します。
        $companies = Company::all();

        // 商品編集画面を表示します。その際に、商品の情報と会社の情報を画面に渡します。
        return view('edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        // リクエストされた情報を確認して、必要な情報が全て揃っているかチェックします。
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        //バリデーションによりフォームに未入力項目があればエラーメッセー発生させる（未入力です　など）

        // 商品の情報を更新します。
        try {
            $product->product_name = $request->product_name;
            //productモデルのproduct_nameをフォームから送られたproduct_nameの値に書き換える
            $product->price = $request->price;
            $product->stock = $request->stock;

            // 更新した商品を保存します。
            $product->save();
            // モデルインスタンスである$productに対して行われた変更をデータベースに保存するためのメソッド（機能）です。

            // 全ての処理が終わったら、商品一覧画面に戻ります。
            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully');
            // ビュー画面にメッセージを代入した変数(success)を送ります
        } catch (\Exception $e) {
            return response()->json(['error' => 'エラーが発生しました: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Product $product)
    //(Product $product) 指定されたIDで商品をデータベースから自動的に検索し、その結果を $product に割り当てます。
    {
        // 商品を削除します。
        try {
            $product->delete();
            // 全ての処理が終わったら、商品一覧画面に戻ります。
            return redirect('/products');
            //URLの/productsを検索します
            //products　/がなくても検索できます
        } catch (\Exception $e) {
            return response()->json(['error' => 'エラーが発生しました: ' . $e->getMessage()], 500);
        }
    }
}
