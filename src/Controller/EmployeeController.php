<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Service\EmployeeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EmployeeController extends AbstractController
{

    public function __construct(
        private EmployeeService $employeeService,
        )
    {
        $this->employeeService = $employeeService;
    }

    #[Route('/employee', name: 'app_employee')]
    public function index(): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $this->employeeService->getAll(),
        ]);
    }


    #[Route('/employee/higher-salary', name: 'app_higher_salary')]
    public function listEmployeesWithHigherSalaryThanSuperior()
    {
        return $this->render('employee/higher_salary.html.twig', [
            'employees' => $this->employeeService->getEmployeesWithHigherSalaryThanSuperior(),
        ]);
    }

    #[Route('/employee/max-salary', name: 'app_max_salary')]
    public function listEmployeesWithHighestSalaryPerDepartment()
    {
        return $this->render('employee/highest_salary.html.twig', [
            'employees' => $this->employeeService->getEmployeesWithHighestSalaryPerDepartment(),
        ]);
    }


    #[Route('/employee/different-superior-dep', name: 'different_supervisor_department')]
    public function listEmployeesWithDifferentSuperiorDepartment()
    {
        return $this->render('employee/different_supervisor_dep.html.twig', [
            'employees' => $this->employeeService->getEmployeesWithDifferentSuperiorDepartment(),
        ]);
    }


    #[Route('/employee/subordinates/{id}', name: 'employee_subordinates')]
    #[IsGranted('ROLE_ADMIN')]
    public function getSubordinates(string $id): Response
    {

        try {
            [$employee, $subordinates] = $this->employeeService->getSubordinatesRecursive($id);

            return $this->render('employee/employee.html.twig', [
                'employee' => $employee,
                'subordinates' => $subordinates,
            ]);
        } catch (\Throwable $th) {
            return $this->render('_errorPage.html.twig', [
                'errorMessage' => 'Employee not found!',
            ]);
        }
    }

}

