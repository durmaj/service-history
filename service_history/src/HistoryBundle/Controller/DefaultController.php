<?php

namespace HistoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        if ($this->isGranted('ROLE_USER')) {

            return $this->redirectToRoute('car_index');

        } else {
            return $this->redirectToRoute('fos_user_security_login');

        }

    }
}
