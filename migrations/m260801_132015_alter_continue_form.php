<?php

use yii\db\Migration;

/**
 * Class m260801_132015_alter_continue_form
 *
 * Keeps the original (un-stamped) CV / training file so the e-signature flow can
 * serve the stamped file when "ประทับชื่อ" is chosen, or revert to the original
 * when it is not — without losing the raw upload.
 */
class m260801_132015_alter_continue_form extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('ethics', 'submission_type_id', $this->integer()->null()->comment('ประเภทรายงาน'));
        $this->addColumn('ethics', 'name_eng', $this->string()->null()->comment('ชื่อภาษาอังกฤษ'));
        $this->addColumn('ethics', 'is_title', $this->smallInteger()->defaultValue(0)->comment('0=เหมาะสม/ไม่เหมาะสม, 1=มี/ไม่มี'));

        $this->addForeignKey('fk_ethics_submission_type_id', 'ethics', 'submission_type_id', 'submission_type', 'id');

        $this->insert('ethics', ['name' => '1. ความเสี่ยงและประโยชน์ของการวิจัย', 'submission_type_id' => 7, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '2. ผู้วิจัยและทีมวิจัยปฏิบัติตามข้อกำหนดที่เกี่ยวข้อง', 'submission_type_id' => 7, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '3. การดำเนินการวิจัยเป็นไปตามโครงการที่ได้รับการรับรอง', 'submission_type_id' => 7, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. กระบวนการให้ข้อมูลและขอความยินยอม รวมถึงการคุ้มครองข้อมูล', 'submission_type_id' => 7, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5. อื่นๆ ระบุ', 'submission_type_id' => 7, 'need_text' => 1]);

        $this->insert('ethics', ['name' => '1. ความเสี่ยงและประโยชน์ของการวิจัย', 'submission_type_id' => 8, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '2. ผู้วิจัยและทีมวิจัยปฏิบัติตามข้อกำหนดที่เกี่ยวข้อง', 'submission_type_id' => 8, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '3. การดำเนินการวิจัยเป็นไปตามโครงการที่ได้รับการรับรอง', 'submission_type_id' => 8, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. กระบวนการให้ข้อมูลและขอความยินยอม รวมถึงการคุ้มครองข้อมูล', 'submission_type_id' => 8, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5. อื่นๆ ระบุ', 'submission_type_id' => 8, 'need_text' => 1]);

        $this->insert('ethics', ['name' => '1. เหตุผล ความจำเป็น และความเหมาะสมทางวิชาการของการปรับปรุงแก้ไข', 'submission_type_id' => 9, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '2. ความเสี่ยง ประโยชน์ และผลกระทบต่อผู้เข้าร่วมวิจัย', 'submission_type_id' => 9, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '3. ความพร้อมในการดำเนินการและความครบถ้วนสอดคล้องของเอกสาร', 'submission_type_id' => 9, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. กระบวนการให้ข้อมูลและขอความยินยอม รวมถึงการคุ้มครองข้อมูล', 'submission_type_id' => 9, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5.การดำเนินการต่อผู้เข้าร่วมวิจัยเดิม', 'submission_type_id' => 9, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '6. อื่นๆ ระบุ', 'submission_type_id' => 9, 'need_text' => 1]);

        $this->insert('ethics', ['name' => '1. ความครบถ้วนและความเกี่ยวข้องของรายงาน', 'submission_type_id' => 10, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '2. ความเหมาะสมของการประเมินความร้ายแรง ความสัมพันธ์ และความคาดหมายของเหตุการณ์', 'submission_type_id' => 10, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '3. ผลกระทบต่อสมดุลประโยชน์–ความเสี่ยงและความปลอดภัยของผู้เข้าร่วมวิจัย', 'submission_type_id' => 10, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. ความเพียงพอของมาตรการแก้ไขและเอกสารที่เกี่ยวข้อง', 'submission_type_id' => 10, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5. ความเหมาะสมและความจำเป็นของการแจ้งข้อมูล การขอความยินยอมใหม่ และการติดตามความปลอดภัยเพิ่มเติม ', 'submission_type_id' => 10, 'need_text' => 0]);

        $this->insert('ethics', ['name' => '1. ความครบถ้วนและความเกี่ยวข้องของรายงาน', 'submission_type_id' => 11, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '2. ความเหมาะสมของการประเมินความร้ายแรง ความสัมพันธ์ และความคาดหมายของเหตุการณ์', 'submission_type_id' => 11, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '3. ผลกระทบต่อสมดุลประโยชน์–ความเสี่ยงและความปลอดภัยของผู้เข้าร่วมวิจัย', 'submission_type_id' => 11, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. ความเพียงพอของมาตรการแก้ไขและเอกสารที่เกี่ยวข้อง', 'submission_type_id' => 11, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5. ความเหมาะสมและความจำเป็นของการแจ้งข้อมูล การขอความยินยอมใหม่ และการติดตามความปลอดภัยเพิ่มเติม ', 'submission_type_id' => 11, 'need_text' => 0]);

        $this->insert('ethics', ['name' => '1. ความครบถ้วนและความเกี่ยวข้องของรายงาน', 'submission_type_id' => 20, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '2. ความเหมาะสมของการประเมินความร้ายแรง ความสัมพันธ์ และความคาดหมายของเหตุการณ์', 'submission_type_id' => 20, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '3. ผลกระทบต่อสมดุลประโยชน์–ความเสี่ยงและความปลอดภัยของผู้เข้าร่วมวิจัย', 'submission_type_id' => 20, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. ความเพียงพอของมาตรการแก้ไขและเอกสารที่เกี่ยวข้อง', 'submission_type_id' => 20, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5. ความเหมาะสมและความจำเป็นของการแจ้งข้อมูล การขอความยินยอมใหม่ และการติดตามความปลอดภัยเพิ่มเติม', 'submission_type_id' => 20, 'need_text' => 0]);

        $this->insert('ethics', ['name' => '1. ผลกระทบต่อสิทธิ ความปลอดภัย และความเป็นอยู่ที่ดีของผู้เข้าร่วมวิจัย', 'submission_type_id' => 12, 'need_text' => 0, 'is_title' => 1]);
        $this->insert('ethics', ['name' => '2. ผลกระทบต่อความถูกต้อง ความครบถ้วน และความน่าเชื่อถือของข้อมูลวิจัย', 'submission_type_id' => 12, 'need_text' => 0, 'is_title' => 1]);
        $this->insert('ethics', ['name' => '3. การแก้ไขและบรรเทาผลกระทบของเหตุการณ์', 'submission_type_id' => 12, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. การวิเคราะห์สาเหตุและมาตรการป้องกันการเกิดซ้ำ', 'submission_type_id' => 12, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5. อื่นๆ ระบุ', 'submission_type_id' => 12, 'need_text' => 1]);

        $this->insert('ethics', ['name' => '1. ความเหมาะสมของการปิดหรือยุติโครงการวิจัย', 'submission_type_id' => 13, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '2. สิทธิ ความปลอดภัย และความเป็นอยู่ที่ดีของผู้เข้าร่วมวิจัย', 'submission_type_id' => 13, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '3. ความครบถ้วนของการดำเนินการและการรายงานข้อมูลด้านความปลอดภัย เหตุการณ์ไม่พึงประสงค์ และการเบี่ยงเบนจากโครงการวิจัย', 'submission_type_id' => 13, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. การจัดเก็บ รักษาความลับ ส่งต่อ หรือทำลายข้อมูลภายหลังสิ้นสุดโครงการ', 'submission_type_id' => 13, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5. อื่นๆ ระบุ', 'submission_type_id' => 13, 'need_text' => 0]);
        
        $this->insert('ethics', ['name' => '1. ความชัดเจนและความจำเป็นของเรื่องที่เสนอ', 'submission_type_id' => 15, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '2. ผลกระทบต่อสิทธิ ความปลอดภัย และความเป็นอยู่ที่ดีของผู้เข้าร่วมวิจัย', 'submission_type_id' => 15, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '3. ความสอดคล้องกับโครงการที่ได้รับการรับรองและข้อกำหนดที่เกี่ยวข้อง', 'submission_type_id' => 15, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '4. ความครบถ้วนของข้อมูลหรือเอกสาร และความเหมาะสมของแนวทางดำเนินการ', 'submission_type_id' => 15, 'need_text' => 0]);
        $this->insert('ethics', ['name' => '5. อื่นๆ ระบุ', 'submission_type_id' => 15, 'need_text' => 0]);        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        
    }

}
