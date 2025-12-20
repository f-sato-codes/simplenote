<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'SimpleNote') }}</title>

    <!-- Bootstrap & App CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            background: #f8fafc;
        }
        .welcome-box {
            margin-top: 120px;
        }
    </style>
</head>
<body>

<div class="container welcome-box">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h3 class="mb-0">{{ config('app.name', 'SimpleNote') }}</h3>
                </div>

                <div class="card-body text-center">

                    <p class="mb-4">
                        シンプルにメモを残し、<br>
                        タグで整理できる Laravel 学習用メモアプリです。
                    </p>

                    @auth
                        {{-- ログイン済み --}}
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            ホームへ
                        </a>
                    @else
                        {{-- 未ログイン --}}
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            ログイン
                        </a>

                        @if (Route::has('register'))
                            <div class="mt-3">
                                <a href="{{ route('register') }}">
                                    はじめての方はこちら（新規登録）
                                </a>
                            </div>
                        @endif
                    @endauth

                </div>
            </div>

        </div>
    </div>
</div>

<!-- App JS -->
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
