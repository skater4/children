<?php
use yii\helpers\Url;
use app\models\ActivityPhotos;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Activity;
use app\models\ActivityCategories;
use app\models\Countries;
use kartik\datetime\DateTimePicker;
use common\models\User;
$this->title = Yii::t('common', 'Все курсы');
$this->params['breadcrumbs'][] = ['label' => "Все курсы"];
?>
    <form class="container-fluid">
    <div class="input-group mb-3">
        <span class="input-group-addon" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg></span>
        <input type="text" class="form-control w-75"
               placeholder="Поиск по курсам" aria-label="Course"
               aria-describedby="basic-addon1" style="border-top-rigth-radius: 20px; border-color: #ffc107">
    </div>
    <h1><?=Yii::t('common', 'Все курсы')?></h1>
        <h3>Здесь ты можешь посмотреть все проекты, которые есть на сайте. Скорее <u>авторизируйся</u>, занимайся на курсах и собирай ачивки!</h3>
    </form>
<br>
    <br>
<?php
$i = 1;
$activity = new Activity();
if (!empty(Yii::$app->request->get()['Activity']['city_id'])) $city_id = Yii::$app->request->get()['Activity']['city_id'];
else $city_id = '';
$activity->load(Yii::$app->request->get());
//die($city_id);
echo "<div class='row'>";?>
    <div class="col-lg-3">
        <?php $form = ActiveForm::begin(['method' => 'get']); ?>
        <?= $form->field($activity, 'name')?>
        <?php
        $params = ['get_empty' => true];
        ?>
        <?= $form->field($activity, 'category_id')->dropDownList(
            ActivityCategories::findCategories($params)
        );
        ?>
        <?php echo $form->field($activity, 'country')->dropDownList(
            Countries::getCountries(),
            array(
                'prompt' => Yii::t('common', 'Выберите страну'),
                'onchange'=>'
				    $.get( "'.Yii::$app->urlManager->createUrl('cities/getactivityformcities?country=').'" + $(this).val() + "&city_id=' . $city_id . '", function( data ) {
				    $( "#cities select" ).html( data );
				});'
            )
        ); ?>
        <?php
        echo $form->field($activity, 'city_id', ['options' => ['id' => 'cities']])->dropDownList(
            Countries::getCities($activity->country)
        );
        ?>
        <?= $form->field($activity, 'location')?>
        <?= $form->field($activity, 'date_from')->widget(\kartik\datetime\DateTimePicker::class, [
            'value' => date('dd.mm.yyyy', time()),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy hh:ii',
                'todayHighlight' => true
            ],
            'attribute' => 'date_from',

        ]) ?>

        <?= $form->field($activity, 'date_to')->widget(\kartik\datetime\DateTimePicker::class, [
            'value' => date('dd.mm.yyyy', time()),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy hh:ii',
                'todayHighlight' => true
            ],
            'attribute' => 'date_to',

        ]) ?>
        <div class="form-check">
            <?=Html::hiddenInput('just_active', 'N')?>
            <label class="control-label" for="just_active"><?=Yii::t('common', 'Только активные')?></label>
            <?=Html::checkbox('just_active', !empty($_GET['just_active']) && $_GET['just_active'] == "Y", ['value' => "Y", 'class' => 'form-check-input', 'id' => 'just_active'])?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('common', 'Поиск'), ['class' => 'btn btn-primary']) ?>
            <a class="btn btn-primary" href="<?=Url::to(['/activities/index', 'page' => 1])?>"><?=Yii::t('common', 'Сбросить')?></a>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-lg-9">
        <?php
        foreach($activities as $key => $activity):?>
            <?php
            $main_image = ActivityPhotos::getMainImage($activity->id);
            if (!empty($main_image)) $image = $main_image->thumbnail_path;
            else $image = Yii::getAlias('@web/img/no_image.png');
            if ($i == 1) echo '<div class="row">';
            ?>
            <div class='col-lg-4 activity-item'>
                <div class="card start-0 min-vw-250" style="width: 207px; background-color: #e9ecef">
                    <a href="<?=Url::to(['activities/view', 'id' => $activity->id])?>">
                        <img class="card-img-top rounded" src="<?=$image?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?if ($activity->status == "D") echo "<b>" . Yii::t('common', 'Отменено') . "</b>"?></h5>
                        <h5 class="card-title"><?=$activity->name?></h5>
                        <div class="card-text"><?=$activity->description?></div>
                        <p class="card-text"><?=Yii::t('common', 'Начало'   )?> <?=$activity->date_from?></p>
                        <p class="card-text"><?=Yii::t('common', 'Окончание')?> <?=$activity->date_to?></p>

                        <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-8">Подробнее <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                            </svg></a>
                    </div>
                </div>
            </div>

            <?php
            if ($i == 3) echo "</div>";
            $i++;
            if ($i == 4) $i = 1;
            ?>
        <?endforeach;?>
        <?php
        if ($i > 1) echo '</div>';
        echo "<div class='row'>";
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        echo '</div>';
        ?>
    </div></div>
<?php
//if ($i < 3) echo "</div>";
?>