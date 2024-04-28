<?php

namespace App\Service;

use App\Repository\DepartmentRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DepartmentService {

    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
    }

    public function getAll(): ?array
    {
        return $this->departmentRepository->findAll();
    }

    public function getDepartmentsWithMoreThanXEmployees($x): array
    {
        return $this->departmentRepository->findDepartmentsWithMoreThanXEmployees($x);
    }

    public function getDepartmentsWithHighestTotalSalaryExpenditure(): ?array
    {
        return $this->departmentRepository->findDepartmentsWithHighestTotalSalaryExpenditure();
    }




}