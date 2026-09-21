<?php

use yii\db\Migration;

/**
 * Class m260819_143302_alter_deviation_event
 *
 * Keeps the original (un-stamped) CV / training file so the e-signature flow can
 * serve the stamped file when "ประทับชื่อ" is chosen, or revert to the original
 * when it is not — without losing the raw upload.
 */
class m260819_143302_alter_deviation_event extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('deviation_event', 'is_important_pd', $this->integer()->null()->comment('Important protocol deviation'));
        $this->addColumn('deviation_event', 'is_serious_nc', $this->integer()->null()->comment('Serious non-compliance'));
        $this->addColumn('deviation_event', 'is_np', $this->integer()->null()->comment('Unanticipated problem'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        
    }

}
