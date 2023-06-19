@extends('layout')
{{-- メインコンテンツ --}}
@section('title')
(詳細画面)
@endsection
@section('contets')

        <h1>タスクの登録</h1>
            @if($errors->any())
                <div>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
        
            @if(session('front.task_register_success') == true)
                タスクを登録しました！<br>
            @endif
            
            <form action="/task/register" method="post">
                @csrf
                タスク名：<input name="name" value="{{ old('name') }}"><br>
                期限：<input type="date" name="period" value="{{ old('period') }}"><br>
                タスク詳細：<textarea name="detail">{{ old('detail') }}</textarea><br>
                重要度：<label><input type="radio" name="priority" value="1" @if (old('priority') == 1) checked @endif>低い</label> / 
                    <lavel><input type="radio" name="priority" value="2" @if (old('priority',2) == 2) checked @endif>普通</lavel> / 
                    <label><input type="radio" name="priority" value="3" @if (old('priority') == 3) checked @endif>高い</label><br>
                <button>タスクを登録する</button>
            </form>
            
        <h1>タスクの一覧</h1>
        <a href="./top.html">CSVダウンロード</a><br>
        <table border="1">
            <tr>
                <th>タスク名
                <th>期限
                <th>重要度
            @foreach($list as $task)
                <tr>
                    <td>{{ $task->name }}
                    <td>{{ $task->period }}
                    <td>{{ $task->getPriorityString() }}
                    <td><a href="{{ route('detail', ['task_id' => $task->id]) }}">詳細閲覧</a>
                    <td><a href="{{ route('edit',['task_id' => $task->id]) }}">編集</a>
                    <td><form action="./top.html"><button>完了</button></form>
            @endforeach
        </table>
        <!-- ページネーション -->
        現在{{ $list->currentPage() }}ページ目<br>
        @if($list->onFirstPage() === false)
        <a href="/task/list">最初のページ</a>
        @else
        最初のページ
        @endif
        /
        @if($list->previousPageUrl() !== null)
        <a href="{{ $list->previousPageUrl() }}">前に戻る</a>
        @else
        前に戻る
        @endif
        /
        @if($list->nextPageUrl() !== null)
        <a href="{{ $list->nextPageUrl() }}">次に進む</a>
        @else
        次に進む
        @endif
        <br>
        <hr>
        <menu label="リンク">
            <a href="/logout">ログアウト</a><br>
        </menu>
@endsection