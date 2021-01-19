<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\TaskCategoryRepository;
use App\Repository\UserCategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Max created user
     */
    const MAX_USERS = 5;

    /**
     * Default password for all created users
     */
    const STATIC_PASSWORD = 'password';

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @var UserCategoryRepository
     */
    private UserCategoryRepository $userCategoryRepository;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserCategoryRepository $userCategoryRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userCategoryRepository = $userCategoryRepository;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::MAX_USERS; $i++) {

            $user = new User();

            $role = ($i == 1) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
            $password = $this->encodePassword($user, self::STATIC_PASSWORD);

            $userCategory = $this->userCategoryRepository->findAll();
            $randomUserCategory = $this->_getRandomList($userCategory);

            $user->setCivility(1)
                ->setUsername('user_' . $i)
                ->setEmail('user_' . $i . '@email.com')
                ->setPassword($password)
                ->setApiToken('user_' . $i)
                ->setCategory($randomUserCategory)
                ->setRoles($role)
                ->setIsActive(1)
                ->setCreated(new \DateTime());
            $manager->persist($user);
            $manager->flush();
        }
    }

    /**
     * @param $listStatus
     * @return mixed
     */
    private function _getRandomList($listStatus)
    {
        $ret = null;
        if(is_array($listStatus)) {
            $ret = $listStatus[rand(0, count($listStatus) - 1)];
        }
        return $ret;
    }

    private function encodePassword(UserInterface $user, $plainPassword)
    {
        return $this->passwordEncoder->encodePassword($user, $plainPassword);
    }

    public function getDependencies()
    {
        return array(
            UserCategoryFixtures::class,
        );
    }
}
