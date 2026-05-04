

<?php $__env->startSection('content'); ?>

<h1>Управление темами</h1>

<?php if(session('success')): ?>
<p style="color:green;"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<table class="admin-table">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Автор</th>
        <th>Дата создания</th>
        <th>Действие</th>
    </tr>

    <?php $__empty_1 = true; $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php echo e($topic->id); ?></td>
        <td><?php echo e($topic->title); ?></td>
        <td><?php echo e($topic->user->name ?? '—'); ?></td>
        <td><?php echo e($topic->created_at); ?></td>
        <td>
            <form method="POST"
                action="<?php echo e(route('admin.topics.delete', $topic->id)); ?>"
                onsubmit="return confirmDelete('тему «<?php echo e($topic->title); ?>»')">

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
            Тем пока нет
        </td>
    </tr>
    <?php endif; ?>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/admin/topics/index.blade.php ENDPATH**/ ?>