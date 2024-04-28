<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\DepartmentService;


class DepartmentServiceTest extends TestCase
{
    public function testGetAll(): void
    {
        // Create a mock for the DepartmentService
        $departmentServiceMock = $this->getMockBuilder(DepartmentService::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Define the expected department data
        $expectedDepartments = [
            ['id' => 1, 'name' => 'IT'],
            ['id' => 2, 'name' => 'Sales'],
            ['id' => 2, 'name' => 'Accounting'],
        ];

        // Set up the mock behavior for the getAll() method
        $departmentServiceMock->expects($this->once())
            ->method('getAll')
            ->willReturn($expectedDepartments);

        // Call the getAll() method and check the returned value
        $departments = $departmentServiceMock->getAll();

        // Assert that the returned value matches the expected department data
        $this->assertEquals($expectedDepartments, $departments);
    }
}
