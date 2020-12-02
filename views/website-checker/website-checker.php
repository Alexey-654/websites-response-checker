<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Сервис проверки доступности сайтов';
$this->registerMetaTag(['name' => 'description', 'content' => 'Сервис проверки доступности сайтов. Отправка email уведомления в случае некорректного ответа сервера'], 'description');
?>

    <div class="row">
        <div class="col">
            <h1>А ваши сайты работают?</h1>
            <p>
                Добавьте ваши сайты и контролируйте их работоспособность.
                <br>
                Чтобы сохранить список сайтов и получать уведомление на email (если сайт не будет отвечать) необходимо зарегистрироваться.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 my-4">
            <h2 class="h3">Форма отправки</h2>
            <?php $form = ActiveForm::begin(['id' => 'websites-checker-form', 'action' => '/website-checker/store']); ?>
                <?= $form->field($model, 'name')->textInput()->label('Название сайта') ?>
                <?= $form->field($model, 'url')->textInput()->label('Адрес сайта') ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 col-lg-9">
            <h2 class="h3">Результаты проверки -</h2>

        <ul class ="list-group">
            <?php foreach ($websitesWithResponse as $site) : ?>
                <li class="list-group-item list-group-item-action">
                    <div class="row">
                        <div class="col-auto mr-auto">
                            <?php Pjax::begin(); ?>
                                <?= $site['name'] ?> -
                                <a href="<?= $site['url'] ?>"><?= $site['url'] ?></a>
                                <span class="text-uppercase">
                                    <?= $time ?> ОТВЕТ -
                                    <?php if ($site['status'] === 200) : ?>
                                        <span class="badge badge-success"><?= $site['status'] ?></span> <?= $site['reasonPhrase'] ?>
                                    <?php else : ?>
                                        <span class="badge badge-danger"><?= $site['status'] ?></span> <?= $site['reasonPhrase'] ?>
                                    <?php endif; ?>
                                </span>
                                <?= Html::a("refresh", ['/websites-checker'], ['class' => 'btn refreshButton d-none', 'id' => 'refreshButton']) ?>
                            <?php Pjax::end(); ?>
                        </div>
                        <div class="col-auto">
                            <?php $form = ActiveForm::begin(['class' => 'pt-5', 'layout' => 'inline', 'action' => '/website-checker/destroy']); ?>
                                <?= Html::hiddenInput('id', $site['id']) ?>
                                <?= Html::submitButton('УДАЛИТЬ', ['class' => 'btn btn-danger btn-sm']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        </div>
    </div>

    <?php
    $script = <<< JS
    $(document).ready(function() {
        setInterval(function(){ $(".refreshButton").click(); }, 520000);
    });
    JS;
    $this->registerJs($script);
    ?>