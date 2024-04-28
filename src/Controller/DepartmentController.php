<?php

namespace App\Controller;

use App\Service\DepartmentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DepartmentController extends AbstractController
{
    
    public function __construct(
        private DepartmentService $departmentService,
        )
    {
        $this->departmentService = $departmentService;
    }
    
    #[Route('/department', name: 'app_department')]
    #[IsGranted('ROLE_MANAGER')]
    public function index(): Response
    {
        return $this->render('department/index.html.twig', [
            'departments' => $this->departmentService->getAll(),
        ]);
    }

    #[Route('/department/more-than/{x}', name: 'app_morethan_x')]
    #[IsGranted('ROLE_MANAGER')]
    public function listDepartmentsWithMoreThanXEmployees($x)
    {
        $error='';
        // Check if x is not negative
        if ($x < 0) {
            $error ='Parameter x must be a non-negative number.';
            return $this->render('department/morethan_x.html.twig', [
                'error' => $error
            ]);
        } else {
            return $this->render('department/morethan_x.html.twig', [
                'departments' => $this->departmentService->getDepartmentsWithMoreThanXEmployees($x),
                'error' => ''
            ]);
        }
    }

    #[Route('/department/highest-salary', name: 'highest_salary_expenditure')]
    #[IsGranted('ROLE_MANAGER')]
    public function listDepartmentsWithHighestTotalSalaryExpenditure()
    {
        return $this->render('department/highest_salary_sum.html.twig', [
            'departments' => $this->departmentService->getDepartmentsWithHighestTotalSalaryExpenditure(),
        ]);
    }
}
