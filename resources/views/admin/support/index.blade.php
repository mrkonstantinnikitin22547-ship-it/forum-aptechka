@extends('admin.layout')

@section('content')

<h2>Чат с поддержкой</h2>

<div class="chat-list">

    @forelse($chats as $chat)

    <div class="chat-item" style="padding:10px; border-bottom:1px solid #ddd;">

        <div>
            <strong>{{ $chat->user->name }}</strong>
        </div>

        <div class="chat-preview" style="color:gray; font-size:14px;">
            {{ optional($chat->messages->last())->message ?? 'Нет сообщений' }}
        </div>

        <div style="margin-top:8px;">
            <a class="chat-open" href="{{ route('admin.support.show', $chat->id) }}">
                Открыть чат
            </a>
        </div>

    </div>

    @empty

    <p>Пока нет диалогов</p>

    @endforelse

</div>

@endsection