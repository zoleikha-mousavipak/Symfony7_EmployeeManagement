<?php

namespace App\Repository;

use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Department>
 *
 * @method Department|null find($id, $lockMode = null, $lockVersion = null)
 * @method Department|null findOneBy(array $criteria, array $orderBy = null)
 * @method Department[]    findAll()
 * @method Department[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }


     /**
     * Liste aller Abteilungen mit mehr als X Beschäftigten. X ist ein Parameter, der eine
     *
     * @param [type] $x
     * @return array
     */
    public function findDepartmentsWithMoreThanXEmployees($x): array
    {
        return $this->createQueryBuilder('d')
            ->select('d, COUNT(e) as employeeCount')
            ->leftJoin('d.employees', 'e')
            ->groupBy('d.id')
            ->having('employeeCount > :x')
            ->setParameter('x', $x)
            ->getQuery()
            ->getResult();
    }


    /**
     * Abteilung(en) mit höchsten Gesamtausgaben für Gehälter
     *
     * @return array|null
     */
    public function findDepartmentsWithHighestTotalSalaryExpenditure(): ?array
    {
        return $this->createQueryBuilder('d')
            ->select('d', 'SUM(e.salary) AS total_salary_expenditure')
            ->leftJoin('d.employees', 'e')
            ->groupBy('d.id')
            ->orderBy('total_salary_expenditure', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

}
