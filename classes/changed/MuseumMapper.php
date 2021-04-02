<?php
/**
 * Файл класса MuseumMapper
 *
 * @copyright Copyright (c) 2021, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\mappers;

use Yii;
use chulakov\base\traits\SingletonTrait;
use chulakov\model\models\mappers\Mapper;
use chulakov\model\models\mappers\types\NullType;
use chulakov\model\models\mappers\types\ModelType;
use common\modules\user\models\Museum;

class MuseumMapper extends Mapper
{
    use SingletonTrait;

    /**
     * @inheritdoc
     */
    public function initFillAttributes()
    {
        return ['name', 'address', 'slug', 'type'];
    }

    /**
     * @inheritdoc
     */
    public function initAcceptedModelTypes()
    {
        return [
            new NullType(),
            new ModelType(Museum::class),
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelRules()
    {
        return [
            [['name', 'address', 'slug', 'type'], 'required'],
            [['name', 'address'], 'string', 'max' => 128],
            [['slug'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 6],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function initModelLabels()
    {
        return [
            'id' => Yii::t('ch/all', 'ID'),
            'name' => Yii::t('ch/user', 'Name'),
            'address' => Yii::t('ch/user', 'Address'),
            'created_at' => Yii::t('ch/all', 'Created At'),
            'updated_at' => Yii::t('ch/all', 'Updated At'),
            'slug' => Yii::t('ch/all', 'Slug'),
            'type' => Yii::t('ch/user', 'Type'),
        ];
    }
}
