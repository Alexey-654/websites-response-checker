<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<?php
    NavBar::begin([
        // 'brandLabel' => Yii::$app->name,
        'brandLabel' => Html::img('GitHub-Mark-Light-120px-plus.png', ['height' => '60px']),
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            // ['label' => 'Home', 'url' => ['/site/index']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'WEBSITES-CHECKER', 'url' => ['/websites-checker']],
            // Yii::$app->user->isGuest ? (
            //     ['label' => 'Login', 'url' => ['/site/login']]
            // ) : (
            //     '<li>'
            //     . Html::beginForm(['/site/logout'], 'post')
            //     . Html::submitButton(
            //         'Logout (' . Yii::$app->user->identity->username . ')',
            //         ['class' => 'btn btn-link logout']
            //     )
            //     . Html::endForm()
            //     . '</li>'
            // )
        ],
    ]);
    NavBar::end();
    ?>

        <div class="container my-5">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>


<footer class="py-4 bg-dark">
  <div class="container">
    <span class="text-muted">&copy; <a href="https://github.com/Alexey-654">Alex-654</a> <?= date('Y') ?></span>
  </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
