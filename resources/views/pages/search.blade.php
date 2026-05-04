@extends('layouts.app')

@section('content')
<div class="container-search">

    <h1>Результаты поиска</h1>

    @if($query)
        <p>Вы искали: <strong>{{ $query }}</strong></p>
    @endif

    @if($topics->count())
        <div class="topics-list">
            @foreach($topics as $topic)
                <div class="topic-card-search">
                    <h3>
                        <a class="search-link" href="{{ route('topics.show', $topic->id) }}">
                            {{ $topic->title }}
                        </a>
                    </h3>

                    <p>
                        {{ \Illuminate\Support\Str::limit($topic->content, 150) }}
                    </p>
                </div>
            @endforeach
        </div>

        {{ $topics->withQueryString()->links() }}

    @else
        <p>Ничего не найдено 😢</p>
    @endif

</div>
@endsection