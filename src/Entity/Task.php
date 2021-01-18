<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskCategoryRepository;
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
     * @var TaskCategoryRepository
     */
    private TaskCategoryRepository $taskCategoryRepository;

    /**
     * TaskFixtures constructor.
     * @param UserRepository $userRepository
     * @param TaskStatusRepository $taskStatusRepository
     * @param TaskCategoryRepository $taskCategoryRepository
     */
    public function __construct(UserRepository $userRepository, TaskStatusRepository $taskStatusRepository, TaskCategoryRepository $taskCategoryRepository)
    {
        $this->userRepository = $userRepository;
        $this->taskStatusRepository = $taskStatusRepository;
        $this->taskCategoryRepository = $taskCategoryRepository;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $listUsers    = $this->userRepository->findAll();
        $listStatus   = $this->taskStatusRepository->findAll();
        $listCategory = $this->taskCategoryRepository->findAll();

        $randomUser     = $this->_getRandomList($listUsers);
        $randomStatus   = $this->_getRandomList($listStatus);
        $randomCategory = $this->_getRandomList($listCategory);

        $task = new Task();
        $task
            ->setName("task 1")
            ->setTaskStatus($randomStatus)
            ->setTaskCategory($randomCategory)
            ->setOwner($randomUser)
            ->setIsActive(1)
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime());
        $manager->persist($task);
        $manager->flush();



        $randomUser     = $this->_getRandomList($listUsers);
        $randomStatus   = $this->_getRandomList($listStatus);
        $randomCategory = $this->_getRandomList($listCategory);

        $task = new Task();
        $task
            ->setName("task 2")
            ->setTaskStatus($randomStatus)
            ->setTaskCategory($randomCategory)
            ->setOwner($randomUser)
            ->setIsActive(1)
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
    private function _getRandomList($listStatus)
    {
        $ret = null;
        if(is_array($listStatus)) {
            $ret = $listStatus[rand(0, count($listStatus) - 1)];
        }
        return $ret;
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            TaskStatusFixtures::class,
            TaskCategoryFixtures::class,
        );
    }

}
