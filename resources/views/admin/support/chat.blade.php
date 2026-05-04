@extends('admin.layout')

@section('content')

<h2>Чат с {{ $chat->user->name }}</h2>

<div class="chat-box-admin" id="chatBox" style="max-height: 500px; overflow-y: auto;">

    @foreach($messages as $message)

    <div class="chat-message {{ $message->sender_type }}">

        <div class="message-author">
            {{ $message->sender_type === 'admin' ? 'Админ' : $chat->user->name }}
        </div>

        <div class="message-body">
            {{ $message->message }}
        </div>

    </div>
 
    @endforeach

</div>

<form method="POST" action="{{ route('admin.support.send', $chat->id) }}" class="chat-form-admin">
    @csrf

    <textarea class="form-chat-admin" name="message" placeholder="Напиши сообщение" required></textarea>

    <button type="submit">Отправить</button>
</form>

@endsection

@push('scripts')
<script>
    function forceScrollToBottom() {
        const box = document.getElementById("chatBox");
        if (!box) return;

        // Жёсткий скролл вниз
        box.scrollTop = box.scrollHeight;

        // Повтор через кадр (когда DOM точно дорисован)
        requestAnimationFrame(() => {
            box.scrollTop = box.scrollHeight;
        });

        // И ещё контрольный
        setTimeout(() => {
            box.scrollTop = box.scrollHeight;
        }, 200);
    }

    // 🔥 вызываем несколько раз чтобы гарантированно сработало
    window.addEventListener("load", forceScrollToBottom);
    document.addEventListener("DOMContentLoaded", forceScrollToBottom);
</script>
@endpush