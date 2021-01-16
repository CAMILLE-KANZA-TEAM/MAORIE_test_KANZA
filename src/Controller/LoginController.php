<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginController extends AbstractController
{

    protected static $defaultName = 'security:encode-password';

    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }


    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param UserRepository $userRepository
     */
    public function loginAction(Request $request, UserRepository $userRepository)
    {

        if ($request->getMethod() == "POST")
        {
            $login    = $request->request->get('login');
            $password = $request->request->get('password');

            //$em = $this->getDoctrine()->getManager();

            $user = $userRepository->findOneBy(array('username' => $login, 'password' => $password));

            $factory = $encoder = $this->encoderFactory->getEncoder(User::class);

            dump($user, $factory);
            die;


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
