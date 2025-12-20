<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemoController extends Controller
{
    /**
     * 認証必須
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ※ index は使わない（一覧は HomeController）
     */
    public function index()
    {
        abort(404);
    }

    /**
     * メモ詳細
     */
    public function show(Memo $memo)
    {
        $this->checkOwner($memo);

        return view('memos.show', compact('memo'));
    }

    /**
     * 新規作成フォーム
     */
    public function create()
    {
        return view('memos.create');
    }

    /**
     * 保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'tag'     => 'nullable|string|max:50',
        ]);

        // タグ処理
        $tagId = null;

        if (!empty($validated['tag'])) {
            $tag = Tag::firstOrCreate([
                'name'    => $validated['tag'],
                'user_id' => Auth::id(),
            ]);
            $tagId = $tag->id;
        }

        Memo::create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'tag_id'  => $tagId,
            'status'  => 1,
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'メモを登録しました');
    }

    /**
     * 編集フォーム
     */
    public function edit(Memo $memo)
    {
        $this->checkOwner($memo);

        return view('memos.edit', compact('memo'));
    }

    /**
     * 更新
     */
    public function update(Request $request, Memo $memo)
    {
        $this->checkOwner($memo);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'tag'     => 'nullable|string|max:50',
        ]);

        $tagId = null;

        if (!empty($validated['tag'])) {
            $tag = Tag::firstOrCreate([
                'name'    => $validated['tag'],
                'user_id' => Auth::id(),
            ]);
            $tagId = $tag->id;
        }

        $memo->update([
            'content' => $validated['content'],
            'tag_id'  => $tagId,
        ]);

        return redirect()
            ->route('home')
            ->with('success', '更新しました');
    }

    /**
     * 削除（論理削除想定）
     */
    public function destroy(Memo $memo)
    {
        $this->checkOwner($memo);

        $memo->delete();

        return redirect()
            ->route('home')
            ->with('success', '削除しました');
    }



    /**
     * タグ削除（メモは残す）
     */
    public function destroyTag(Tag $tag)
    {
        // 他人のタグは削除不可
        if ($tag->user_id !== Auth::id()) {
            abort(403);
        }

        DB::transaction(function () use ($tag) {
            // このタグが付いているメモを解除
            Memo::where('user_id', Auth::id())
                ->where('tag_id', $tag->id)
                ->update(['tag_id' => null]);

            // タグ削除
            $tag->delete();
        });

        return redirect()
            ->route('home')
            ->with('success', 'タグを削除しました');
    }

                /**
             * タグでメモを絞り込み
             */
            public function byTag(Tag $tag)
            {
                // 他人のタグは見せない
                if ($tag->user_id !== Auth::id()) {
                    abort(403);
                }

                $memos = Memo::where('user_id', Auth::id())
                    ->where('tag_id', $tag->id)
                    ->latest()
                    ->get();

                return view('home', compact('memos'));
            }


    /**
     * 所有者チェック（共通）
     */
    private function checkOwner(Memo $memo)
    {
        if ($memo->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
