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
 * Obtiene los registros de empleados activos
 * @OA\Get (
 *     path="/api/employees",
 *     tags={"Empleados"},
 *     @OA\Response(
 *         response=200,
 *         description="Obtiene las empresas activas",
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
 *                         example="Company 1"
 *                     ),
 *                     @OA\Property(
 *                         property="email",
 *                         type="string",
 *                         example="company1@example.com"
 *                     ),
 *                     @OA\Property(
 *                         property="logo",
 *                         type="string",
 *                         example="company1_logo.png"
 *                     ),
 *                     @OA\Property(
 *                         property="website",
 *                         type="string",
 *                         example="https://www.company1.com"
 *                     ),
 *                     @OA\Property(
 *                         property="sttaus",
 *                         type="boolean",
 *                         example="true"
 *                     ),
 *                     @OA\Property(
 *                          property="created_at",
 *                          type="string",
 *                          format="date-time",
 *                          example="2024-04-20T17:30:22"
 *                     ),
 *                     @OA\Property(
 *                          property="updated_at",
 *                          type="string",
 *                          format="date-time",
 *                          example="2023-02-23 12:33:45"
 * )
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

// security={{"X-CSRF-TOKEN": {}}},
    
/**
 * Crea un nuevo empleado
 * 
 * @param  \App\Http\Requests\CompanyRequest  $request
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 * 
 * @OA\Post (
 *     path="/api/employees",
 *     tags={"Empleados"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 example="Nombre de la empresa"
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email",
 *                 example="empresa@example.com"
 *             ),
 *             @OA\Property(
 *                 property="logo",
 *                 type="string",
 *                 format="binary",
 *                 description="Logo de la empresa (archivo)"
 *             ),
 *             @OA\Property(
 *                 property="website",
 *                 type="string",
 *                 example="https://www.empresa.com"
 *             ),
 *             @OA\Property(
 *                  property="status",
 *                  type="boolean",
 *                  example="true"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empresa creada exitosamente"
 *     ),
 *     @OA\Response(
 *         response=419,
 *         description="Token CSRF mismatch"
 *     )
 * )
 */

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

    /**
 * Actualiza los datos de una empresa
 * 
 * @param  \App\Http\Requests\CompanyRequest  $request
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 * 
 * @OA\Put (
 *     path="/api/employees/{id}",
 *     tags={"Empleados"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del empleado",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 example="Nuevo nombre de la empresa"
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email",
 *                 example="nuevoemail@empresa.com"
 *             ),
 *             @OA\Property(
 *                 property="website",
 *                 type="string",
 *                 example="https://www.nuevaempresa.com"
 *             ),
 *             @OA\Property(
 *                 property="logo",
 *                 type="string",
 *                 format="binary",
 *                 description="Nuevo logo de la empresa (archivo)"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empresa actualizada correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="id",
 *                 type="number",
 *                 example="1"
 *             ),
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 example="Nuevo nombre de la empresa"
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email",
 *                 example="nuevoemail@empresa.com"
 *             ),
 *             @OA\Property(
 *                 property="logo",
 *                 type="string",
 *                 example="nuevo-nombre-de-la-empresa-2024-04-20-23-31-05.png"
 *             ),
 *             @OA\Property(
 *                 property="website",
 *                 type="string",
 *                 example="https://www.nuevaempresa.com"
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="boolean",
 *                 example="true"
 *             ),
 *             @OA\Property(
 *                 property="created_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2024-04-20T23:31:05"
 *             ),
 *             @OA\Property(
 *                 property="updated_at",
 *                 type="string",
 *                 format="date-time",
 *                 example="2024-04-21T00:45:15"
 *             )
 *         )
 *     )
 * )
 */

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

/**
 * Elimina una empresa
 * 
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 * 
 * @OA\Delete (
 *     path="/api/employees/{id}",
 *     tags={"Empleados"},
 *     description="No elimina el registro solo cambia de activo a inactivo, esto para no perder información, desde el Front-end se puede manejar este estado para mostrar o no mostrar los registros",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del empleado",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Empresa eliminada correctamente"
 *     )
 * )
 */

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
