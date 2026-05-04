@php
/** @var \App\Models\Topic $topic */
@endphp

<a href="{{ route('topics.show', $topic) }}"
    class="topic-card-glass">

    <div class="topic-card-inner">

        <div class="topic-title">
            {{ $topic->title }}
        </div>

        <!-- <div class="topic-green-line"></div> -->
        <div class="topic-status" >
            <div class="topic-meta">
                <span>{{ $topic->created_at?->format('d.m.Y H:i') }}</span><br>
                <span>Автор: {{ $topic->user?->display_name ?? $topic->user?->name ?? '—' }}</span>
            </div>

            <div class="topic-stats">
                <span>💬 {{ $topic->replies_count ?? 0 }}</span>
                <span>👁 {{ $topic->views_count ?? 0 }}</span>
            </div>
        </div>

    </div>

</a>