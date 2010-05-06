<?php

namespace Blog\Repository;

class Article extends \Doctrine\ORM\EntityRepository
{
    public function findAllDesc($limit = null, $offset = null)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->orderBy('a.date', 'DESC');

        $query = $qb->getQuery();
        if (null !== $limit) {
            $query->setMaxResults($limit);
            if (null !== $offset) {
                $query->setFirstResult($offset);
            }
        }

        return $query->getResult();
    }

    public function findAllPublishedDesc($limit = null, $offset = null)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.published = 1');
        $qb->orderBy('a.date', 'DESC');

        $query = $qb->getQuery();
        if (null !== $limit) {
            $query->setMaxResults($limit);
            if (null !== $offset) {
                $query->setFirstResult($offset);
            }
        }

        return $query->getResult();
    }

    public function findBySlug($slug)
    {
        return $this->findOneBySlug($slug);
    }
}