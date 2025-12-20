@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card w-100">
                <div class="card-header">新規メモ作成</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('memos.store') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <textarea name="content" class="form-control" rows="8" placeholder="メモを入力してください"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            保存する
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
