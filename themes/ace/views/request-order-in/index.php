<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestOrderInSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request Order In';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-in-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'namaSender',
            'noRo',
            'created',
            [
                 'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'delete') {
                        $url =\yii\helpers\Url::to(['request-order-in/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =\yii\helpers\Url::to(['request-order/view','id'=>$model->ro_id]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
</div>
