

<?php $__env->startSection('content'); ?>

    <h1>Жалобы</h1>

<div class="table-wrapper">

    <table class="admin-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>От пользователя</th>
                <th>На пользователя</th>
                <th>Тема</th>
                <th>Сообщение</th>
                <th>Причина</th>
                <th>Дата</th>
                <th>Действие</th>
            </tr>
        </thead>

        <tbody>

        <?php $__empty_1 = true; $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr>
                <td><?php echo e($complaint->id); ?></td>

                <td><?php echo e($complaint->fromUser->name ?? '-'); ?></td>

                <td><?php echo e($complaint->toUser->name ?? '-'); ?></td>

                <td><?php echo e($complaint->reply->topic->title ?? 'Удалена тема'); ?></td>

                <td>
                    <?php echo e(\Illuminate\Support\Str::limit($complaint->reply->body ?? '', 50)); ?>

                </td>

                <td><?php echo e($complaint->reason); ?></td>

                <td><?php echo e($complaint->created_at->format('d.m.Y H:i')); ?></td>

                <td>
                    <form method="POST"
                          action="<?php echo e(route('admin.complaints.delete', $complaint->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button class="admin-btn">
                            Удалить
                        </button>
                    </form>
                </td>
            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <tr>
                <td colspan="8" style="text-align:center;">
                    Жалоб пока нет
                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/admin/complaints/index.blade.php ENDPATH**/ ?>