<?php

use yii\helpers\Html;
use app\models\Setting;

/* @var $this yii\web\View */
/* @var $model app\models\SaeAssessForm */
?>
<div class="sae-assess-form-create">
    <?php if ($model->submission->id > Setting::getValue(Setting::START_NEW_VERSION)) { ?>
        <?=
        $this->render('_form-resolution', [
            'model' => $model,
            'resolutions' => $resolutions,
            'reviewChoices' => $reviewChoices,
        ])
        ?>
    <?php } else { ?>
            <?=
        $this->render('_form-resolution-old', [
            'model' => $model,
            'resolutions' => $resolutions,
            'reviewChoices' => $reviewChoices,
        ])
        ?>
    <?php } ?>
</div>
