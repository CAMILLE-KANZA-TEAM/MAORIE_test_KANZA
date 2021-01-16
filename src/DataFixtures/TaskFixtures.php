<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TaskFixtures
 * @package App\DataFixtures
 */
class TaskFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {

        $task = new Task();
        $task
            ->setName("test")
            ->setIsActive(1)
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime());
        $manager->persist($task);
        $manager->flush();

        $task = new Task();
        $task
            ->setName("test2")
            ->setIsActive(1)
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime());
        $manager->persist($task);
        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }

}
