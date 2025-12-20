@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row" style="height: 90vh;">

        {{-- 左：タグ一覧 --}}
        <div class="col-2 border-end">
            <h5 class="mt-3">タグ一覧</h5>

            <p>
                <a href="{{ route('home') }}">全て表示</a>
            </p>

            @if(isset($tags) && $tags->count() > 0)
                <ul class="list-group">
                    @foreach ($tags as $t)
                        <li class="list-group-item d-flex justify-content-between align-items-center
                            {{ isset($tag) && $tag->id === $t->id ? 'active' : '' }}">

                            {{-- タグ名（絞り込み） --}}
                            <a href="{{ route('tags.show', $t->id) }}"
                               class="{{ isset($tag) && $tag->id === $t->id ? 'text-white' : '' }}">
                                {{ $t->name }}
                            </a>

                            {{-- タグ削除 --}}
                            <form method="POST"
                                  action="{{ route('tags.destroy', $t->id) }}"
                                  onsubmit="return confirm('このタグを削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger">
                                    ×
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">タグがありません</p>
            @endif
        </div>

        {{-- 中央：メモ一覧 --}}
        <div class="col-4 border-end">
            <div class="mt-3 mb-3">
                <h5 class="mb-0">メモ一覧</h5>
            </div>

            @if(isset($memos) && $memos->count() > 0)
                <ul class="list-group">
                    @foreach ($memos as $memo)
                        <li class="list-group-item">
                            <a href="{{ route('memos.show', $memo->id) }}">
                                {{ \Illuminate\Support\Str::limit($memo->content, 20) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">メモがありません</p>
            @endif
        </div>

        {{-- 右：新規メモ作成 --}}
        <div class="col-6 border-start">
            <div class="mt-3">
                <h5 class="mb-3">新規メモ作成</h5>

                {{-- 成功メッセージ --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- バリデーションエラー --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('memos.store') }}">
                    @csrf

                    <div class="mb-3">
                        <textarea
                            name="content"
                            class="form-control"
                            rows="10"
                            placeholder="メモを入力してください"
                        >{{ old('content') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">タグ</label>
                        <input
                            type="text"
                            name="tag"
                            class="form-control"
                            placeholder="タグを入力"
                            value="{{ old('tag') }}"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">
                        保存
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
