<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\StatusRepository;
use App\Repository\TaskStatusRepository;
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

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;


    /**
     * @var TaskStatusRepository
     */
    private TaskStatusRepository $taskStatusRepository;

    /**
     * TaskFixtures constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, TaskStatusRepository $taskStatusRepository)
    {
        $this->userRepository = $userRepository;
        $this->taskStatusRepository = $taskStatusRepository;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $listUsers = $this->userRepository->findAll();
        $listStatus = $this->taskStatusRepository->findAll();

        $randomUser = $this->_getRandomUser($listUsers);
        $randomStatus = $this->_getRandomStatus($listStatus);
        $task = new Task();
        $task
            ->setName("test")
            ->setStatus($randomStatus)
            ->setOwner($randomUser)
            ->setIsActive(1)
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime());
        $manager->persist($task);
        $manager->flush();

        $randomUser = $this->_getRandomUser($listUsers);
        $randomStatus = $this->_getRandomStatus($listStatus);
        $task = new Task();
        $task
            ->setName("test2")
            ->setIsActive(1)
            ->setStatus($randomStatus)
            ->setOwner($randomUser)
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime());
        $manager->persist($task);
        $manager->flush();

    }

    /**
     * @param $listUsers
     * @return mixed
     */
    private function _getRandomUser($listUsers)
    {
        return $listUsers[rand(0, count($listUsers) - 1)];
    }

    /**
     * @param $listStatus
     * @return mixed
     */
    private function _getRandomStatus($listStatus)
    {
        return $listStatus[rand(0, count($listStatus) - 1)];
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            TaskStatusFixtures::class,
        );
    }

}
