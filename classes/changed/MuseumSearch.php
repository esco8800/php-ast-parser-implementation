<?php
/**
 * Файл класса MuseumSearch
 *
 * @copyright Copyright (c) 2021, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\search;

use Yii;
use yii\db\ActiveQuery;
use chulakov\model\models\search\SearchForm;
use common\modules\user\models\Museum;

class MuseumSearch extends SearchForm
{
    /**
     * @var string
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('ch/user', 'Name'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function applyFilter(ActiveQuery $query)
    {
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
    }

    /**
     * @inheritdoc
     */
    protected function buildSort()
    {
        return [
           'defaultOrder' => [
               'id' => SORT_ASC,
           ],
           'attributes' => ['id', 'name'],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery()
    {
        return Museum::find();
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }
}
