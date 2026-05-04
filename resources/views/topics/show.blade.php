@extends('layouts.app')

@section('content')
<div class="topic-show-page">

    <a class="topic-back" href="{{ route('topics.index') }}"><i class="fas fa-sign-out-alt"></i>Назад к темам</a>

    <div class="topic-header">

        <h1 class="topic-title-header">
            {{ $topic->title }}
        </h1>

        <span class="topic-date">
            Создано: {{ $topic->created_at->format('d.m.Y H:i') }}
        </span>

    </div>

    <div class="topic-show-body">
        <div class="topic-container">

            <div class="messages">

                @forelse($topic->replies as $reply)

                <div class="message">

                    <div class="message-header">
                        <strong>{{ $reply->user->name }}</strong>

                        <span class="date">
                            {{ $reply->created_at->format('d.m.Y H:i') }}
                        </span>
                    </div>

                    <div class="message-body">

                        <div class="message-content">
                            {!! $reply->body !!}
                        </div>

                        @if($reply->attachments->count())
                        <div class="attachments">
                            @foreach($reply->attachments as $file)
                            <div class="attachment-item">

                                @if(str_starts_with($file->file_type, 'image/'))
                                <a href="{{ Storage::url($file->file_path) }}" target="_blank">
                                    <img
                                        src="{{ Storage::url($file->file_path) }}"
                                        alt="{{ $file->file_name }}"
                                        class="attachment-image">
                                </a>
                                @else
                                <a
                                    class="attachment-file"
                                    href="{{ Storage::url($file->file_path) }}"
                                    target="_blank">
                                    📎 {{ $file->file_name }}
                                </a>
                                @endif

                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="message-actions">

                            <button
                                type="button"
                                class="like-btn"
                                onclick="toggleLike({{ $reply->id }}, this)">
                                💚 Нравится
                                <span class="likes-count">
                                    {{ $reply->likes_count ?? 0 }}
                                </span>
                            </button>

                            <button
                                type="button"
                                class="reply-btn"
                                onclick="replyToUser('{{ $reply->user->name }}')">
                                Ответить
                            </button>

                            @auth
                            @if(auth()->id() !== $reply->user_id)
                            <button
                                type="button"
                                class="complaint-btn"
                                onclick="openComplaintModal({{ $reply->id }})">
                                Пожаловаться
                            </button>
                            @endif
                            @endauth

                        </div>

                    </div>

                </div>

                @empty
                <p>Пока нет сообщений. Будьте первым!</p>
                @endforelse

            </div>

            @auth
            <div class="reply-editor-wrapper">

                <form
                    method="POST"
                    action="{{ route('replies.store', $topic->id) }}"
                    enctype="multipart/form-data"
                    onsubmit="return prepareMessage()">

                    @csrf

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
            @endauth

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
            @csrf

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
@endsection