@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card w-100">
                <div class="card-header">
                    メモ編集
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('memos.update', $memo->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- 内容 --}}
                        <div class="mb-3">
                            <label class="form-label">内容</label>
                            <textarea
                                name="content"
                                class="form-control"
                                rows="8"
                            >{{ old('content', $memo->content) }}</textarea>
                        </div>

                        {{-- タグ --}}
                        <div class="mb-3">
                            <label class="form-label">タグ</label>
                            <input
                                type="text"
                                name="tag"
                                class="form-control"
                                value="{{ old('tag', optional($memo->tag)->name) }}"
                            >
                        </div>

                        <button type="submit" class="btn btn-primary">
                            更新する
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
