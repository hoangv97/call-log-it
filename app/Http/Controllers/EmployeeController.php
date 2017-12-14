<?php

namespace App\Http\Controllers;

use App\Facade\Constant;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Ticket;
use function foo\func;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    /*
     * return members of a team
     */
    public function searchAssignee(Request $request) {
        //Kiem tra quyen cua nguoi tim kiem: can co quyen team hoac quyen cong ty
        if(! Auth::user()->hasPermissions(Constant::PERMISSIONS_TEAM_COMPANY))
            return null;
        $q = $request->q; //query name
        $team = Team::findOrFail($request->t);

        $result = [];
        $members = $team->members();
        foreach ($members as $member) {
            if(!isset($q) || strpos(strtolower($member->name), strtolower($q)) !== false) {
                $result[] = $this->getEmployeeInfo($member);
            }
        }
        return response()->json([
            'total_count' => count($result),
            'employees' => $result
        ]);
    }

    /*
     * Tra ve tat ca nhan vien trong cong ty
     * Tim kiem nguoi lien quan cho 1 cong viec
     */
    public function searchAllEmployees(Request $request)
    {
        $q = $request->q;
        if(!isset($q)) {
            abort(404);
        }
        $employees = Employee::where('name', 'like', "%$q%")/*->where('id', '<>', Auth::id())*/->get(['id', 'name', 'email', 'avatar_url']);
        return response()->json([
            'total_count' => count($employees),
            'employees' => $employees->map(function ($employee) {
                return $this->getEmployeeInfo($employee);
            })
        ]);
    }

    /*
     * Return info fields of an employee for searching
     */
    protected function getEmployeeInfo(Employee $employee) {
        return [
            'id' => $employee->id,
            'name' => $employee->name,
            'text' => $employee->name,
            'email' => $employee->email,
            'avatar_url' => route('home')."/".(is_null($employee->avatar_url) ? Constant::DEFAULT_AVATAR_URL : $employee->avatar_url)
        ];
    }

}
