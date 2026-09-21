<?php

use app\models\ContinueAssessFormEthics;
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

$currentRole = \Yii::$app->session->get('currentRole');
?>

<div class="continue-assess-form-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'submission-type-assess-form',
                'action' => Url::to(['continue-assess-form/create', 'submissionId' => $model->submission_id, 'submissionCommitteeId' => $model->submission_committee_id]),
    ]);
    ?>
    <?= $this->renderFile('@app/views/widgets/_alert.php'); ?>

    <table class="table table-condensed table-bordered margin-0">
        <tbody>
            <tr>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'หมายเลขโครงการ') ?></td>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'ชื่อหัวหน้าโครงการวิจัย') ?></td>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'หน่วยงานที่สังกัด') ?></td>
            </tr>
            <tr>
                <td class="text-center"><?= $model->submission->project->project_code ?></td>
                <td class="text-center"><?= $model->submission->projectLeader->person->i18nFullName ?></td>
                <td class="text-center"><?= $model->submission->projectLeader->person->divisionName ?></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-condensed table-bordered">
        <tbody>
            <tr>
                <td colspan="4" class="text-center font-weight-900"><?= Yii::t('app', 'ชนิดของรายงานแยกตามชนิดของการพิจารณาของคณะกรรมการ') ?>
            </tr>
            <tr>
                <td colspan="1">
                    <div class="font-weight-900">Expedited Review</div>
                    <?php
                    echo $form->field($model, 'review_choice_id')->label(false)->radioList(ArrayHelper::map($reviewChoicesByType[ReviewChoice::TYPE_EXPEDITED], 'id', 'name'), [
                        'unselect' => NULL,
                        'item' => function ($index, $label, $name, $checked, $value) use ($model, $form) {
                            $id = "review_choice_id-{$value}";
                            $res = '';
                            $style = '';
                            $rc = ReviewChoice::findOne($value);
//                            if ($value == BioForm::TOS_OTHERS || $value == BioForm::TOS_CLINICAL_TRIAL) {
//                                $res .= '<br>';
//                                $label .= "<i class='margin-left-20'>Please specify</i>";
//                                $style = "display: table-cell !important;white-space: nowrap;";
//                            }
                            $res .= Html::tag('div', Html::radio($name, $checked, [
                                                'id' => $id,
                                                'value' => $value
                                            ]) . Html::label($label, $id, ['class' => 'padding-right-20']), [
                                        'class' => "radio-custom radio-primary",
                                        'style' => $style,
                            ]);
                            if ($rc->need_text) {
                                $res .= $form->field($model, 'review_choice_text', [
                                            'options' => [
//                                                'style' => $style . "width: 100%;"
                                            ]
                                        ])->label(false)->textInput();
                            }
                                    if (count($rc->children) > 0) {
                                        $res .= $form->field($model, 'reviewIds', [
                                                    'options' => [
                                                        'class' => 'margin-left-20'
                                                    ]
                                                ])->label(false)->checkboxList(ArrayHelper::map($rc->children, 'id', 'name'), [
                                            'unselect' => NULL,
                                            'item' => function ($index, $label, $name, $checked, $value) use ($model, $form) {
                                                $id = "review-choice-{$value}";
                                                $res = '';
                                                $childRc = ReviewChoice::findOne($value);
                                                $res .= Html::tag('div', Html::checkbox($name, $checked, [
                                                                    'id' => $id,
                                                                    'value' => $value,
                                                                ]) . Html::label($label, $id, ['class' => 'padding-right-20']), [
                                                            'class' => "checkbox-custom checkbox-primary"
                                                ]);
                                                if ($childRc->need_text) {
                                                    $textId = "review-choice-text-{$value}";
                                                    $res .= Html::tag('div', Html::textInput(
                                                                            "ContinueAssessForm[reviewChoiceTexts][{$value}]",
                                                                            isset($model->reviewChoiceTexts[$value]) ? $model->reviewChoiceTexts[$value] : '',
                                                                            ['id' => $textId, 'class' => 'form-control']
                                                    ));
                                                }
                                                return $res;
                                            }
                                        ]);
                                        if ($rc->need_text) {
                                            $res .= $form->field($model, 'review_choice_text', [
                                                        'options' => [
                                                        ]
                                                    ])->label(false)->textInput();
                                        }
                                    }
                            return $res;
                        }
                    ]);
                    ?>
                </td>
                <td colspan="3">
                    <div class="font-weight-900">Full Board Review</div>
                    <?php
                    echo $form->field($model, 'review_choice_id')->label(false)->radioList(ArrayHelper::map($reviewChoicesByType[ReviewChoice::TYPE_FULL_BOARD], 'id', 'name'), [
                        'unselect' => NULL,
                        'item' => function ($index, $label, $name, $checked, $value) use ($model, $form) {
                            $id = "review_choice_id-{$value}";
                            $res = '';
                            $style = '';
                            $rc = ReviewChoice::findOne($value);
//                            if ($value == BioForm::TOS_OTHERS || $value == BioForm::TOS_CLINICAL_TRIAL) {
//                                $res .= '<br>';
//                                $label .= "<i class='margin-left-20'>Please specify</i>";
//                                $style = "display: table-cell !important;white-space: nowrap;";
//                            }
                            $res .= Html::tag('div', Html::radio($name, $checked, [
                                                'id' => $id,
                                                'value' => $value
                                            ]) . Html::label($label, $id, ['class' => 'padding-right-20']), [
                                        'class' => "radio-custom radio-primary",
                                        'style' => $style,
                            ]);
                            if ($rc->need_text) {
                                $res .= $form->field($model, 'review_choice_text', [
                                            'options' => [
//                                                'style' => $style . "width: 100%;"
                                            ]
                                        ])->label(false)->textInput();
                            }
                                    if (count($rc->children) > 0) {
                                        $res .= $form->field($model, 'reviewIds', [
                                                    'options' => [
                                                        'class' => 'margin-left-20'
                                                    ]
                                                ])->label(false)->checkboxList(ArrayHelper::map($rc->children, 'id', 'name'), [
                                            'unselect' => NULL,
                                            'item' => function ($index, $label, $name, $checked, $value) use ($model, $form) {
                                                $id = "review-choice-{$value}";
                                                $res = '';
                                                $childRc = ReviewChoice::findOne($value);
                                                $res .= Html::tag('div', Html::checkbox($name, $checked, [
                                                                    'id' => $id,
                                                                    'value' => $value,
                                                                ]) . Html::label($label, $id, ['class' => 'padding-right-20']), [
                                                            'class' => "checkbox-custom checkbox-primary"
                                                ]);
                                                if ($childRc->need_text) {
                                                    $textId = "review-choice-text-{$value}";
                                                    $res .= Html::tag('div', Html::textInput(
                                                                            "ContinueAssessForm[reviewChoiceTexts][{$value}]",
                                                                            isset($model->reviewChoiceTexts[$value]) ? $model->reviewChoiceTexts[$value] : '',
                                                                            ['id' => $textId, 'class' => 'form-control']
                                                    ));
                                                }
                                                return $res;
                                            }
                                        ]);
                                        if ($rc->need_text) {
                                            $res .= $form->field($model, 'review_choice_text', [
                                                        'options' => [
                                                        ]
                                                    ])->label(false)->textInput();
                                        }
                                    }
                            return $res;
                        }
                    ]);
                    ?>
                </td>
            </tr>
            <tr>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'ประเด็นการพิจารณาทางด้านจริยธรรม') ?>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'เหมาะสม') ?>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'ไม่เหมาะสม') ?>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'ไม่เกี่ยวข้อง') ?>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'หมายเหตุ') ?>
            </tr>
            <?php foreach ($conEthicses as $conEthics): ?>
                <tr>
                    <td>
                        <?= $conEthics->ethics->name; ?>
                        <?php if ($conEthics->ethics->need_text): ?>
                            <?= $form->field($conEthics, "[{$conEthics->ethics_id}]other")->label(false)->textInput(); ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <?=
                            $form->field($conEthics, "[{$conEthics->ethics_id}]is_appropriate", [
                                'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                            ])->radio([
                                'value' => ContinueAssessFormEthics::APPROPRIATE,
                                'uncheck' => null,
                                'label' => '',
                                    ], false);
                            ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <?=
                            $form->field($conEthics, "[{$conEthics->ethics_id}]is_appropriate", [
                                'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                            ])->radio([
                                'value' => ContinueAssessFormEthics::INAPPROPRIATE,
                                'uncheck' => null,
                                'label' => '',
                                    ], false);
                            ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <?=
                            $form->field($conEthics, "[{$conEthics->ethics_id}]is_appropriate", [
                                'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                            ])->radio([
                                'value' => ContinueAssessFormEthics::NOT_INVOLVED,
                                'uncheck' => null,
                                'label' => '',
                                    ], false);
                            ?>
                        </div>
                    </td>
                    <td><?= $form->field($conEthics, "[{$conEthics->ethics_id}]remark")->label(false)->textInput(); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="text-center font-weight-900"><?= Yii::t('app', 'ข้อคิดเห็นของกรรมการ') ?>
                <td colspan="3" class="text-center font-weight-900"><?= Yii::t('app', 'ข้อเสนอแนะเพิ่มเติม') ?>
            </tr>
            <tr>
                <td>
                    <?php
                    echo $form->field($model, 'resolution_id')->label(false)->radioList(ArrayHelper::map($resolutions, 'id', 'name'), [
                        'unselect' => NULL,
                        'item' => function ($index, $label, $name, $checked, $value) use ($model, $form) {
                            $id = "resolution_id-{$value}";
                            $res = '';
                            $style = '';
                            $res .= Html::tag('div', Html::radio($name, $checked, [
                                                'id' => $id,
                                                'value' => $value
                                            ]) . Html::label($label, $id, ['class' => 'padding-right-20']), [
                                        'class' => "radio-custom radio-primary",
                                        'style' => $style,
                            ]);
                            return $res;
                        }
                    ]);
                    ?>
                </td>
                <td colspan="3">
                    <?= $form->field($model, 'suggestion')->textarea(['rows' => 7]) ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php if (($currentRole['role_id'] == \app\models\Role::STAFF || $currentRole['role_id'] == \app\models\Role::ADMIN) || ($currentRole['role_id'] == \app\models\Role::COMMITTEE && $model->submissionCommittee->status == app\models\SubmissionCommittee::STATUS_ACCEPTED)) { ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-primary btn-assess-form-save']) ?>
            <?php if (isset($model->id)): ?>
                <?= Html::a('<i class="icon wb-print" aria-hidden="true"></i> Export PDF', Url::to(['continue-assess-form/print', 'id' => $model->id]), ['class' => 'btn btn-default', 'target' => '_blank', 'data-pjax' => 0]); ?>
            <?php endif; ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
