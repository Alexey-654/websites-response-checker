<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use Carbon\Carbon;

$this->title = 'Проверить ваши сайты на доступность';
?>

    <div class="row">

    <?php if (Yii::$app->session->hasFlash('websitesFormSubmitted')) : ?>
        <div class="alert alert-success">
            Сайт успешно добавлен.
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('websiteDeleted')) : ?>
        <div class="alert alert-info">
            Сайт удален из списка отслеживаемых.
        </div>
    <?php endif; ?>

    <h1>А ваши сайты работают?</h1>
    <h2 class="h4">Добавьте ваши сайты и контролируйте их работоспособность</h2>
    <p>Если сайт не будет отвечать, Вы получите уведомление на email.</p>
        <div class="col-lg-5" style="padding: 3rem 0">

            <?php $form = ActiveForm::begin(['id' => 'websites-checker-form', 'action' => "/websites-checker/store"]); ?>
                <?= $form->field($model, 'name')->textInput()->label('Название сайта') ?>
                <?= $form->field($model, 'url')->textInput()->label('Адрес сайта') ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <div class="row">
        <h2 class="h4">Результаты проверки -</h2>
        <ul style="line-height: 2; font-size:larger">
            <?php foreach ($websitesWithResponse as $site) : ?>
                <li style="padding: 1rem 0">
                    <?php Pjax::begin(); ?>
                        <?= $site['name'] ?> -
                        <a href="<?= $site['url'] ?>"><?= $site['url'] ?></a>
                        <br>
                        <?= Carbon::now('Europe/Moscow')->format('H:i') ?> ОТВЕТ -
                        <?php if ($site['status'] === 200) : ?>
                            <b><span class="text-success"><?= $site['status'] ?> <?= $site['reasonPhrase'] ?></span></b>
                        <?php else : ?>
                            <b><span class="text-danger"><?= $site['status'] ?> <?= $site['reasonPhrase'] ?> </span></b>
                        <?php endif; ?>
                        <?= Html::a("refresh", ['/websites-checker'], ['class' => 'btn hidden refreshButton', 'id' => 'refreshButton']) ?>
                    <?php Pjax::end(); ?>

                        <?php $form = ActiveForm::begin(['action' => "/websites-checker/destroy"]); ?>
                            <?= Html::hiddenInput('id', $site['id']) ?>
                            <?= Html::submitButton('Удалить из списка', ['class' => 'btn btn-danger btn-sm']) ?>
                        <?php ActiveForm::end(); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php
    $script = <<< JS
    $(document).ready(function() {
        setInterval(function(){ $(".refreshButton").click(); }, 120000);
    });
    JS;
    $this->registerJs($script);
    ?>