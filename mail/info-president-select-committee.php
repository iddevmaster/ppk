<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
if (isset($submission->president_person)) {
    $namePresident = $submission->presidentPerson->person->fullName;
} else {
    $namePresident = $submission->project->panel->chairman->fullName;
}

$committees = app\models\SubmissionCommittee::find()->isDeleted(false)->submission($submission->id)->all();
?>
<div style="text-align: center"><img src="<?= Url::to(Yii::$app->urlManager->baseUrl . '/images/logo.png', true) ?>" width="90"></div>
<div style="text-align: center; font-size: 18px"><?= Yii::$app->name ?></div>
<h4><?= \Yii::t('app', 'เรื่อง แจ้งการเลือกกรรมการประจำโครงการ [{1}] [{0}] ', [$submission->submissionType->name, $submission->project->project_code]); ?></h4>
<p><?= Yii::t('app', 'เรียน ') ?>  <?= $namePresident; ?></p>
<br>
<table border="1" cellspacing="0" class="Table" style="border-collapse:collapse; border:solid #cccccc 1.0pt; width:100%">
    <thead>
        <tr>
            <td colspan="2" style="background-color:#f2f2f2">
                <p><strong>โครงการเลขที่ </strong><strong><?= $submission->project->project_code ?> </strong></p>

                <p><strong>ประเภทโครงการ </strong><strong><?= $submission->submissionType->name; ?>  <?= isset($submission->assess_type) ? 'ประเภทพิจารณา : ' . app\models\Submission::getAssessTypeLabel()[$submission->assess_type] : ""; ?></strong></p>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="width:20%">
                <p>ภาษาไทย</p>
            </td>
            <td style="width:80%">
                <p><?= $submission->project->name_thai ?></p>
            </td>
        </tr>
        <tr>
            <td style="width:20%">
                <p>ภาษาอังกฤษ</p>
            </td>
            <td style="width:80%">
                <p><?= $submission->project->name_eng ?></p>
            </td>
        </tr>
    </tbody>
</table>

<p>บัดนี้ เลขานุการ ได้ทำการเลือกกรรมการผู้ทบทวนโครงการแล้ว โดยมีรายชื่อกรรมการดังต่อไปนี้</p>
<?= $submission->getCommitteePersonList() ?>
<br>
<p>จึงเรียนมาเพื่อโปรดทราบ</p>

<P><font style="color: red"><?= $submission->contactLetter; ?></font></P>



