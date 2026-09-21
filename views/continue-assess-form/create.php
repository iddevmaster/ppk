<?php

use yii\helpers\Html;
use app\models\Setting;

/* @var $this yii\web\View */
/* @var $model app\models\ContinueAssessForm */
?>
<div class="continue-assess-form-create">
    <?php if ($model->submission->id > Setting::getValue(Setting::START_NEW_VERSION)) { ?>

        <?=
        $this->render('_form', [
            'model' => $model,
            'ethicses' => $ethicses,
            'conEthicses' => $conEthicses,
            'reviewChoices' => $reviewChoices,
            'resolutions' => $resolutions,
        ])
        ?>
    <?php } else { ?>
        <?=
        $this->render('_form-old', [
            'model' => $model,
            'ethicses' => $ethicses,
            'conEthicses' => $conEthicses,
            'reviewChoices' => $reviewChoices,
            'resolutions' => $resolutions,
        ])
        ?>
    <?php } ?>

</div>
