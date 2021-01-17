<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }


    /**
     * @Route("/api/user/", name="user.create", methods={"POST"})
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $userEntity = new User();
        $password = $passwordEncoder->encodePassword(
            $userEntity,
            $request->get('password')
        );

        $roles = $request->get('roles');
        if ($roles) {
            $roles = [$roles];
        }

        $userEntity->setCivility($request->get('civility'));
        $userEntity->setEmail($request->get('email'));
        $userEntity->setUsername($request->get('email'));
        $userEntity->setPassword($password);
        $userEntity->setIsActive($request->get('isActive'));
        $userEntity->setRoles($roles);

        $em = $this->getDoctrine()->getManager();
        $em->persist($userEntity);
        $em->flush();

        return new Response( json_encode(['id'=>$userEntity->getId()]), Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/user/{id}", name="user.read", defaults={"id": ""}, methods={"GET"})
     * @return JsonResponse
     */
    public function read($id=false, Request $request): Response
    {
        $data = $this->userRepository->getData($request->get('id'), $request->get('filterBy'), $request->get('groupBy'));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/api/user/{id}", name="user.update", methods={"PUT"})
     * @return JsonResponse
     */
    public function update($id): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/api/user", name="user.delete")
     */
    public function delete(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }






}
