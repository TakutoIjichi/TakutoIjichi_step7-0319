@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">

    @csrf

{{-- <input id="product_name" type="text" name="product_name" class="form-control" required> --}}

{{-- // 残りのコード --}}
{{-- <input id="product_name" type="text" name="product_name" class="form-control" required> --}}

@endsection
