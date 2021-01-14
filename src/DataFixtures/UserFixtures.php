<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFixtures extends Fixture
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
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::MAX_USERS; $i++) {

            $user = new User();

            $role = ($i == 1) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
            $password = $this->encodePassword($user, self::STATIC_PASSWORD);

            $user->setCivility(1)
                ->setUsername('user_' . $i)
                ->setEmail('user_' . $i . '@email.com')
                ->setPassword($password)
                ->setRoles($role)
                ->setIsActive(1)
                ->setCreated(new \DateTime());
            $manager->persist($user);
            $manager->flush();
        }
    }

    private function encodePassword(UserInterface $user, $plainPassword)
    {
        return $this->passwordEncoder->encodePassword($user, $plainPassword);
    }
}
