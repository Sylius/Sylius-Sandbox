<?php

namespace Application\Bundle\SalesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationSalesBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusSalesBundle';
    }
}
