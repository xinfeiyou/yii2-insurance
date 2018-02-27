<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\OldProjectList */

$this->title = $model->Title;
$this->params['breadcrumbs'][] = ['label' => '项目列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-project-list-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ProjectID',
            'ProjectType',
            'Title',
            'TargetAmount',
            'MonthlyReturnRate',
            'RepaymentDuration',
            'FundraisingBeginTime',
            'FundraisingEndTime',
            'RepaymentType',
            'InterestDate',
            'Safeguards:ntext',
            'BorrowerInformation:ntext',
            'ProjectState',
            'CreateTime',
            'ExtraMonthlyReturnRate',
            'tCreateTime',
            'tUpdateTime',
        ],
    ]) ?>

</div>
