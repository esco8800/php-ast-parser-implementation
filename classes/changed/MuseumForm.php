<?php
/**
 * Файл класса MuseumForm
 *
 * @copyright Copyright (c) 2021, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\forms;

use chulakov\model\models\forms\Form;
use common\modules\user\models\Museum;

/**
 * Форма редактирования модели Museum
 */
class MuseumForm extends Form
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $address;
    /**
     * @var string
     */
    public $slug;
    /**
     * @var string
     */
    public $type;
}
