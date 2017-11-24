<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    /*
     * return members of a team
     */
    public function searchAssignee(Request $request) {
        $employee = Auth::user();
        //Kiem tra quyen cua nguoi tim kiem: can co quyen team hoac quyen cong ty
        if(! $employee->hasPermissions([2, 3, 4, 5]))
            return null;

        $q = $request->q; //query name
        $t = $request->t; //ticket id
        if(!isset($q) || !isset($t)) {
            abort(404);
        }

        $members = Ticket::findOrFail($t)->team->members();
        $result = [];
        foreach ($members as $member) {
            if(strpos($member->name, $q)) {
                $result[] = [
                    'name' => $member->name
                ];
            }
        }
        return $result;
    }

    /*
     * Tim kiem tat ca nhan vien trong cong ty
     * Tim kiem nguoi lien quan cho 1 cong viec
     */
    public function searchAllEmployees(Request $request)
    {
        $q = $request->q;
        if(!isset($q)) {
            abort(404);
        }
        $employees = Employee::where('name', 'like', "%$q%")->get(['name']);
        $result = collect($employees)->map(function ($employee) {
            return [
                'name' => $employee->name
            ];
        })->all();
        return response()->json($result);
    }

}
