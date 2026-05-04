@extends('layouts.app')

@section('content')

<div class="topics-page">

    <div class="topics-header">
        <h1 class="topics-title">Темы</h1>
    </div>

    {{-- 📋 СПИСОК ТЕМ --}}
    <div class="topics-list">

        @forelse($topics as $topic)

            <a class="topic-card" href="{{ route('topics.show', $topic) }}">
                <div class="topic-card-title">{{ $topic->title }}</div>
                <div class="topic-card-date">
                    {{ $topic->created_at->format('d.m.Y H:i') }}
                </div>
            </a>

        @empty
            <div class="topics-empty">
                Пока нет публикаций. Создай первую 🙂
            </div>
        @endforelse

    </div>

    <div class="topics-pagination">
        {{ $topics->links() }}
    </div>

</div>

{{-- 🧾 МОДАЛКА СОЗДАНИЯ ТЕМЫ --}}
<div class="modal-bg" id="createModalBg">
    <div class="modal-window">

        <div class="modal-top">
            <div class="modal-title">Создание темы</div>
            <button class="modal-close" id="closeCreateModal">✕</button>
        </div>

        <form method="POST" action="{{ route('topics.store') }}">
            @csrf

            {{-- 📌 НАЗВАНИЕ --}}
            <label class="modal-label">Название темы</label>
            <input type="text"
                   name="title"
                   class="modal-input"
                   placeholder="Например: Как выбрать витамины?"
                   required
                   minlength="3"
                   maxlength="150">

            {{-- 📝 ТЕКСТ ТЕМЫ (ДОБАВЛЕНО) --}}
            <label class="modal-label">Текст темы</label>
            <textarea
                   name="content"
                   class="modal-input"
                   placeholder="Опишите вашу проблему или вопрос..."
                   required
                   rows="5"
            ></textarea>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="cancelModal">Отмена</button>
                <button type="submit" class="btn-create">Создать</button>
            </div>

        </form>

    </div>
</div>

<script>
const openBtn = document.getElementById('openCreateModal');
const modalBg = document.getElementById('createModalBg');
const closeBtn = document.getElementById('closeCreateModal');
const cancelBtn = document.getElementById('cancelModal');

function openModal() {
    modalBg.classList.add('show');
}

function closeModal() {
    modalBg.classList.remove('show');
}

openBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
cancelBtn.addEventListener('click', closeModal);

modalBg.addEventListener('click', (e) => {
    if (e.target === modalBg) closeModal();
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
});
</script>

@endsection