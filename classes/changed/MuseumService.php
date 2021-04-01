<?php
/**
 * Файл класса MuseumService
 *
 * @copyright Copyright (c) 2021, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\services;

use chulakov\model\services\Service;
use common\modules\user\repositories\MuseumRepository;
use common\modules\user\models\factories\MuseumFactory;
use common\modules\user\models\mappers\MuseumMapper;

class MuseumService extends Service
{
    /**
     * Конструктор сервиса
     *
     * @param MuseumRepository $repository
     * @param MuseumFactory $factory
     * @param MuseumMapper $mapper
     */
    public function __construct(
        MuseumRepository $repository,
        MuseumFactory $factory,
        MuseumMapper $mapper
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mapper = $mapper;
    }
}
