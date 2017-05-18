<?php

namespace SF\PlatformBundle\Repository;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class AdvertRepository extends \Doctrine\ORM\EntityRepository
{

	public function whereCurrentYear(QueryBuilder $qb)

	{

		$qb

		  ->andWhere('a.date BETWEEN :start AND :end')

		  ->setParameter('start', new \Datetime(date('Y').'-01-01'))  // Date entre le 1er janvier de cette année

		  ->setParameter('end',   new \Datetime(date('Y').'-12-31'))  // Et le 31 décembre de cette année

		;

	}

	public function getLastAdvertMenu($limit)
	{
		$qb = $this
		->createQueryBuilder('a')
		->select('a.id, a.title')
		->orderBy('a.date', 'DESC')
		->setMaxResults($limit);

		return $qb
		->getQuery()
		->getArrayResult()
		;
	}

	public function getAdvertCurrentYear()
	{
		$qb = $this->createQueryBuilder('a');

		// // On peut ajouter ce qu'on veut avant
		// $qb
		// ->where('a.author = :author')
		// ->setParameter('author', 'Marine')
		// ;

		// On applique notre condition sur le QueryBuilder
		$this->whereCurrentYear($qb);

		// On peut ajouter ce qu'on veut après
		$qb->orderBy('a.date', 'DESC');


		return $qb
		->getQuery()
		->getResult()
		;
	}


	public function getAdvertWithApplications()
	{
		$qb = $this
		->createQueryBuilder('a')
		->leftJoin('a.applications', 'app')
		->addSelect('app')
		;

		return $qb
		->getQuery()
		->getResult()
		;
	}

	public function getAdvertWithCategories(array $categoryNames)
	{

		$qb = $this
		->createQueryBuilder('a')
		->innerJoin('a.categories', 'cat')
		->addSelect('cat')
		;

		$qb->where($qb->expr()->in('cat.name', $categoryNames));

		return $qb
		->getQuery()
		->getResult()
		;

	}
}
