<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\work\models\WorkOdd */

$this->title = 'Create Work Odd';
$this->params['breadcrumbs'][] = ['label' => 'Work Odds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-odd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
