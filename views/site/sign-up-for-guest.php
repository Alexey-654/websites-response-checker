<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Страница регистрации';
?>

<div class="row">
    <div class="col">
        <h1 class="h4 mb-3">Пожалуйста, заполните форму ниже, чтобы зарегистрироваться на сайте.</h1>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-8 col-lg-4">
        <?php $form = ActiveForm::begin(['id' => 'sign-up-form', 'action' => '/site/sign-up-store' ]); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя пользователя') ?>
            <?= $form->field($model, 'email')->textInput()->label('Email') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
