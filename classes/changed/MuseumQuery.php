<?php
/**
 * Файл класса MuseumQuery
 *
 * @copyright Copyright (c) 2021, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\scopes;

use chulakov\model\models\scopes\ActiveQuery;
use chulakov\model\models\scopes\QueryIdTrait;

class MuseumQuery extends ActiveQuery
{
    use QueryIdTrait;
}
