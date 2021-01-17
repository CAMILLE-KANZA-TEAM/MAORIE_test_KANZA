<?php

namespace App\DataFixtures;

use App\Entity\TaskStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TaskStatusFixtures
 * @package App\DataFixtures
 */
class TaskStatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $category = new TaskStatus();
        $category->setValue(TaskStatus::TASK_ON);
        $category->setName('En cours');
        $category->setCreated(new \DateTime());
        $category->setUpdated(new \DateTime());
        $manager->persist($category);
        $manager->flush();

        $category = new TaskStatus();
        $category->setValue(TaskStatus::TASK_WAITING);
        $category->setName('En attente');
        $category->setCreated(new \DateTime());
        $category->setUpdated(new \DateTime());
        $manager->persist($category);
        $manager->flush();

        $category = new TaskStatus();
        $category->setValue(TaskStatus::TASK_DONE);
        $category->setName('Terminées');
        $category->setCreated(new \DateTime());
        $category->setUpdated(new \DateTime());
        $manager->persist($category);
        $manager->flush();

    }
}
