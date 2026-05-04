

<?php $__env->startSection('title', 'Темы - Аптечка'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="page-title">Темы</h1>
<div class="content-layout">
    <div class="main-area_topics">
        <div class="topics-grid" id="topicsGrid">
            <?php $__empty_1 = true; $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php echo $__env->make('partials.topic_card', ['topic' => $topic], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>Пока нет публикаций.</p>
            <?php endif; ?>
        </div>
    </div>

    <aside class="sidebar">

        
        <div class="widget home-glass create-widget">
            <?php if(auth()->guard()->check()): ?>
            <button id="openCreatePostModal" class="create-topic-btn">
                Создать тему
            </button>
            <?php else: ?>
            <button type="button" id="open-login-from-topics" class="create-topic-btn">
                Войти, чтобы создать
            </button>
            <?php endif; ?>
        </div>

    </aside>
</div>



<div class="cp-modal-bg" id="createPostModalBg" aria-hidden="true">
    <div class="cp-modal">
        <div class="cp-modal-head">
            <div class="cp-modal-title">Создать тему</div>
            <button type="button" class="cp-close" id="closeCreatePostModal">✕</button>
        </div>

        <?php if(auth()->guard()->check()): ?>
        <form id="createTopicForm" method="POST" action="<?php echo e(route('topics.store')); ?>">
            <?php echo csrf_field(); ?>

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
        <?php endif; ?>
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


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/pages/topics.blade.php ENDPATH**/ ?>