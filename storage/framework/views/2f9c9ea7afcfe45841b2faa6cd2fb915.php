<?php
/** @var \App\Models\Topic $topic */
?>

<a href="<?php echo e(route('topics.show', $topic)); ?>"
    class="topic-card-glass">

    <div class="topic-card-inner">

        <div class="topic-title">
            <?php echo e($topic->title); ?>

        </div>

        <!-- <div class="topic-green-line"></div> -->
        <div class="topic-status" >
            <div class="topic-meta">
                <span><?php echo e($topic->created_at?->format('d.m.Y H:i')); ?></span><br>
                <span>Автор: <?php echo e($topic->user?->display_name ?? $topic->user?->name ?? '—'); ?></span>
            </div>

            <div class="topic-stats">
                <span>💬 <?php echo e($topic->replies_count ?? 0); ?></span>
                <span>👁 <?php echo e($topic->views_count ?? 0); ?></span>
            </div>
        </div>

    </div>

</a><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/partials/topic_card.blade.php ENDPATH**/ ?>