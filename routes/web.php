<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ホームは index だけ
Route::get('/home', [HomeController::class, 'index'])->name('home');

// メモのCRUDはすべて MemoController
Route::resource('memos', MemoController::class);


// タグで絞り込み
// タグ絞り込み
Route::get('/tags/{tag}', [MemoController::class, 'byTag'])
    ->name('tags.show');
//タグの削除
Route::delete('/tags/{tag}', [MemoController::class, 'destroyTag'])
    ->name('tags.destroy');
