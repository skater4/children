<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use common\models\User;
use app\models\Participant;
use vision\messages\models\Messages;
use app\components\Csc;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" style="min-height: 150px;">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand navbar-inverse navbar-fixed-top',
            "style"=>"background-color: rgb(241, 200, 85);"
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('common', 'Мероприятия'), 'url' => Url::to(['site/index'])],
        ['label' => Yii::t('common', 'Наставники'), 'url' => Url::to(['/site/contact'])],
        ['label' => Yii::t('common', 'Партнёры'), 'url' => Url::to(['/site/contact'])],
        ['label' => Yii::t('common', 'Статистика'), 'url' => Url::to(['/site/contact'])],
    ];
    ?> <div class="container-md container-fluid"> <?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuItems,
    ]);
    $menuItems = [];
    if (!Yii::$app->user->isGuest) {
        $role = User::getRole(Yii::$app->user->getId());
        $menuItems []=['label' => Yii::t('common', 'Поиск мероприятия'), 'url' => Url::to(['/activities/index', 'page' => 1])];
        $menuItems []=['label' => Yii::t('common', 'Мои участия'), 'url' => Url::to(['/myparticipation/index', 'page' => 1])];
        /*$new_messages = new Messages();
        $new_messages = $new_messages->getNewMessagesCount(Yii::$app->user->id);
        if ($new_messages > 0) $menuItems []=['label' => Yii::t('common', 'Новые сообщения') . " (" . $new_messages . ")", 'url' => Url::to(['/newmessages/index', 'page' => 1])];*/
        if (in_array($role, ['volunteer'])) $menuItems [] = ['label' => Yii::t('common', 'Мои мероприятия'), 'url' => Url::to(['/myactivity/index', 'page' => 1])];
        $incoming_requests = Participant::getActivitiesParticipantsCount();
        if ($incoming_requests > 0) $menuItems []=['label' => Yii::t('common', 'Входящие заявки') . ' (' . $incoming_requests . ')', 'url' => Url::to(['/participants/incoming', 'page' => 1])];
        $menuItems []=['label' => Yii::t('common', 'Мой профиль'), 'url' => Url::to(['/user/index'])];
    }

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('common', 'Регистрация'), 'url' => Url::to(['/site/signup'])];
        $menuItems[] = ['label' => Yii::t('common', 'Вход'), 'url' => Url::to(['/site/login'])];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::t('common', 'Выход') . ' (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-outline-success me-2']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
        ?> </div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer fixed-bottom">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?> | <?= $this->render('language'); ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>