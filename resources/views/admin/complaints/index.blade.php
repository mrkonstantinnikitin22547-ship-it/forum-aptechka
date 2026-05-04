@extends('admin.layout')

@section('content')

    <h1>Жалобы</h1>

<div class="table-wrapper">

    <table class="admin-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>От пользователя</th>
                <th>На пользователя</th>
                <th>Тема</th>
                <th>Сообщение</th>
                <th>Причина</th>
                <th>Дата</th>
                <th>Действие</th>
            </tr>
        </thead>

        <tbody>

        @forelse($complaints as $complaint)

            <tr>
                <td>{{ $complaint->id }}</td>

                <td>{{ $complaint->fromUser->name ?? '-' }}</td>

                <td>{{ $complaint->toUser->name ?? '-' }}</td>

                <td>{{ $complaint->reply->topic->title ?? 'Удалена тема' }}</td>

                <td>
                    {{ \Illuminate\Support\Str::limit($complaint->reply->body ?? '', 50) }}
                </td>

                <td>{{ $complaint->reason }}</td>

                <td>{{ $complaint->created_at->format('d.m.Y H:i') }}</td>

                <td>
                    <form method="POST"
                          action="{{ route('admin.complaints.delete', $complaint->id) }}">
                        @csrf
                        @method('DELETE')

                        <button class="admin-btn">
                            Удалить
                        </button>
                    </form>
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="8" style="text-align:center;">
                    Жалоб пока нет
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection