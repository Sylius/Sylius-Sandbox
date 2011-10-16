<?php

namespace Application\Bundle\AssortmentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationAssortmentBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusAssortmentBundle';
    }    
}
