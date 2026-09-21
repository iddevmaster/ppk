<?php

use yii\helpers\Html;
use app\models\Setting;

/* @var $this yii\web\View */
/* @var $model app\models\DeviationAssessForm */
?>
<div class="deviation-assess-form-create">
    <?php if ($model->submission->id > Setting::getValue(Setting::START_NEW_VERSION)) { ?>

        <?=
        $this->render('_form', [
            'model' => $model,
            'reviewChoices' => $reviewChoices,
            'resolutions' => $resolutions,
        ])
        ?>
    <?php } else { ?>
        <?=
        $this->render('_form-old', [
            'model' => $model,
            'reviewChoices' => $reviewChoices,
            'resolutions' => $resolutions,
        ])
        ?>
    <?php } ?>

</div>
