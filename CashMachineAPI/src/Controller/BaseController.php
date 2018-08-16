<?php
declare(strict_types=1);

namespace Xshifty\CashMachineAPI\Controller;

use \Interop\Container\ContainerInterface;

abstract class BaseController
{
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
