@extends('layouts.app')

@section('title', 'Темы - Аптечка')

@section('content')
<h1 class="page-title">Темы</h1>
<div class="content-layout">
    <div class="main-area_topics">
        <div class="topics-grid" id="topicsGrid">
            @forelse($topics as $topic)
            @include('partials.topic_card', ['topic' => $topic])
            @empty
            <p>Пока нет публикаций.</p>
            @endforelse
        </div>
    </div>

    <aside class="sidebar">
        <div class="widget home-glass create-widget">
            @auth
            <button id="openCreatePostModal" class="create-topic-btn">
                Создать тему
            </button>
            @else
            <button type="button" id="open-login-from-topics" class="create-topic-btn">
                Войти, чтобы создать
            </button>
            @endauth
        </div>

    </aside>
</div>

<div class="cp-modal-bg" id="createPostModalBg" aria-hidden="true">
    <div class="cp-modal">
        <div class="cp-modal-head">
            <div class="cp-modal-title">Создать тему</div>
            <button type="button" class="cp-close" id="closeCreatePostModal">✕</button>
        </div>

        @auth
        <form id="createTopicForm" method="POST" action="{{ route('topics.store') }}">
            @csrf

            <label class="cp-label">Название темы</label>
            <input class="cp-input"
                type="text"
                name="title"
                placeholder="Введите название..."
                minlength="3"
                maxlength="55"
                required>

            <div class="cp-actions">
                <button type="button" class="cp-cancel" id="cancelCreatePostModal">Отмена</button>
                <button type="submit" class="cp-submit">Создать</button>
            </div>
        </form>
        @endauth
    </div>
</div>

<script>
    (function() {
        const openBtn = document.getElementById('openCreatePostModal');
        const bg = document.getElementById('createPostModalBg');
        const closeBtn = document.getElementById('closeCreatePostModal');
        const cancelBtn = document.getElementById('cancelCreatePostModal');

        if (!bg) return;

        function openModal() {
            bg.classList.add('show');
            bg.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            bg.classList.remove('show');
            bg.setAttribute('aria-hidden', 'true');
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

        bg.addEventListener('click', (e) => {
            if (e.target === bg) closeModal();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        // ✅ AJAX создание темы + вставка карточки
        const form = document.getElementById('createTopicForm');
        const grid = document.getElementById('topicsGrid');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (form && grid) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(form);

                try {
                    const res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await res.json();

                    if (!res.ok || !data.ok) {
                        const msg =
                            data?.message ||
                            (data?.errors ? Object.values(data.errors).flat().join('\n') : 'Ошибка создания публикации');
                        alert(msg);
                        return;
                    }

                    // вставляем карточку первой в списке
                    grid.insertAdjacentHTML('afterbegin', data.card_html);

                    form.reset();
                    closeModal();
                } catch (err) {
                    console.error(err);
                    alert('Ошибка сети/сервера при создании публикации');
                }
            });
        }
    })();
    const openLoginFromTopics = document.getElementById('open-login-from-topics');
    const headerLoginButton = document.getElementById('open-login-modal');

    if (openLoginFromTopics && headerLoginButton) {
        openLoginFromTopics.addEventListener('click', function() {
            headerLoginButton.click(); // просто имитируем клик
        });
    }
</script>


@endsection