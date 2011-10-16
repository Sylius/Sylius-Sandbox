<?php

namespace Application\Bundle\CatalogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationCatalogBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusCatalogBundle';
    }    
}
