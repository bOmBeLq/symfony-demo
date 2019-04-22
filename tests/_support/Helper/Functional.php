<?php

namespace App\Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I


class Functional extends \Codeception\Module
{


    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->getDoctrineModule()->_getEntityManager();
    }

    /**
     * @return \Codeception\Module\Doctrine2
     */
    public function getDoctrineModule()
    {
        return $this->getModule('Doctrine2');
    }
}
