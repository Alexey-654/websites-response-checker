<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Страница входа в аккаунт';
?>

<div class="row">
    <div class="col">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Пожалуйста, заполните форму ниже, чтобы войти в свой аккаунт.</p>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-8 col-lg-4">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя пользователя') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <?= $form->field($model, 'rememberMe')->checkbox([]) ?>
            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
