<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * Liste aller Beschäftigten, welche höheres Gehalt als deren direkte Vorgesetzte haben
     *
     * @return array|null
     */
    public function findEmployeesWithHigherSalaryThanSuperior(): ?array
    {
        $subQuery = $this->createQueryBuilder('s')
            ->select('s.salary')
            ->where('s.id = e.superior');

        return $this->createQueryBuilder('e')
            ->where(
                $this->createQueryBuilder('e')->expr()->gt('e.salary', '(' . $subQuery->getDQL() . ')')
            )
            ->getQuery()
            ->getResult();
    }

    /**
     * Beschäftigte mit jeweils höchstem Gehalt pro Abteilung
     *
     * @return array|null
     */
    public function findEmployeesWithHighestSalaryPerDepartment(): ?array
    {
        return $this->createQueryBuilder('e')
            ->select('e, MAX(e.salary)')
            ->innerJoin('e.department', 'd')
            ->groupBy('d.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * Liste aller Beschäftigten, deren direkte Vorgesetzte nicht in der gleichen Abteilung arbeiten.
     *
     * @return array|null
     */
    public function findEmployeesWithDifferentSuperiorDepartment(): ?array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->leftJoin('e.superior', 's')
            ->where('e.department != s.department')
            ->getQuery()
            ->getResult();
    }


    /**
     * Eine Hierarchische Darstellung von Vorgesetzter-Untergebener-Beziehungen. Von einem Beschäftigten (parametrisierbar),
     * soll also eine rekursive Liste seiner Untergebenen und deren Untergebenen usw. generiert werden.
     *
     * @param Employee $employee
     * @return array|null
     */
    public function findSubordinatesRecursive(Employee $employee): ?array
    {
        $subordinates = [];

        $immediateSubordinates = $this->createQueryBuilder('e')
            ->where('e.superior = :employee')
            ->setParameter('employee', $employee)
            ->getQuery()
            ->getResult();

        foreach ($immediateSubordinates as $subordinate) {
            $subordinates[] = [
                'employee' => $subordinate,
                'subordinates' => $this->findSubordinatesRecursive($subordinate),
            ];
        }

        return $subordinates;
    }

}
