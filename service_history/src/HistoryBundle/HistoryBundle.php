<?php

namespace HistoryBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HistoryBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
