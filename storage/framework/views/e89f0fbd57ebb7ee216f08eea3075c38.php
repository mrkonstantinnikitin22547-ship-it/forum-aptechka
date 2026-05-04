

<?php $__env->startSection('content'); ?>

<h2>Чат с поддержкой</h2>

<div class="chat-list">

    <?php $__empty_1 = true; $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <div class="chat-item" style="padding:10px; border-bottom:1px solid #ddd;">

        <div>
            <strong><?php echo e($chat->user->name); ?></strong>
        </div>

        <div class="chat-preview" style="color:gray; font-size:14px;">
            <?php echo e(optional($chat->messages->last())->message ?? 'Нет сообщений'); ?>

        </div>

        <div style="margin-top:8px;">
            <a class="chat-open" href="<?php echo e(route('admin.support.show', $chat->id)); ?>">
                Открыть чат
            </a>
        </div>

    </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

    <p>Пока нет диалогов</p>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/admin/support/index.blade.php ENDPATH**/ ?>