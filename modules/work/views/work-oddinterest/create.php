<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOddinterest */

$this->title = 'Create Work Oddinterest';
$this->params['breadcrumbs'][] = ['label' => 'Work Oddinterests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-oddinterest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
