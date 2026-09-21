<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use app\models\SaeAssessForm;
use yii\helpers\ArrayHelper;
use app\models\Submission;
use app\models\Resolution;
use yii\helpers\Url;
use app\models\ReviewChoice;

/* @var $this yii\web\View */
/* @var $model app\models\SaeAssessForm */
/* @var $form yii\widgets\ActiveForm */
$reviewChoicesByType = ArrayHelper::index($reviewChoices, null, 'type');

$currentRole = \Yii::$app->session->get('currentRole');
?>

<div class="sae-assess-form-form">

    <?php
    $form = ActiveForm::begin([
//                'layout' => 'inline',
                'id' => 'submission-type-assess-form',
                'enableClientValidation' => false,
                'action' => Url::to(['sae-assess-form/create', 'submissionId' => $model->submission_id, 'submissionCommitteeId' => $model->submission_committee_id]),
    ]);
    ?>
    <?= $this->renderFile('@app/views/widgets/_alert.php'); ?>

    <table class="table table-condensed table-bordered">
        <tbody>
            <tr>
                <td class="text-center font-weight-900" style="background-color: #DCDCDC;"><?= Yii::t('app', 'ข้อสรุปของกรรมการ') ?></td>
            </tr>
            <tr>
                <td  class="text-center font-weight-900"><?= $form->field($model, 'suggestion')->label(false)->textarea(['rows' => 4]) ?></td>
            </tr>
            <tr>
                <td class="text-center font-weight-900" style="background-color: #DCDCDC;"><?= Yii::t('app', 'ข้อคิดเห็นของกรรมการ') ?></td>
            </tr>
            <tr>
                <td>
                    <?php
                    echo $form->field($model, 'review_choice_id')->label(false)->radioList(ArrayHelper::map($reviewChoicesByType[$model->submission->submission_type_id], 'id', 'name'), [
                        'unselect' => NULL,
                        'item' => function ($index, $label, $name, $checked, $value) use ($model, $form) {
                            $id = "review_choice_id-{$value}";
                            $res = '';
                            $style = '';
                            $rc = ReviewChoice::findOne($value);
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
                                                                    "SaeAssessForm[reviewChoiceTexts][{$value}]",
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
        </tbody>
    </table>
    <?php if ((($currentRole['role_id'] == \app\models\Role::STAFF) || $currentRole['role_id'] == \app\models\Role::ADMIN) || ($currentRole['role_id'] == \app\models\Role::COMMITTEE && $model->submissionCommittee->status == app\models\SubmissionCommittee::STATUS_ACCEPTED)) { ?>
        <div class="form-group margin-15">
            <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-primary btn-assess-form-save']) ?>

            <?php if (isset($model->id)){ ?>
                <a href="<?= Url::to(['sae-assess-form/print-pdf', 'id' => $model->id]) ?>" data-pjax="0" style="text-decoration: none" target="_blank">
                    <button type="button" class="btn btn-default"><i class="icon wb-print" aria-hidden="true"></i> <?= Yii::t('app', 'พิมพ์ฟอร์ม') ?></button>
                </a>
            <?php } ?>
        </div>
    <?php } ?>


    <?php ActiveForm::end(); ?>

</div>
