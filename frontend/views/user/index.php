<?php
use yii\widgets\Menu;
use common\models\User;
use app\models\UserRoles;

$this->title = Yii::t('common', 'Мой профиль');
?>
<h1><?=Yii::t('common', 'Мой профиль')?></h1>
<?php
$this->params['breadcrumbs'][] = Yii::t('common', 'Мой профиль');
?>
<div class="row">
    <?=Yii::$app->mymenu->userSidebarMenu();?>
    <?php
    $roles = UserRoles::getRoles();
    $role = User::getRole(Yii::$app->user->getId());
    ?>
    <div class="col-lg-8">Статус: <?=$roles[$role]?></div>
</div>