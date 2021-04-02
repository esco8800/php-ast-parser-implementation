<?php
/**
 * Файл модели Museum
 *
 * @copyright Copyright (c) 2021, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use chulakov\model\models\ActiveRecord;
use common\modules\user\models\scopes\MuseumQuery;
use common\modules\user\models\mappers\MuseumMapper;

/**
 * Класс модели для работы с данными таблицы "museum".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $slug
 * @property string $type
 */
class Museum extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%museum}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            TimestampBehavior::class,
        ];
    }

    /**
     * @return MuseumQuery
     */
    public static function find()
    {
        return new MuseumQuery(get_called_class());
    }

    /**
     * @return MuseumMapper
     */
    public static function mapper()
    {
        return MuseumMapper::instance();
    }

    /**
     * @return MuseumMapper
     */
    public static function newGenerate()
    {
        return 'new';
    }
}
