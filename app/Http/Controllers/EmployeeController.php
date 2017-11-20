<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function searchEmployeesByName(Request $request)
    {
        $q = $request->input('q');
        if(!isset($q)) {
            abort(404);
        }
        $employees = Employee::where('name', 'like', "%$q%")->get(['id', 'name', 'email']);
        $results = collect($employees)->map(function ($employee) {
            return [
                'id' => $employee->id,
                'name_email' => "$employee->name ($employee->email)"
            ];
        })->all();
        return response()->json($results);
    }

}
