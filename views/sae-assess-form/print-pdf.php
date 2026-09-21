<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use app\models\SaeAssessForm;
use yii\helpers\ArrayHelper;
use app\models\Submission;
use app\models\Resolution;
use yii\helpers\Url;
use app\models\SaeVolunteerEthics;
use app\models\ReviewChoice;

/* @var $this yii\web\View */
/* @var $model app\models\SaeAssessForm */
/* @var $form yii\widgets\ActiveForm */
$currentRole = \Yii::$app->session->get('currentRole');
$resolutions = Resolution::find()->isDeleted(false)->orderBy('id')->all();
$reviewChoicesByType = ArrayHelper::index($reviewChoices, null, 'type');
?>

<div class="sae-assess-form-form padding-15">
    <?php
    $form = ActiveForm::begin([
                'layout' => 'inline',
                'id' => 'submission-type-assess-form',
    ]);
    ?>
    <div class="border text-center" style="font-size: 20px; font-weight: bold;">
        <?= Yii::t('app', 'แบบประเมินรายงานเหตุการณ์ไม่พึงประสงค์ (Serious Adverse Event: SAE)'); ?>
    </div>
    <div style="font-size: 18px;">

        <div>
            <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'เลขที่โครงการ'); ?></span> <?= $model->submission->project->project_code ?>
        </div>
        <div>
            <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'ชื่อโครงการ'); ?></span> <?= $model->submission->project->name_thai ?>
        </div>
        <div>
            <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'ชื่อหัวหน้าโครงการ'); ?></span> <?= $model->submission->projectLeader->person->i18nFullName ?>
            <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'สังกัด'); ?></span> <?= $model->submission->projectLeader->person->divisionName ?>
        </div>
        <div>
            <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'ชื่อกรรมการประเมิน'); ?></span> <?= $model->submissionCommittee->person->i18nFullName ?>
            <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'กำหนดส่งคืน'); ?></span> <?= Yii::$app->formatter->asDate($model->submission->send_plan_date); ?>
        </div>
        <br>
        <div class="font-weight-900" style="font-weight: bold;">
            <?= Yii::t('app', 'สรุปผลการประเมินเหตุการณ์ไม่พึงประสงค์ในโครงการวิจัยที่ได้รับการรับรองจากสำนักงานคณะกรรมการจริยธรรมฯเพื่อนำเสนอในที่ประชุมพิจารณาโครงการฯ'); ?>
        </div>
        <div style="padding-left: 50px;"><span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'จำนวนอาสาสมัครเสียชีวิต : '); ?></span> <?= app\models\SaeVolunteer::getVolunteerCount($model->submission_id, 22, 14); ?> <?= Yii::t('app', ' ราย '); ?></div>
        <br>
        <?php
        foreach ($saeVolunteer as $sv):
            $saeEthicses = app\models\SaeVolunteerEthics::find()->isDeleted(false)->saeVolunteer($sv->id)->all();
            ?>
            <div>
                <span class="font-weight-900" style="font-weight: bold; color:red;"><?= Yii::t('app', 'หมายเลขอาสาสมัคร : '); ?></span> <?= $sv->volunteer->code; ?> <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', ' ประเภทติดตาม : '); ?></span> <?= $sv->submissionVolunteer->typeLabel; ?>
            </div>
             <table class="table table-bordered table-condensed table-striped">
                <tr style="background-color: #F5F5F5;">
                    <td class="text-center font-weight-900" style="border: 1px solid black; width: 65%"><?= Yii::t('app', 'การประเมินเหตุการณ์ไม่พึงประสงค์ในโครงการวิจัย') ?>
                    <td class="text-center font-weight-900" style="border: 1px solid black; width: 35%"><?= Yii::t('app', 'ข้อมูลที่เลือก') ?>

                </tr>
                <?php foreach ($saeEthicses as $saeEthics): ?>
                    <tr>
                        <td style="border: 1px solid black;">

                            <?= $saeEthics->ethics->name; ?>
                            <?php if ($saeEthics->ethics->need_text): ?>
                                <?= $saeEthics->other; ?>
                            <?php endif; ?>
                        </td>
                        <td style="border: 1px solid black;">
                            <div class="radio-custom radio-primary">
                                <?php
                                echo SaeVolunteerEthics::getStatusLabelsEthics()[$saeEthics->is_appropriate];
                                if (isset($saeEthics->remark)) {
                                    echo $saeEthics->remark;
                                }
                                ?>  

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div>
                <?php if (isset($sv->comment)) { ?>
                    <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'ข้อคิดเห็นเพิ่มเติม : '); ?></span> <?= $sv->comment; ?> 
                <?php } ?>
            </div>
        <?php endforeach; ?>
        <?php if (isset($model->resolution)) { ?>
            <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'ผลการพิจารณาของกรรมการ : ') ?> </span><?= $model->resolution->name; ?>
        <?php } ?>
        <?php if (isset($model->reviewChoice)) { ?>
            <span class="font-weight-900" style="font-weight: bold;"><?= Yii::t('app', 'ข้อคิดเห็นของกรรมการ : ') ?> </span><?= $model->reviewChoice->name; ?>
        <?php } ?>
        <span class="font-weight-900"  style="font-weight: bold;"><?= Yii::t('app', 'ข้อเสนอแนะของกรรมการเพิ่มเติม '); ?> : </span> <?= isset($model->suggestion) ? $model->suggestion : "N/A"; ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
