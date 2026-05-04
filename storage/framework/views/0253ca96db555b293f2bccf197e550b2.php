

<?php $__env->startSection('content'); ?>

<h1>Сообщения обратной связи</h1>

<?php if(session('success')): ?>
<p style="color:green;"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Дата</th>
        <th>Действия</th>
    </tr>

    <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php echo e($message->id); ?></td>
        <td><?php echo e($message->first_name); ?> <?php echo e($message->last_name); ?></td>
        <td><?php echo e($message->email); ?></td>
        <td><?php echo e($message->created_at); ?></td>
        <td>
            <a href="<?php echo e(route('admin.messages.show', $message->id)); ?>">
                <button class="admin-btn">Открыть</button>
            </a>

            <form method="POST"
                action="<?php echo e(route('admin.messages.delete', $message->id)); ?>"
                onsubmit="return confirmDelete('сообщение #<?php echo e($message->id); ?>')">

                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

                <button type="submit" class="admin-btn">
                    Удалить
                </button>
            </form>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="5" style="text-align:center; padding:20px;">
            Сообщений пока нет
        </td>
    </tr>
    <?php endif; ?>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/admin/messages/index.blade.php ENDPATH**/ ?>