<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Course;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'code' => 'CTEAS',
                'name' => 'CTEAS',
                'full_name' => 'College of Teacher Education Arts and Sciences',
                'courses' => ['Education', 'Psychology'],
            ],
            [
                'code' => 'CCLS',
                'name' => 'CCLS',
                'full_name' => 'College of Computing and Library Studies',
                'courses' => ['Information System', 'Library Information System'],
            ],
            [
                'code' => 'CBTM',
                'name' => 'CBTM',
                'full_name' => 'College of Business and Tourism Management',
                'courses' => ['Tourism', 'Entrepreneur'],
            ],
            [
                'code' => 'CME',
                'name' => 'CME',
                'full_name' => 'College of Maritime Education',
                'courses' => ['Transportation', 'Engineering'],
            ],
            [
                'code' => 'CCJE',
                'name' => 'CCJE',
                'full_name' => 'College of Criminal Justice Education',
                'courses' => [],
            ],
            [
                'code' => 'BSED',
                'name' => 'Basic Education',
                'full_name' => 'Basic Education',
                'courses' => ['Senior High School', 'Junior High School'],
            ],
        ];

        foreach ($departments as $deptData) {
            $courses = $deptData['courses'];
            unset($deptData['courses']);

            $department = Department::create($deptData);

            foreach ($courses as $courseName) {
                Course::create([
                    'department_id' => $department->id,
                    'name' => $courseName,
                ]);
            }
        }
    }
}
