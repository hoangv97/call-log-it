<?php

namespace App\Http\Controllers;

use App\Facade\Constant;
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
        if(! $employee->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY))
            return null;

        $q = $request->q; //query name
        if(!isset($q)) {
            abort(404);
        }

        $members = $employee->team->members();
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
        $employees = Employee::where('name', 'like', "%$q%")->where('id', '<>', Auth::id())->get(['name']);
        return response()->json($employees);
    }

}
