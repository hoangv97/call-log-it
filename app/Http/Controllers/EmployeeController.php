<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    //todo search employees api
    public function searchEmployeesByName(Request $request)
    {
        $q = $request->input('q');
        if(!isset($q)) {
            abort(404);
        }
        $employees = json_decode(file_get_contents(public_path('test/employees.json')));
        $results = [];
        foreach ($employees as $employee) {
            if(strpos($employee->name, $q)) {
                $results[] = $employee;
            }
        }
        return $results;
    }

}
