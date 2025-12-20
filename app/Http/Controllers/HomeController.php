<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

/**
 * ホーム画面用コントローラ
 *
 * ・ログインユーザー専用のトップ画面を担当
 * ・メモ一覧の表示
 * ・タグ一覧の表示
 *
 * ※ CRUD や更新処理は MemoController に集約し、
 *   HomeController は「表示専用」に役割を限定している
 */
class HomeController extends Controller
{
    /**
     * 未ログインユーザーのアクセスを防ぐ
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ホーム画面表示
     *
     * ・ログインユーザーのメモ一覧を取得
     * ・有効ステータス（status = 1）のみ表示
     * ・更新日時の降順で並び替え
     * ・タグ一覧もあわせて取得し、画面に渡す
     */
    public function index()
    {
        $memos = Memo::where('user_id', Auth::id())
            ->where('status', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        $tags = Tag::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('home', compact('memos', 'tags'));
    }
}
