@extends('admin.layout')

@section('content')

<h1>Сообщения обратной связи</h1>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
@endif

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Дата</th>
        <th>Действия</th>
    </tr>

    @forelse($messages as $message)
    <tr>
        <td>{{ $message->id }}</td>
        <td>{{ $message->first_name }} {{ $message->last_name }}</td>
        <td>{{ $message->email }}</td>
        <td>{{ $message->created_at }}</td>
        <td>
            <a href="{{ route('admin.messages.show', $message->id) }}">
                <button class="admin-btn">Открыть</button>
            </a>

            <form method="POST"
                action="{{ route('admin.messages.delete', $message->id) }}"
                onsubmit="return confirmDelete('сообщение #{{ $message->id }}')">

                @csrf
                @method('DELETE')

                <button type="submit" class="admin-btn">
                    Удалить
                </button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" style="text-align:center; padding:20px;">
            Сообщений пока нет
        </td>
    </tr>
    @endforelse

</table>

@endsection