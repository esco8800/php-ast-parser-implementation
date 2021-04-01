<?php
/**
 * Файл класса MuseumFactory
 *
 * @copyright Copyright (c) 2021, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\factories;

use chulakov\model\exceptions\FormException;
use chulakov\model\models\factories\FactoryInterface;
use common\modules\user\models\mappers\MuseumMapper;
use common\modules\user\models\search\MuseumSearch;
use common\modules\user\models\forms\MuseumForm;
use common\modules\user\models\Museum;

class MuseumFactory implements FactoryInterface
{
    /**
     * Создать модель
     *
     * @param array $config
     * @return Museum
     */
    public function makeModel($config = [])
    {
        return new Museum($config);
    }

    /**
     * Создать поисковую модель
     *
     * @param array $config
     * @return MuseumSearch
     */
    public function makeSearch($config = [])
    {
        return new MuseumSearch($config);
    }

    /**
     * Создать форму
     *
     * @param MuseumMapper $mapper
     * @param Museum $model
     * @param array $config
     * @return MuseumForm
     * @throws FormException
     */
    public function makeForm($mapper, $model = null, $config = [])
    {
        return new MuseumForm($mapper, $model, $config);
    }
}
