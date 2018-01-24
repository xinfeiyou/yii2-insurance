<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkUser */

$this->title = 'Create Work User';
$this->params['breadcrumbs'][] = ['label' => 'Work Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
