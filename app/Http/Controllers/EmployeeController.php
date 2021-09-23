<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::orderBy('id', 'DESC')->paginate('1');
        return view('employee.index', compact('employees'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::get();
        return view('employee.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|unique:employees,first_name,NULL,id,deleted_at,NULL',
            'last_name' => 'required|string|unique:employees,last_name,NULL,id,deleted_at,NULL',
            'email' => 'unique:employees,email,NULL,id,deleted_at,NULL',
            'phone' => 'unique:employees,phone,NULL,id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $formRequest = EmployeeService::formRequest($request);
        DB::beginTransaction();
        try {
            Employee::create($formRequest);
            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Successfully Generated');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', "something went wrong ");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = Company::get();
        return view('employee.edit', compact('companies', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => "required|string|unique:employees,first_name,$employee->id,id,deleted_at,NULL",
            'last_name' => "required|string|unique:employees,last_name,$employee->id,id,deleted_at,NULL",
            'email' => "unique:employees,email,NULL,id,deleted_at,$employee->id",
            'phone' => "unique:employees,phone,NULL,id,deleted_at,$employee->id",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $formRequest = EmployeeService::formRequest($request);
        DB::beginTransaction();
        try {
            $employee->update($formRequest);
            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Successfully Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', "something went wrong ");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    { DB::beginTransaction();
        try {
            $employee->delete();
            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Successfully Deleted');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', "something went wrong ");
        }
    }
}
