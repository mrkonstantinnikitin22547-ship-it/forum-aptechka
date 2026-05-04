

<?php $__env->startSection('title', 'Форум - Аптечка'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="page-title">Форум пациентов «Аптечка»</h1>

<div class="content-layout">
    <div class="main-area">

        <div class="widget home-glass">
            <div class="home-inner">
                <h3 class="widget-title">Есть чем поделиться? Пишите посты!</h3>

                <p class="home-text">
                    Мы с удовольствием ждём авторов, готовых делиться знаниями, опытом и полезными историями.
                    Ваш пост может стать началом обсуждения, помочь другим пользователям или поддержать сообщество.
                </p>

                <p class="home-text">
                    Не стесняйтесь — рассказывайте о своих находках, идеях, решениях проблем или интересных событиях.
                    Каждый голос важен!
                </p>

                <div class="home-link-wrap">
                    <a class="home-link" href="<?php echo e(route('topics.index')); ?>">
                        Перейти к Темам →
                    </a>
                </div>
            </div>
        </div>

        
        <div class="widget home-glass">
            <div class="home-inner">
                <h3 class="widget-title">📌 Правила форума</h3>

                <ul class="home-list">
                    <li><b>Уважайте участников:</b> без оскорблений, травли и провокаций.</li>
                    <li><b>Пишите по теме:</b> заголовок должен отражать суть вопроса/истории.</li>
                    <li><b>Без опасных советов:</b> не назначайте лечение и дозировки, не призывайте к самолечению.</li>
                    <li><b>Без рекламы:</b> ссылки на магазины/услуги/«чудо-средства» и скрытая реклама запрещены.</li>
                    <li><b>Без персональных данных:</b> не публикуйте телефоны, адреса, медкарты, паспортные данные.</li>
                    <li><b>Проверяйте источники:</b> если приводите мединформацию — указывайте источник.</li>
                    <li><b>Жалобы:</b> если видите нарушение — сообщайте модерации.</li>
                </ul>
            </div>
        </div>

        
        <div class="widget important-note">
            <div class="important-inner">
                <h3 class="widget-title">⚠️ Важно</h3>

                <p class="important-text">
                    Информация на форуме носит <b>информативный характер</b> и не заменяет консультацию специалиста.
                    В экстренных случаях вызывайте неотложную помощь.
                </p>
            </div>
        </div>
    </div>

    <aside class="sidebar">
        <div class="widget home-glass">
            <div class="home-inner-sidebar">
                <h3 class="widget-title">Как писать полезные посты</h3>
                <ul class="home-list">
                    <li>Укажите контекст (без личных данных).</li>
                    <li>Опишите симптомы, длительность, что уже пробовали.</li>
                    <li>Если прикладываете анализы — только без ФИО и номеров.</li>
                    <li>Сформулируйте конкретный вопрос в конце.</li>
                </ul>
            </div>
        </div>
    </aside>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/pages/home.blade.php ENDPATH**/ ?>