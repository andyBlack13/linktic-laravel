<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Rol;
use App\Http\Requests\EmployeeRequest;
use App\Models\RolCompany;
use Database\Seeders\CompaniesSeeder;

class EmployeeController extends Controller
{
/**
 * Título que define lo que hará esta URI
 * @OA\Get (
 *     path="/api/employees",
 *     tags={"Empleados"},
 *     @OA\Response(
 *         response=200,
 *         description="Obtiene los empleados activos",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 type="array",
 *                 property="rows",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="id",
 *                         type="number",
 *                         example="1"
 *                     ),
 *                     @OA\Property(
 *                         property="name",
 *                         type="string",
 *                         example="Aderson Felix"
 *                     ),
 *                     @OA\Property(
 *                         property="email",
 *                         type="string",
 *                         example="Jara Lazaro"
 *                     ),
 *                     @OA\Property(
 *                         property="logo",
 *                         type="string",
 *                         example="Jara Lazaro"
 *                     ),
 *                     @OA\Property(
 *                         property="website",
 *                         type="string",
 *                         example="Jara Lazaro"
 *                     ),
 *                     @OA\Property(
 *                         property="created_at",
 *                         type="string",
 *                         example="2023-02-23T00:09:16.000000Z"
 *                     ),
 *                     @OA\Property(
 *                         property="updated_at",
 *                         type="string",
 *                         example="2023-02-23T12:33:45.000000Z"
 *                     )
 *                 )
 *             )
 *         )
 *     )
 * )
 */
    public function index(Request $request) {
        $employees = Employee::where('status', true)->get();

        if ($request->wantsJson()) {
            return response()->json($employees);
        } else {
            return view('employees.index', compact('employees'));
        }
    }

    public function create()
    {
        $companies = Company::where('status', true)->get();
        $roles_company = RolCompany::where('status', true)->get();
        return view('employees.create', compact('companies', 'roles_company'));
    }
    

    public function store(EmployeeRequest $request)
    {
        $validatedData = $request->validated();
        
        $employee = Employee::create($validatedData);
    
        if ($request->wantsJson()) {
            return response()->json($employee, 201);
        } else {
            return redirect()->route('employees.index');
        }
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($employee);
        } else {
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::where('status', true)->get();
        $roles_company = RolCompany::where('status', true)->get();
        return view('employees.edit', compact('employee', 'companies', 'roles_company'));
    }


    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->validated());
    
        if ($request->wantsJson()) {
            return response()->json($employee, 200);
        } else {
            return redirect()->route('employees.index');
        }
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['status' => false]);

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        } else {
            return redirect()->route('employees.index')->with('success', 'Empleado eliminado correctamente');
        }
    }
}
