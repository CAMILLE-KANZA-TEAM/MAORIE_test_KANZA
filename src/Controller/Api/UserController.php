<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Services\Validators\CheckFields;
use App\Services\PopulateUserData;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller\Api
 */
class UserController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @Route("/api/user/", name="user.create", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param PopulateUserData $populateUserData
     * @param CheckFields $checkFields
     * @return Response
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder, PopulateUserData $populateUserData, CheckFields $checkFields): Response
    {

        $userEntity = new User();
        $populateUserData->initPostData($userEntity);

        $password = $passwordEncoder->encodePassword(
            $userEntity,
            $request->get('password')
        );
        $userEntity->setPassword($password);

        $isValid = $checkFields->isValidEntity($userEntity);
        $response = new Response();
        if ($isValid['totalErrors'] <= 0) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($userEntity);
            $em->flush();

            $response->setContent(json_encode([$userEntity->getId()]));
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(Response::HTTP_OK);
        } else {
            $response->setContent(json_encode($isValid['errors']));
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    /**
     * @Route("/api/user/{id}", name="user.read", defaults={"id": ""}, methods={"GET"})
     * @return JsonResponse
     */
    public function read($id = false, Request $request): Response
    {
        $data = [];
        $response = new Response();
        try {
            $data = $this->userRepository->getData($id, $request->get('sort'), $request->get('order'), $request->get('entity'), $request->get('groupBy'));
            //$response = new Response();
            $response->setContent(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(!empty($data) ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            $response->setContent(json_encode($data));
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $response;
    }


    /**
     * @Route("/api/user/", name="user.update", methods={"PUT"})
     * @param Request $request
     * @return Response
     */
    public function update(Request $request,  UserPasswordEncoderInterface $userPasswordEncoder, PopulateUserData $populateUserData, CheckFields $checkFields): Response
    {
        $data = [];
        $response = new Response();

        $userEntity = $this->userRepository->find($request->get('id'));

        if ($userEntity) {
            // we feel our object
            $populateUserData->initPutData($userEntity);

            $isValid = $checkFields->isValidEntity($userEntity);
            if ($isValid['totalErrors'] <= 0) {
                if ( $request->get('password') ) {
                    $password = $userPasswordEncoder->encodePassword(
                        $userEntity,
                        $request->get('password')
                    );
                    $userEntity->setPassword($password);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($userEntity);
                $em->flush();

                $response->setContent(json_encode(true));
                $response->headers->set('Content-Type', 'application/json');
                $response->setStatusCode(Response::HTTP_OK);
            } else {
                $response->setContent(json_encode($isValid['errors']));
                $response->headers->set('Content-Type', 'application/json');
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $response->setContent(json_encode($data));
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
        }

        return $response;
    }

    /**
     * @Route("/api/user/{id}", name="user.delete", methods={"DELETE"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function delete($id, Request $request): Response
    {
        $data = [];
        $response = new Response();

        $userEntity = $this->userRepository->find($id);
        if ($userEntity) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($userEntity);
            $em->flush();

            $response->setContent(json_encode(true));
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(Response::HTTP_OK);

        } else {
            $response->setContent(json_encode($data));
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
        }

        return $response;
    }


}
