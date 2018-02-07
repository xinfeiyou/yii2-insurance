<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkAdmin */

$this->title = 'Create Work Admin';
$this->params['breadcrumbs'][] = ['label' => 'Work Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-admin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
