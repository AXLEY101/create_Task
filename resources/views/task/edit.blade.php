@extends('layout')
{{-- メインコンテンツ --}}
@section('title')
(詳細画面)
@endsection
@section('contets')

        <h1>タスクの編集</h1>
            @if($errors->any())
                <div>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('edit_save',['task_id' => $task->id]) }}" method="post">
                @csrf
                @method("PUT")
                タスク名：<input name="name" value="{{ old('name') ?? $task->name }}"><br>
                期限：<input type="date" name="period" value="{{ old('period') ?? $task->period }}"><br>
                タスク詳細：<textarea name="detail">{{ old('detail') ?? $task->detail }}</textarea><br>
                重要度：<label><input type="radio" name="priority" value="1" @if (old('priority') ?? $task->priority == 1) checked @endif>低い</label> / 
                    <lavel><input type="radio" name="priority" value="2" @if (old('priority') ?? $task->priority == 2) checked @endif>普通</lavel> / 
                    <label><input type="radio" name="priority" value="3" @if (old('priority') ?? $task->priority == 3) checked @endif>高い</label><br>
                <button>タスクを編集する</button>
            </form>
            
        
        <hr>
        <menu label="リンク">
            <a href="/task/list">タスク一覧</a><br>
            <a href="/logout">ログアウト</a><br>
        </menu>
@endsection