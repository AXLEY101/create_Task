@extends('layout')
{{-- メインコンテンツ --}}
@section('title')
(詳細画面)
@endsection
@section('contets')

        <h1>完了タスク一覧</h1>
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
            @if(session('front.task_delete_success') == true)
                タスクを削除しました！<br>
            @endif
            @if(session('front.task_completed_success') == true)
                タスクを完了に移動しました<br>
            @endif
            @if(session('front.task_completed_failure') == true)
                タスクの完了で問題が発生しました<br>
            @endif
         
        
        <a href="/task/list">タスク一覧</a>
        <table border="1">
            <tr>
                <th>タスク名
                <th>期限
                <th>重要度
                <th>タスク終了日
            @foreach($list as $task)
                <tr>
                    <td>{{ $task->name }}
                    <td>{{ $task->period }}
                    <td>{{ $task->getPriorityString() }}
                    <td>{{ $task->created_at }}
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