<?php

namespace Application\Bundle\ThemingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationThemingBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusThemingBundle';
    }    
}
