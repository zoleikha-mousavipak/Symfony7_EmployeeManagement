<?php

namespace App\DataFixtures;

use Datetime;
use App\Entity\User;
use App\Entity\Employee;
use App\Entity\Department;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

    // Create departments
    $department1 = new Department();
    $department1->setName('IT');
    $manager->persist($department1);

    $department2 = new Department();
    $department2->setName('Sales');
    $manager->persist($department2);

    // Create the superior employee 1
    $superiorEmployee1 = new Employee();
    $superiorEmployee1->setName('John Doe');
    $superiorEmployee1->setDepartment($department1);
    $superiorEmployee1->setSalary(5000.00);
    $manager->persist($superiorEmployee1);


    // Create the superior employee 2
    $superiorEmployee2 = new Employee();
    $superiorEmployee2->setName('Jane Doe');
    $superiorEmployee2->setDepartment($department2);
    $superiorEmployee2->setSalary(9000.00);
    $manager->persist($superiorEmployee2);


    // Create employees for department1 
    $employee1 = new Employee();
    $employee1->setName('Jane Smith');
    $employee1->setDepartment($department1);
    $employee1->setSalary(6000.00);
    $employee1->setSuperior($superiorEmployee1); // Set superior
    $manager->persist($employee1);

    $employee2 = new Employee();
    $employee2->setName('Bob Johnson');
    $employee2->setDepartment($department1);
    $employee2->setSalary(4500.00);
    $employee2->setSuperior($superiorEmployee1); // Set superior
    $manager->persist($employee2);


    // Create employees for department2
    $employee3 = new Employee();
    $employee3->setName('Alex Johnson');
    $employee3->setDepartment($department2);
    $employee3->setSalary(8000.00);
    $employee3->setSuperior($superiorEmployee2); // Set superior
    $manager->persist($employee3);

    $employee4 = new Employee();
    $employee4->setName('Jack Smith');
    $employee4->setDepartment($department2);
    $employee4->setSalary(5500.00);
    $employee4->setSuperior($superiorEmployee2); // Set superior
    $manager->persist($employee4);

    $employee5 = new Employee();
    $employee5->setName('Time Jackson');
    $employee5->setDepartment($department2);
    $employee5->setSalary(3000.00);
    $employee5->setSuperior($employee2); // Set superior
    $manager->persist($employee5);

    $employee6 = new Employee();
    $employee6->setName('Dora Lia');
    $employee6->setDepartment($department2);
    $employee6->setSalary(7500.00);
    $employee6->setSuperior($employee5); // Set superior
    $manager->persist($employee6);

    // Flush entities
    $manager->flush();
    }
    
}
