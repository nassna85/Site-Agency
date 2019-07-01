<?php


namespace App\Services;

use Doctrine\Common\Persistence\ObjectManager;


class Stats
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return int
     */
    public function getPropertiesCount()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(p) FROM App\Entity\Properties p '
        )->getSingleScalarResult();
    }

    public function getPropertiesNoApprovedCount()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(p) FROM App\Entity\Properties p
            WHERE p.approved = 0'
        )->getSingleScalarResult();
    }

    /**
     * @return int
     */
    public function getUserCount()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(u) FROM App\Entity\User u '
        )->getSingleScalarResult();
    }

    /**
     * @return int
     */
    public function getContactPropertyCount()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(c) FROM App\Entity\ContactForProperty c '
        )->getSingleScalarResult();
    }

    public function getContactPropertyNoAnsweredCount()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(c) FROM App\Entity\ContactForProperty c
            WHERE c.answered = 0'
        )->getSingleScalarResult();
    }

    /**
     * @return int
     */
    public function getContactCount()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(c) FROM App\Entity\Contact c '
        )->getSingleScalarResult();
    }

    /**
     * @return int
     */
    public function getCommentCount()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(c) FROM App\Entity\Comments c '
        )->getSingleScalarResult();
    }

    public function getCommentsNoApprovedCount()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(c) FROM App\Entity\Comments c
            WHERE c.approved = 0'
        )->getSingleScalarResult();
    }
}