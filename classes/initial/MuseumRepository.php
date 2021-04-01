<?php
/**
 * Файл класса MuseumRepository
 *
 * @copyright Copyright (c) 2021, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\repositories;

use chulakov\model\repositories\Repository;
use common\modules\user\models\scopes\MuseumQuery;
use common\modules\user\models\Museum;

class MuseumRepository extends Repository
{
    /**
     * Модель поиска
     *
     * @return MuseumQuery
     */
    public function query()
    {
        return Museum::find();
    }
}
