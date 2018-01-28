<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '主页';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index" style="margin: 0 0 0 10px;">
    <?php print_r(Yii::$app->user->identity);?>
</div>
