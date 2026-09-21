<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PersonRolePanel]].
 *
 * @see PersonRolePanel
 */
class PersonRolePanelQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return PersonRolePanel[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PersonRolePanel|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function isDeleted($deleted = TRUE) {
        return $this->andWhere(['person_role_panel.deleted' => $deleted]);
    }

    public function isRegular($regular = TRUE) {
        return $this->andWhere(['person_role_panel.is_regular' => $regular]);
    }

    public function panel($panelId) {
        return $this->andWhere(['person_role_panel.panel_id' => $panelId]);
    }

    public function role($roleId) {
        return $this->andWhere(['person_role.role_id' => $roleId]);
    }

    public function person($personId) {
        return $this->andWhere(['person_role.person_id' => $personId]);
    }

    public function hasCOI($submissionId) {
        $subQuery = (new \yii\db\Query())->select('person_id')->from('submission_coi_person')->where(['submission_coi_person.submission_id' => $submissionId])->andWhere('submission_coi_person.person_id=person_role.person_id')->andWhere('submission_coi_person.deleted=0');
        return $this->andWhere(['not exists', $subQuery]);
    }

}
