<?php

namespace HS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HSUserBundle extends Bundle
{
	public function getParent()
  	{
    	return 'FOSUserBundle';
  	}
}
