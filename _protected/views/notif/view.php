<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Notif */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notif-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'keterangan',
            'user_from_id',
            'user_to_id',
            'is_read_user_from',
            'is_read_user_to',
            'is_hapus',
            'created',
        ],
    ]) ?>

</div>
