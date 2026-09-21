<?php

use yii\helpers\Url;
use app\models\SubmissionDocument;
use app\models\Project;

$revise = \app\models\SubmissionCommitteeRevise::find()->submission($submission->id)->isDeleted(FALSE)->one();
$currentRole = \Yii::$app->session->get('currentRole');

$items = [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'i18nName',
        'format' => 'raw',
        'value' => function($model) {
            $name = $model->name;
            $nameEng = isset($model->name_eng) ? '<br>' . $model->name_eng : "";
            if ($model->is_site) {
                $name .= ' <span class="text-danger">(' . Yii::t('app', 'เอกสาร Site') . ')</span>';
            }
            if (isset($model->sd_crec_id) && $model->is_certificate == false && $model->submission->crec_resolution == app\models\Submission::RESOLUTION_Y) {
                $name .= '<br> <span class="text-info">[' . $model->isCertificate . ']</span>';
            }
            return $name . $nameEng;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'version',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'version_at',
        'format' => ['date'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'documentSubmissionType.isRequireLabel',
        'format' => 'raw',
//        'value' => function($model) {
//            return $model->documentSubmissionType->id;
//        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'file_name',
        'format' => 'raw',
        'value' => function($model) {
            $file = isset($model->file_name) ? \yii\helpers\Html::a("<i class='font-size-20 {$model->fileIconClass}'></i>", ['submission-document/download', 'id' => $model->id], ['target' => '_blank', 'data-pjax' => 0]) : "";
             $view = $model->viewFilePdf;
            return $file . $view;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'file_name',
        'header' => Yii::t('app', 'ประวัติเอกสาร'),
        'format' => 'raw',
        'value' => function($model) {
            return $model->getDocumentHistoriesHtml();
        }
    ],
];
if ($submission->status == \app\models\Submission::STATUS_DOC_REJECTED) {
    $items[] = [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'status',
        'value' => function($model) {
            return isset($model->status) ? SubmissionDocument::getStatusLabels()[$model->status] : "";
        }
    ];
    $items[] = [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'remark',
        'value' => function($model) {
            return isset($model->remark) ? $model->remark : "";
        }
    ];
}
$items = array_merge($items);
return $items;

