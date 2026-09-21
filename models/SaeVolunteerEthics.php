<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sae_volunteer_ethics".
 *
 * @property int $id
 * @property int $sae_volunteer_id ฟอร์มประเมิน
 * @property int $ethics_id ประเด็นจริยธรรม
 * @property int $is_appropriate เหมาะสมหรือไม่
 * @property string $other อื่นๆ
 * @property string $remark หมายเหตุ
 * @property int $deleted 0=ใช้งาน,1=ไม่ใช้งาน
 * @property int $created_by สร้างโดย
 * @property string $created_at สร้างเมื่อ
 * @property int $updated_by ปรับปรุงโดย
 * @property string $updated_at ปรับปรุงเมื่อ
 *
 * @property User $createdBy
 * @property Ethics $ethics
 * @property SaeVolunteer $saeVolunteer
 * @property User $updatedBy
 */
class SaeVolunteerEthics extends \yii\db\ActiveRecord {

    const INAPPROPRIATE = 0;
    const APPROPRIATE = 1;
    const NOT_INVOLVED = 2;
    const NOT_DATA = 3;
    const STATUS_41 = 4;
    const STATUS_42 = 5;
    const STATUS_43 = 6;
    const STATUS_44 = 7;
    const STATUS_45 = 8;
    const STATUS_46 = 9;
    const STATUS_51 = 10;
    const STATUS_52 = 11;
    const STATUS_53 = 12;
    const STATUS_54 = 13;
    const STATUS_55 = 14;
    const STATUS_56 = 15;
    const STATUS_61 = 16;
    const STATUS_62 = 17;
    const STATUS_63 = 18;

    /**
     * {@inheritdoc}
     */
    public static function getStatusLabelsEthics() {
        return [
            self::INAPPROPRIATE => Yii::t('app', 'ไม่เหมาะสม'),
            self::APPROPRIATE => Yii::t('app', 'เหมาะสม'),
            self::NOT_INVOLVED => Yii::t('app', 'ไม่เกี่ยวข้อง'),
            self::NOT_DATA => Yii::t('app', 'ข้อมูลไม่เพียงพอสำหรับการประเมิน'),
            self::STATUS_41 => Yii::t('app', 'คุกคามต่อชีวิต'),
            self::STATUS_42 => Yii::t('app', 'เข้ารับการรักษาหรืออยู่โรงพยาบาลนานขึ้น'),
            self::STATUS_43 => Yii::t('app', 'พิการหรือสูญเสียสมรรถภาพ'),
            self::STATUS_44 => Yii::t('app', 'ความผิดปกติแต่กำเนิด'),
            self::STATUS_45 => Yii::t('app', 'เหตุการณ์สำคัญทางการแพทย์'),
            self::STATUS_46 => Yii::t('app', 'อื่น ๆ ระบุ'),
            self::STATUS_51 => Yii::t('app', 'หายเป็นปกติ'),
            self::STATUS_52 => Yii::t('app', 'อาการดีขึ้นหรืออยู่ระหว่างการฟื้นตัว'),
            self::STATUS_53 => Yii::t('app', 'ยังไม่หาย'),
            self::STATUS_54 => Yii::t('app', 'มีภาวะแทรกซ้อนหรือความพิการ'),
            self::STATUS_55 => Yii::t('app', 'เสียชีวิต'),
            self::STATUS_56 => Yii::t('app', 'ยังไม่ทราบผล'),
            self::STATUS_61 => Yii::t('app', 'เกี่ยวข้อง'),
            self::STATUS_63 => Yii::t('app', 'ยังไม่สามารถประเมินได้'),
        ];
    }

    public static function tableName() {
        return 'sae_volunteer_ethics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // [['is_appropriate'], 'required'],
            [['sae_volunteer_id', 'ethics_id', 'is_appropriate', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['other', 'remark'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['ethics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ethics::className(), 'targetAttribute' => ['ethics_id' => 'id']],
            [['sae_volunteer_id'], 'exist', 'skipOnError' => true, 'targetClass' => SaeVolunteer::className(), 'targetAttribute' => ['sae_volunteer_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'sae_volunteer_id' => Yii::t('app', 'ฟอร์มประเมิน'),
            'ethics_id' => Yii::t('app', 'ประเด็นจริยธรรม'),
            'is_appropriate' => Yii::t('app', 'เหมาะสมหรือไม่'),
            'other' => Yii::t('app', 'อื่นๆ'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
            'deleted' => Yii::t('app', '0=ใช้งาน,1=ไม่ใช้งาน'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_by' => Yii::t('app', 'ปรับปรุงโดย'),
            'updated_at' => Yii::t('app', 'ปรับปรุงเมื่อ'),
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function() {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEthics() {
        return $this->hasOne(Ethics::className(), ['id' => 'ethics_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaeVolunteer() {
        return $this->hasOne(SaeVolunteer::className(), ['id' => 'sae_volunteer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return SaeVolunteerEthicsQuery the active query used by this AR class.
     */
    public static function find() {
        return new SaeVolunteerEthicsQuery(get_called_class());
    }

}
