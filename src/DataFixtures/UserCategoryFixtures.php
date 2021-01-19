<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserCategory;
use App\Repository\TaskCategoryRepository;
use App\Repository\UserCategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserCategoryFixtures
 * @package App\DataFixtures
 */
class UserCategoryFixtures extends Fixture
{

    /**
     * Max category
     */
    const MAX_CATEGORY = 5;


    /**
     * @var UserCategoryRepository
     */
    private UserCategoryRepository $userCategoryRepository;


    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::MAX_CATEGORY; $i++) {

            $userCategory = new UserCategory();
            $userCategory->setIsActive(1);
            $userCategory->setName(md5($i));
            $userCategory->setCreated(new \DateTime());
            $manager->persist($userCategory);
            $manager->flush();
        }
    }

}
