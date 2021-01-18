<?php
namespace App\Services;

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

class PopulateUserData
{
    /**
     * @var RequestStack
     */
    protected RequestStack $requestStack;

    /**
     * PopulateUserData constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function initPostData(User $userEntity)
    {
        $userEntity->setCivility($this->requestStack->getCurrentRequest()->get('civility'));
        $userEntity->setEmail($this->requestStack->getCurrentRequest()->get('email'));
        $userEntity->setUsername($this->requestStack->getCurrentRequest()->get('username'));
        $userEntity->setIsActive($this->requestStack->getCurrentRequest()->get('isActive'));

        $roles = $this->requestStack->getCurrentRequest()->get('roles', 'ROLE_USER');
        if ($roles) {
            $roles = [$roles];
        }
        $userEntity->setRoles($roles);
    }

    /**
     * Update user object with post data
     * @param User $userEntity
     */
    public function initPutData(User $userEntity) {



        if ($this->requestStack->getCurrentRequest()->get('civility') && $this->requestStack->getCurrentRequest()->get('civility') !== $userEntity->getCivility()) {
            $userEntity->setCivility($this->requestStack->getCurrentRequest()->get('civility'));
        }
        if ($this->requestStack->getCurrentRequest()->get('email') && $this->requestStack->getCurrentRequest()->get('email') !== $userEntity->getEmail()) {
            $userEntity->setEmail($this->requestStack->getCurrentRequest()->get('email'));
        }
        if ($this->requestStack->getCurrentRequest()->get('username') && $this->requestStack->getCurrentRequest()->get('username') !== $userEntity->getUsername()) {
            $userEntity->setUsername($this->requestStack->getCurrentRequest()->get('username'));
        }
        if ($this->requestStack->getCurrentRequest()->get('isActive') && $this->requestStack->getCurrentRequest()->get('isActive') !== $userEntity->getIsActive()) {
            $userEntity->setIsActive($this->requestStack->getCurrentRequest()->get('isActive'));
        }

        /**
        $roles = $this->requestStack->getCurrentRequest()->get('roles', 'ROLE_USER');
        if ($roles) {
            $roles = [$roles];
        }
        $userEntity->setRoles($roles);
        **/

    }

}

