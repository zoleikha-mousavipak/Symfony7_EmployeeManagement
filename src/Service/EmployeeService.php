<?php

namespace App\Service;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeService {

    public function __construct(
        private EmployeeRepository $employeeRepository
        ) {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAll(): ?array
    {
        return $this->employeeRepository->findAll();
    }

    public function getEmployeesWithHigherSalaryThanSuperior(): ?array
    {
        return $this->employeeRepository->findEmployeesWithHigherSalaryThanSuperior();
    }

    public function getEmployeesWithHighestSalaryPerDepartment(): ?array
    {
        return $this->employeeRepository->findEmployeesWithHighestSalaryPerDepartment();
    }

    public function getEmployeesWithDifferentSuperiorDepartment(): ?array
    {
        return $this->employeeRepository->findEmployeesWithDifferentSuperiorDepartment();
    }

    public function getSubordinatesRecursive(string $id): ?array
    {
        $employee = $this->employeeRepository->findOneBy(['id' => $id]);

        if (!$employee instanceOf Employee) {
             throw new NotFoundHttpException('Employee not found');
         }

        return [$employee, $this->employeeRepository->findSubordinatesRecursive($employee)];
    }



}