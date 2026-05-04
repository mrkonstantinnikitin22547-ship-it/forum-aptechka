@extends('admin.layout')

@section('content')

<h1>Просмотр сообщения</h1>

<p><strong>Имя:</strong> {{ $message->first_name }} {{ $message->last_name }}</p>
<p><strong>Email:</strong> {{ $message->email }}</p>
<p><strong>Дата:</strong> {{ $message->created_at }}</p>

<hr>

<p>{{ $message->message }}</p>

<br>
<a href="{{ route('admin.messages') }}"><button class="admin-btn">Назад</button></a>

@endsection