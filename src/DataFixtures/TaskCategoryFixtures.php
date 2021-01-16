<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\TaskCategory;

/**
 * Class TaskCategoryFixtures
 * @package App\DataFixtures
 */
class TaskCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new TaskCategory();
        $category->setName('PHP');
        $category->setCreated(new \DateTime());
        $category->setUpdated(new \DateTime());
        $category->setIsActive(1);
        $manager->persist($category);
        $manager->flush();

        $category = new TaskCategory();
        $category->setName('JAVA');
        $category->setCreated(new \DateTime());
        $category->setUpdated(new \DateTime());
        $category->setIsActive(1);
        $manager->persist($category);
        $manager->flush();

        $category = new TaskCategory();
        $category->setName('.NET');
        $category->setCreated(new \DateTime());
        $category->setUpdated(new \DateTime());
        $category->setIsActive(1);
        $manager->persist($category);
        $manager->flush();

    }
}
