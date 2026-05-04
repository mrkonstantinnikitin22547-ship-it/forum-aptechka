@extends('admin.layout')

@section('content')

<h1>Управление темами</h1>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
@endif

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Автор</th>
        <th>Дата создания</th>
        <th>Действие</th>
    </tr>

    @forelse($topics as $topic)
    <tr>
        <td>{{ $topic->id }}</td>
        <td>{{ $topic->title }}</td>
        <td>{{ $topic->user->name ?? '—' }}</td>
        <td>{{ $topic->created_at }}</td>
        <td>
            <form method="POST"
                action="{{ route('admin.topics.delete', $topic->id) }}"
                onsubmit="return confirmDelete('тему «{{ $topic->title }}»')">

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
            Тем пока нет
        </td>
    </tr>
    @endforelse

</table>

@endsection