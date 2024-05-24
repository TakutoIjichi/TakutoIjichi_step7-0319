<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">

    <title>商品情報一覧</title>
</head>

{{-- ステップ7内容 --}}
@extends('layouts.app')

{{-- 検索フォーム --}}
<div class="search mt-5">

<!-- 検索フォーム。GETメソッドで、商品一覧のルートにデータを送信 -->
<form action="{{ route('products.index') }}" method="GET" class="row g-3">

    <!-- 商品名検索用の入力欄 -->
    <div class="col-sm-12 col-md-3">
        <input type="text" name="search" class="form-control" placeholder="商品名" value="{{ request('search') }}">
    </div>

    <!-- メーカー名検索用の入力欄 -->
    {{-- <div class="col-sm-12 col-md-3">
        <input type="text" name="search" class="form-control" placeholder="メーカー名" value="{{ request('search') }}">
    </div> --}}

    <div class="mb-3">
        {{-- <label for="company_id" class="form-label">メーカー</label> --}}
        <select class="form-select" id="company_id" name="company_id">
            @foreach($companies as $company)
                <option value="{{ $company->id }}" {{isset($company->id) ? 'selected' : '' }}>{{ $company->company_name }}</option>
            @endforeach
        </select>
    </div>


    <!-- 絞り込みボタン -->
    <div class="col-sm-12 col-md-1">
        <button class="btn btn-outline-secondary" type="submit">絞り込み</button>
    </div>
</form>
</div>

{{-- 検索フォームここまで --}}

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報一覧</h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">商品新規登録</a>



    <div class="products mt-5">
        <h2>商品情報</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>メーカー</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>コメント</th>
                    <th>商品画像</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->comment }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm mx-1">編集</a>
                        {{-- <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form> --}}
                    </td>
                    <td>
                    {{-- データを削除するボタンをフォームで作成 --}}
    <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
    </form> 

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
</body>
</html>