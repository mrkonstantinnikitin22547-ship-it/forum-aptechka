

<?php $__env->startSection('content'); ?>
<div class="topic-show-page">

    <a class="topic-back" href="<?php echo e(route('topics.index')); ?>"><i class="fas fa-sign-out-alt"></i>Назад к темам</a>

    <div class="topic-header">

        <h1 class="topic-title-header">
            <?php echo e($topic->title); ?>

        </h1>

        <span class="topic-date">
            Создано: <?php echo e($topic->created_at->format('d.m.Y H:i')); ?>

        </span>

    </div>

    <div class="topic-show-body">
        <div class="topic-container">

            <div class="messages">

                <?php $__empty_1 = true; $__currentLoopData = $topic->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="message">

                    <div class="message-header">
                        <strong><?php echo e($reply->user->name); ?></strong>

                        <span class="date">
                            <?php echo e($reply->created_at->format('d.m.Y H:i')); ?>

                        </span>
                    </div>

                    <div class="message-body">

                        <div class="message-content">
                            <?php echo $reply->body; ?>

                        </div>

                        <?php if($reply->attachments->count()): ?>
                        <div class="attachments">
                            <?php $__currentLoopData = $reply->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="attachment-item">

                                <?php if(str_starts_with($file->file_type, 'image/')): ?>
                                <a href="<?php echo e(Storage::url($file->file_path)); ?>" target="_blank">
                                    <img
                                        src="<?php echo e(Storage::url($file->file_path)); ?>"
                                        alt="<?php echo e($file->file_name); ?>"
                                        class="attachment-image">
                                </a>
                                <?php else: ?>
                                <a
                                    class="attachment-file"
                                    href="<?php echo e(Storage::url($file->file_path)); ?>"
                                    target="_blank">
                                    📎 <?php echo e($file->file_name); ?>

                                </a>
                                <?php endif; ?>

                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>

                        <div class="message-actions">

                            <button
                                type="button"
                                class="like-btn"
                                onclick="toggleLike(<?php echo e($reply->id); ?>, this)">
                                💚 Нравится
                                <span class="likes-count">
                                    <?php echo e($reply->likes_count ?? 0); ?>

                                </span>
                            </button>

                            <button
                                type="button"
                                class="reply-btn"
                                onclick="replyToUser('<?php echo e($reply->user->name); ?>')">
                                Ответить
                            </button>

                            <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->id() !== $reply->user_id): ?>
                            <button
                                type="button"
                                class="complaint-btn"
                                onclick="openComplaintModal(<?php echo e($reply->id); ?>)">
                                Пожаловаться
                            </button>
                            <?php endif; ?>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>Пока нет сообщений. Будьте первым!</p>
                <?php endif; ?>

            </div>

            <?php if(auth()->guard()->check()): ?>
            <div class="reply-editor-wrapper">

                <form
                    method="POST"
                    action="<?php echo e(route('replies.store', $topic->id)); ?>"
                    enctype="multipart/form-data"
                    onsubmit="return prepareMessage()">

                    <?php echo csrf_field(); ?>

                    <div class="editor-toolbar">

                        <button type="button" onclick="format('bold')" data-tooltip="Жирный">
                            <b>B</b>
                        </button>

                        <button type="button" onclick="format('italic')" data-tooltip="Курсив">
                            <i>I</i>
                        </button>

                        <button type="button" onclick="format('strikeThrough')" data-tooltip="Зачёркнутый">
                            <s>S</s>
                        </button>

                        <div class="align-group">

                            <button type="button" onclick="format('justifyLeft')" data-tooltip="По левому краю">
                                L
                            </button>

                            <button type="button" onclick="format('justifyCenter')" data-tooltip="По центру">
                                C
                            </button>

                            <button type="button" onclick="format('justifyRight')" data-tooltip="По правому краю">
                                R
                            </button>

                            <button type="button" onclick="format('justifyFull')" data-tooltip="По ширине">
                                J
                            </button>

                        </div>
                    </div>

                    <div
                        id="editor"
                        class="editor-textarea"
                        contenteditable="true"
                        placeholder="Напишите сообщение..."></div>

                    <textarea name="body" id="hiddenBody" hidden></textarea>

                    <div class="editor-footer">

                        <div class="fileInput">
                            <label class="attach-btn" for="fileInput">
                                Прикрепить файлы
                            </label>

                            <input
                                type="file"
                                name="attachments[]"
                                multiple
                                hidden
                                id="fileInput"
                                accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar">

                            <div id="filePreview" class="file-preview"></div>
                        </div>

                        <button type="submit" class="submit-btn">
                            Отправить
                        </button>

                    </div>

                </form>

            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="modal-bg" id="complaintModal">
    <div class="modal-window">

        <div class="modal-top">
            <div class="modal-title">Жалоба на сообщение</div>
            <button type="button" class="modal-close" onclick="closeComplaintModal()">✕</button>
        </div>

        <form method="POST" id="complaintForm">
            <?php echo csrf_field(); ?>

            <textarea
                name="reason"
                required
                placeholder="Опишите причину жалобы"></textarea>

            <div class="modal-actions">
                <button type="button" onclick="closeComplaintModal()">Отмена</button>
                <button type="submit">Отправить</button>
            </div>

        </form>

    </div>
</div>

<script>
    function format(command) {
        document.execCommand(command, false, null);
    }

    function prepareMessage() {
        const editor = document.getElementById('editor');
        const hidden = document.getElementById('hiddenBody');

        hidden.value = editor.innerHTML.trim();

        if (hidden.value === '') {
            alert('Введите сообщение');
            return false;
        }

        return true;
    }

    function openComplaintModal(replyId) {
        const modal = document.getElementById('complaintModal');
        const form = document.getElementById('complaintForm');

        form.action = "/replies/" + replyId + "/complaint";
        modal.classList.add('show');
    }

    function closeComplaintModal() {
        document.getElementById('complaintModal').classList.remove('show');
    }

    const fileInput = document.getElementById('fileInput');
    const preview = document.getElementById('filePreview');

    let dt = new DataTransfer();

    if (fileInput && preview) {
        fileInput.addEventListener('change', function() {
            Array.from(this.files).forEach(file => {
                dt.items.add(file);
            });

            this.files = dt.files;
            renderFiles();
        });

        document.addEventListener('DOMContentLoaded', () => {
            preview.style.display = 'none';
        });
    }

    function renderFiles() {
        preview.innerHTML = '';

        if (dt.files.length === 0) {
            preview.style.display = 'none';
            return;
        }

        preview.style.display = 'block';

        Array.from(dt.files).forEach((file, index) => {
            const item = document.createElement('div');
            item.classList.add('file-item');

            item.innerHTML = `
                📎 ${file.name}
                <button type="button" class="remove-file" data-index="${index}">✕</button>
            `;

            preview.appendChild(item);
        });

        document.querySelectorAll('.remove-file').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                let newDt = new DataTransfer();

                Array.from(dt.files).forEach((file, i) => {
                    if (i != index) {
                        newDt.items.add(file);
                    }
                });

                dt = newDt;
                fileInput.files = dt.files;

                renderFiles();
            });
        });
    }

    function replyToUser(name) {
        const editor = document.getElementById('editor');

        editor.focus();

        document.execCommand(
            'insertText',
            false,
            '@' + name + ', '
        );
    }

    function toggleLike(replyId, btn) {
        fetch(`/replies/${replyId}/like`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                const countSpan = btn.querySelector('.likes-count');
                countSpan.textContent = data.count;

                if (data.liked) {
                    btn.classList.add('active-like');
                } else {
                    btn.classList.remove('active-like');
                }
            });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/topics/show.blade.php ENDPATH**/ ?>