<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\EmploymentStatus;
use App\Models\DivSecUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::with(['position', 'employmentStatus', 'divSecUnit'])->paginate(10);
            $positions = Position::all();
            $employmentStatuses = EmploymentStatus::all();
            $divSecUnits = DivSecUnit::all();
            
            // Debug: Check if employees exist
            if ($employees->isEmpty()) {
                \Log::info('No employees found in database');
            }
            
            return view('employees.index', compact('employees', 'positions', 'employmentStatuses', 'divSecUnits'));
        } catch (\Exception $e) {
            \Log::error('Error in EmployeeController@index: ' . $e->getMessage());
            return view('employees.index', [
                'employees' => collect([]),
                'positions' => Position::all(),
                'employmentStatuses' => EmploymentStatus::all(),
                'divSecUnits' => DivSecUnit::all()
            ]);
        }
    }

    public function create()
    {
        $positions = Position::all();
        $employmentStatuses = EmploymentStatus::all();
        $divSecUnits = DivSecUnit::all();
        return view('employees.create', compact('positions', 'employmentStatuses', 'divSecUnits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users|min:3|max:50',
            'password' => 'required|min:8|confirmed',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'suffix' => 'nullable|string|max:10',
            'age' => 'required|integer|min:18',
            'gender' => 'required|in:male,female,other',
            'contact_num' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'birthdate' => 'required|date|before:today',
            'date_hired' => 'required|date|after:birthdate',
            'position_id' => 'required|exists:positions,id',
            'employment_status_id' => 'required|exists:employment_statuses,id',
            'div_sec_unit_id' => 'required|exists:div_sec_units,id',
        ]);

        // Create user account first
        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        // Create employee and associate with user
        $employee = Employee::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'middle_name' => $validated['middle_name'],
            'suffix' => $validated['suffix'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'contact_num' => $validated['contact_num'],
            'address' => $validated['address'],
            'birthdate' => $validated['birthdate'],
            'date_hired' => $validated['date_hired'],
            'position_id' => $validated['position_id'],
            'employment_status_id' => $validated['employment_status_id'],
            'div_sec_unit_id' => $validated['div_sec_unit_id'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee and user account created successfully');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        $employmentStatuses = EmploymentStatus::all();
        $divSecUnits = DivSecUnit::all();
        return view('employees.edit', compact('employee', 'positions', 'employmentStatuses', 'divSecUnits'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:18',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:255',
            'contact_num' => 'required|string|max:20',
            'birthdate' => 'required|date|before:today',
            'date_hired' => 'required|date|before:today',
            'position_id' => 'required|exists:positions,id',
            'employment_status_id' => 'required|exists:employment_statuses,id',
            'div_sec_unit_id' => 'required|exists:div_sec_units,id',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        // Delete associated user account if it exists
        if ($employee->user) {
            $employee->user->delete();
        }

        // Delete employee record
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee and user account deleted successfully');
    }
}
