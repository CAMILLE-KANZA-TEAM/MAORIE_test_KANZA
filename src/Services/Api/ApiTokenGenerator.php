<?php
namespace App\Services\Api;

use App\Entity\CountVisiteurs;
use Psr\Log\LoggerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Filesystem\Filesystem;
use App\Entity\GroupeChat;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mime\Test\Constraint\EmailAddressContains;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EmailValidator;
use Symfony\Component\Validator\Constraints\IsNull;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

/**
 * Class ApiTokenGenerator
 * @package App\Services\Api
 */
class ApiTokenGenerator
{
    /**
     * @var RequestStack
     */
    protected RequestStack $requestStack;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * PopulateUserData constructor.
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $entity
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entity)
    {
        $this->requestStack = $requestStack;
        $this->em = $entity;
    }

    /**
     * @param User $user
     * @return string
     */
    public function generateToken(User $user)
    {
        $token = md5(uniqid('').time());
        $user->setApiToken($token);
        $this->em->persist($user);
        $this->em->flush();

        return $token;
    }

}

