<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SaeVolunteerEthics;

/* @var $this yii\web\View */
/* @var $model app\models\SaeVolunteer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sae-volunteer-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $this->renderFile('@app/views/widgets/_alert.php'); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model->submissionVolunteer, 'volunteerCode')->textInput(['disabled' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model->submissionVolunteer, 'typeLabel')->textInput(['disabled' => true]) ?>
        </div>
    </div>

    <table class="table table-bordered table-condensed table-striped">

        <?php foreach ($saeEthicses as $saeEthics): ?>

            <?php if ($saeEthics->ethics->is_title != 0): ?>
                <!-- แถวพิเศษ: ตัวเลือกเฉพาะของข้อนี้ รวมอยู่ใน cell เดียว ไม่กระจายตามคอลัมน์หัวตาราง -->
                <?php if ($saeEthics->ethics->is_title == 4) { ?>
                    <tr>
                        <td><?= $saeEthics->ethics->name; ?></td>
                        <td colspan="4">
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_55,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'เสียชีวิต'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block; margin-right:20px;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_41,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'คุกคามต่อชีวิต'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_42,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'เข้ารับการรักษาหรืออยู่โรงพยาบาลนานขึ้น'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_43,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'พิการหรือสูญเสียสมรรถภาพ'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_44,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'ความผิดปกติแต่กำเนิด'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_45,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'เหตุการณ์สำคัญทางการแพทย์'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_46,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'อื่น ๆ ระบุ '),
                                        ], false);
                                ?>
                            </div>
                            <div style="display:inline-block;"><?= $form->field($saeEthics, "[{$saeEthics->ethics_id}]remark")->label(false)->textInput(); ?></div>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($saeEthics->ethics->is_title == 5) { ?>
                    <tr>
                        <td><?= $saeEthics->ethics->name; ?></td>
                        <td colspan="4">
                            <div class="radio-custom radio-primary" style="display:inline-block; margin-right:20px;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_51,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'หายเป็นปกติ'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_52,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'อาการดีขึ้นหรืออยู่ระหว่างการฟื้นตัว'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_53,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'ยังไม่หาย'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_54,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'มีภาวะแทรกซ้อนหรือความพิการ'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_55,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'เสียชีวิต'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_56,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'ยังไม่ทราบผล'),
                                        ], false);
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($saeEthics->ethics->is_title == 6) { ?>
                    <tr>
                        <td><?= $saeEthics->ethics->name; ?></td>
                        <td colspan="4">
                            <div class="radio-custom radio-primary" style="display:inline-block; margin-right:20px;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_61,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'เกี่ยวข้อง'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::NOT_INVOLVED,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'ไม่เกี่ยวข้อง'),
                                        ], false);
                                ?>
                            </div>
                            <div class="radio-custom radio-primary" style="display:inline-block;">
                                <?=
                                $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                    'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                                ])->radio([
                                    'value' => SaeVolunteerEthics::STATUS_63,
                                    'uncheck' => null,
                                    'label' => Yii::t('app', 'ยังไม่สามารถประเมินได้'),
                                        ], false);
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>

            <?php else: ?>
                <tr>
                    <td class="text-center font-weight-900"><?= Yii::t('app', '') ?>
                    <td class="text-center font-weight-900"><?= Yii::t('app', 'เหมาะสม') ?>
                    <td class="text-center font-weight-900"><?= Yii::t('app', 'ไม่เหมาะสม') ?>
                    <td class="text-center font-weight-900"><?= Yii::t('app', 'ข้อมูลไม่เพียงพอสำหรับการประเมิน') ?>
                    <td class="text-center font-weight-900"><?= Yii::t('app', 'หมายเหตุ') ?>
                </tr>
                <tr>
                    <td>
                        <?= $saeEthics->ethics->name; ?>
                        <?php if ($saeEthics->ethics->need_text): ?>
                            <?= $form->field($saeEthics, "[{$saeEthics->ethics_id}]other")->label(false)->textInput(); ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <?=
                            $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                            ])->radio([
                                'value' => SaeVolunteerEthics::APPROPRIATE,
                                'uncheck' => null,
                                'label' => '',
                                    ], false);
                            ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <?=
                            $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                            ])->radio([
                                'value' => SaeVolunteerEthics::INAPPROPRIATE,
                                'uncheck' => null,
                                'label' => '',
                                    ], false);
                            ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="radio-custom radio-primary">
                            <?=
                            $form->field($saeEthics, "[{$saeEthics->ethics_id}]is_appropriate", [
                                'template' => "{input}\n<label>{label}</label>\n{hint}\n{error}",
                            ])->radio([
                                'value' => SaeVolunteerEthics::NOT_DATA,
                                'uncheck' => null,
                                'label' => '',
                                    ], false);
                            ?>
                        </div>
                    </td>
                    <td><?= $form->field($saeEthics, "[{$saeEthics->ethics_id}]remark")->label(false)->textInput(); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
