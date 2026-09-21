<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ethics;
use yii\helpers\ArrayHelper;
use app\models\ReviewChoice;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ContinueAssessForm */
/* @var $form yii\widgets\ActiveForm */
$reviewChoicesByType = ArrayHelper::index($reviewChoices, null, 'type');
$caf = app\models\ContinueAssessForm::find()->submissionCommittee($model->submission_committee_id)->one();
if (isset($caf->review_choice_id)) {
    if ($model->submission->submission_type_id == \app\models\SubmissionType::TYPE_INTERNAL_SAE) {
        $cafReview = \app\models\SaeAssessFormReview::find()->saeAssessForm($caf->id)->all();
    } elseif ($model->submission->submission_type_id == \app\models\SubmissionType::TYPE_DEVIATION) {
        $cafReview = \app\models\DeviationAssessFormReview::find()->deviationAssessForm($caf->id)->all();
    } else {
        $cafReview = app\models\ContinueAssessFormReview::find()->continueAssessForm($caf->id)->all();
    }
}
$currentRole = \Yii::$app->session->get('currentRole');
?>
<h3 class="text-center"><?= $model->submission->submissionType->name ?></h3>
<table class="table table-condensed table-bordered margin-bottom-0" style="margin-bottom: 0;">
    <tbody>
        <tr>
            <td class="text-center" style="background-color: #DCDCDC;"><?= Yii::t('app', 'หมายเลขโครงการ') ?></td>
            <td class="text-center" style="background-color: #DCDCDC;"><?= Yii::t('app', 'ชื่อหัวหน้าโครงการวิจัย') ?></td>
            <td class="text-center" style="background-color: #DCDCDC;"><?= Yii::t('app', 'หน่วยงานที่สังกัด') ?></td>
        </tr>
        <tr>
            <td class="text-center"><?= $model->submission->project->project_code ?></td>
            <td class="text-center"><?= $model->submission->projectLeader->person->i18nFullName ?></td>
            <td class="text-center"><?= $model->submission->projectLeader->person->divisionName ?></td>
        </tr>
    </tbody>
</table>
<table class="table table-condensed table-bordered" border="1" style="border-collapse: collapse;width: 100%;">
    <tbody>
        <tr>
            <td class="text-center font-weight-900" style="width: 49.1%; background-color: #DCDCDC;"><?= Yii::t('app', 'ประเด็นการพิจารณาทางด้านจริยธรรม'); ?></td>
            <td class="text-center font-weight-900" style="width: 12%;background-color: #DCDCDC;"><?= Yii::t('app', 'เหมาะสม'); ?></td>
            <td class="text-center font-weight-900" style="width: 12%;background-color: #DCDCDC;"><?= Yii::t('app', 'ไม่เหมาะสม'); ?></td>
            <td class="text-center font-weight-900" style="width: 12%;background-color: #DCDCDC;"><?= Yii::t('app', 'ไม่เกี่ยวข้อง'); ?></td>
            <td class="text-center font-weight-900" style="background-color: #DCDCDC;"><?= Yii::t('app', 'หมายเหตุ') ?>
        </tr>
        <?php foreach ($conEthicses as $conEthics): ?>

            <?php if ($conEthics->ethics->is_title == 3): ?>
                <tr>
                    <td>
                        <?= $conEthics->ethics->name; ?>
                        <?php if ($conEthics->ethics->need_text): ?>
                            <?= $conEthics->other; ?>
                        <?php endif; ?>
                    </td>
                    <td colspan="4">
                        <div class="radio-custom radio-primary" style="display:inline-block; margin-right:20px;">
                            <span style="font-family: fa-solid;">
                                <?php
                                echo (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NOT_NEEDED) ? "&#xf00c;" : "";
                                ?>
                            </span>
                            <?php echo (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NOT_NEEDED) ? Yii::t('app', 'ไม่ต้อง') : ""; ?>
                        </div>
                        <div class="radio-custom radio-primary" style="display:inline-block;">
                            <span style="font-family: fa-solid;"><?php
                                echo (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NEED_MORE_INFO) ? "&#xf00c;" : "";
                                ?></span>
                            <?php echo (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NEED_MORE_INFO) ? Yii::t('app', 'ต้องแจ้งข้อมูลเพิ่มเติม') : ""; ?>

                        </div>
                        <div class="radio-custom radio-primary"  style="display:inline-block;">
                            <span style="font-family: fa-solid;">
                                <?php
                                echo (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NEED_NEW_CONSENT) ? "&#xf00c;" : "";
                                ?></span>
                            <?php echo (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NEED_NEW_CONSENT) ? Yii::t('app', 'ต้องขอความยินยอมใหม่') : ""; ?>
                        </div>
                        <div class="radio-custom radio-primary"  style="display:inline-block;">
                            <span style="font-family: fa-solid;"><?php
                                echo (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NOT_INVOLVED) ? "&#xf00c;" : "";
                                ?></span>
                            <?php echo (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NOT_INVOLVED) ? Yii::t('app', 'ไม่เกี่ยวข้อง') : ""; ?>

                        </div>
                    </td>
                </tr>

            <?php else: ?>
                <tr>
                    <td>
                        <?= $conEthics->ethics->name; ?>
                        <?php if ($conEthics->ethics->need_text): ?>
                            <?= $conEthics->other; ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <span style="font-family: fa-solid;"><?php
                                if (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::APPROPRIATE) {
                                    echo "&#xf00c;";
                                } else {
                                    echo "";
                                }
                                ?></span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <span style="font-family: fa-solid;"><?php
                                if (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::INAPPROPRIATE) {
                                    echo "&#xf00c;";
                                } else {
                                    echo "";
                                }
                                ?></span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <span style="font-family: fa-solid"><?php
                                if (isset($conEthics->is_appropriate) && $conEthics->is_appropriate == \app\models\ContinueAssessFormEthics::NOT_INVOLVED) {
                                    echo "&#xf00c;";
                                } else {
                                    echo "";
                                }
                                ?></span>
                        </div>
                    </td>
                    <td><?= $conEthics->remark; ?></td>
                </tr>
            <?php endif; ?>

        <?php endforeach; ?>
        <?php if (isset($model->resolution)) { ?>
            <tr>
                <td colspan="5" class="text-left font-weight-900"><font style="color: blue"><?= Yii::t('app', 'ผลการพิจารณาของกรรมการ : '); ?> </font><?= $model->resolution->name; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="5" class="text-left font-weight-900"><font style="color: blue"><?= Yii::t('app', 'ข้อสรุปของกรรมการ: '); ?> </font><?= $model->suggestion; ?></td>
        </tr>
        <tr>
            <td colspan="5" class="text-left font-weight-900"><span><font style="font-weight: bold; font-size: 16px;" color="#073453;"><?= Yii::t('app', 'ข้อคิดเห็นของกรรมการ : ') ?> </font> <?= $caf->reviewChoice->name; ?> <?= !empty($caf->review_choice_text) ? $caf->review_choice_text : ""; ?></span>
                <?php foreach ($cafReview as $cr) { ?>
                    [<span> <font style="font-weight: bold; font-size: 16px;" color="#3f51b5;"><?= $cr->reviewChoice->name; ?> <?= !empty($cr->review_choice_text) ? $cr->review_choice_text : ""; ?></font></span>]</td>
            <?php } ?>
        </tr>
    </tbody>
</table>

<table style="width: 30%; margin-left: 70%; margin-top: 100px;">
    <tbody>
        <tr>
            <td class="text-right">ลงชื่อ</td>
            <td>........................................................</td>
            <td></td>
        </tr>
        <tr>
            <td class="text-right">(</td>
            <td "text-center"><?= $model->submissionCommittee->person->fullName; ?></td>
            <td>)</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">กรรมการผู้ประเมิน</td>
            <td></td>
        </tr>
        <tr>
            <td class="text-right">วันที่</td>
            <td>........................................................</td>
            <td></td>
        </tr>
    </tbody>
</table>
