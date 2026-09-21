<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\PersonDocumentAudit;

/* @var $this yii\web\View */
/* @var $person app\models\Person */
/* @var $docType int */
/* @var $refId int|null */

$docLabel = ((int) $docType === PersonDocumentAudit::DOC_TYPE_TRAINING)
        ? Yii::t('app', 'เอกสารการอบรม')
        : Yii::t('app', 'ประวัติผู้วิจัย (CV)');
?>
<div class="person-esign-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'form-person-esign',
                'action' => Url::to(['person/esign', 'personId' => $person->id, 'docType' => $docType, 'refId' => $refId]),
    ]);
    ?>

    <p><b><?= Yii::t('app', 'เอกสาร') ?>:</b> <?= Html::encode($docLabel) ?></p>

    <div class="form-group">
        <label class="checkbox-inline">
            <input type="checkbox" name="apply_stamp" value="1" checked>
            <?= Yii::t('app', 'ประทับชื่อและวันที่ลงบนเอกสาร (ลงนามอิเล็กทรอนิกส์)') ?>
        </label>
    </div>

    <div class="form-group">
        <label class="checkbox-inline">
            <input type="checkbox" name="certify" value="1">
            <?= Html::encode(PersonDocumentAudit::CERTIFY_STATEMENT) ?>
        </label>
    </div>

    <?php ActiveForm::end(); ?>
</div>
