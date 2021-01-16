<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    public function registerAction()
    {
        // ...
        if ($this->get("request")->getMethod() == "POST")
        {
            // ... Do any password setting here etc

            $em->persist($user);
            $em->flush();

            // Here, "public" is the name of the firewall in your security.yml
            $token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());

            // For older versions of Symfony, use security.context here
            $this->get("security.token_storage")->setToken($token);

            // Fire the login event
            // Logging the user in above the way we do it doesn't do this automatically
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            // maybe redirect out here
        }
    }
}
