@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card w-100">
                <div class="card-header">
                    メモ詳細
                </div>

                <div class="card-body">

                    {{-- 本文 --}}
                    <div class="mb-3 p-3 border rounded">
                        {{ $memo->content }}
                    </div>

                    {{-- タグ --}}
                    <div class="mb-3">
                        <strong>タグ：</strong>
                        @if ($memo->tag)
                            <span class="badge bg-secondary">
                                {{ $memo->tag->name }}
                            </span>
                        @else
                            <span class="text-muted">なし</span>
                        @endif
                    </div>

                    {{-- 操作 --}}
                    <div class="d-flex gap-2">

                        <a href="{{ route('memos.edit', $memo->id) }}"
                           class="btn btn-primary">
                            編集
                        </a>

                        <a href="{{ route('home') }}"
                           class="btn btn-secondary">
                            一覧へ戻る
                        </a>

                        <form action="{{ route('memos.destroy', $memo->id) }}"
                              method="POST"
                              onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                削除
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
