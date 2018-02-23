<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;

$js = <<<EOD
    var trigger = $('.hamburger'),
            overlay = $('.overlay'),
            isClosed = false;
    trigger.click(function () {
        hamburger_cross();
    });
    function hamburger_cross() {
        if (isClosed == true) {
            overlay.hide();
            trigger.removeClass('is-open');
            trigger.addClass('is-closed');
            isClosed = false;
            $('#page-content-wrapper').width('100%');
        } else {
            overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
            $('#page-content-wrapper').width(parseInt($('#page-content-wrapper').width()) - 220);
        }
    }
    $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
    });
EOD;
$css = <<<EOD
        	/*top*/
		#tool_boxs{
			display: block;
			position: fixed;
			bottom:60px;
			right: 40px;
			font-family: '宋体';
			z-index: 999;
			width: 40px;
		}
		#tool_boxs ul li{
			width: 100%;
			height: 40px;
			border-radius: 5px;
			cursor: pointer;
			margin-top: 10px;
		}
		#tool_boxs ul li i{
			width: 100%;
			height: 100%;
			display: block;
			background-repeat: no-repeat;
			background-position: center;
		}
		#tool_boxs ul li .top{
			display: none;
		}
EOD;
$jsPub = <<<EOD
    function openUrl(url){
        layer.open({
        type: 2,
        title: '目标再远大，终离不开信念去支撑。',
        shadeClose: true,
        shade: false,
        maxmin: true, //开启最大化最小化按钮
        area: ['893px', '600px'],
        content: url
        });    
    }        
EOD;
$this->registerCss($css);
$this->registerJs($js, View::POS_READY);
$this->registerJs($jsPub, View::POS_END);
$this->registerCssFile('@web/css/style.css');
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="wrapper">
            <?php
            NavBar::begin([
                'brandLabel' => '',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => '首页', 'url' => ['/site/index']],
                    Yii::$app->user->isGuest ? (
                            ['label' => '登录', 'url' => ['/site/login']]
                            ) : (
                            '<li class="dropdown">'
                            . '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'
                            . Yii::$app->user->identity->username
                            . '<span class="caret"></span></a>'
                            . '<ul class="dropdown-menu">'
                            . '<li><a href="' . Url::toRoute(['/work/work-admin/update', 'username' => Yii::$app->user->identity->username]) . '">账户信息</a></li>'
                            . '<li><a href="' . Url::toRoute(['/site/logout']) . '">退出系统</li>'
                            . '</ul></li>'
                            )
                ],
            ]);
            NavBar::end();
            ?>
            <!-- Sidebar -->
            <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
                <ul class="nav sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="#">&nbsp;&nbsp;</a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/']) ?>"><i class="fa fa-fw fa-home"></i> 首页</a>
                    </li>
                    <?php if (empty(\Yii::$app->user->isGuest)) { ?>
                        <li>
                            <a href="<?= Url::toRoute(['/work/work-user/index']) ?>"><i class="fa fa-fw fa-bank"></i>用户管理</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> 贷前管理 <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">子类列表</li>
                                <li><a href="<?= Url::toRoute(['/work/work-apply/index']) ?>">车险申请</a></li>
                                <li><a href="<?= Url::toRoute(['/work/work-odd/index']) ?>">标的管理</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> 贷中管理 <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">子类列表</li>
                                <li><a href="<?= Url::toRoute(['/work/work-oddinterest/index']) ?>">还款列表</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> 贷后管理 <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">子类列表</li>
                                <li><a href="#">催收</a></li>
                                <li><a href="#">逾期</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> 数据查询 <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">子类列表</li>
                                <li><a href="<?= Url::toRoute(['/work/old-money-list']) ?>">资金记录</a></li>
                                <li><a href="<?= Url::toRoute(['/work/old-money-recharge']) ?>">宝付充值</a></li>
                                <li><a href="<?= Url::toRoute(['/work/old-money-withdraw']) ?>">宝付提现</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-dropbox"></i> 系统设置</a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div  style="margin: 0 10px 0 10px;">
                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <?php if(empty(Yii::$app->user->isGuest)){ ?>
        <div id="tool_boxs">
            <ul class="list-unstyled">
                <li>
                    <i style="background-image: url('https://asset.91hc.com/src/images/public/cal.png');" onclick="openUrl('<?= Url::toRoute(['/work/work-oddinterest/cal'])?>');"></i>
                </li>
            </ul>
        </div>
        <?php }?>
            <!-- /#wrapper -->
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>