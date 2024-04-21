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
 *         description="Obtiene empleados activos",
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
 *                         property="first_name",
 *                         type="string",
 *                         example="Andrea"
 *                     ),
 *                     @OA\Property(
 *                         property="last_name",
 *                         type="string",
 *                         example="Camargo"
 *                     ),
 *                     @OA\Property(
 *                         property="email",
 *                         type="string",
 *                         example="andyy.1234@gmail.com"
 *                     ),
 *                     @OA\Property(
 *                         property="phone_number",
 *                         type="string",
 *                         example="+571234567890"
 *                     ),
 *                     @OA\Property(
 *                         property="company_id",
 *                         type="number",
 *                         example="2"
 *                     ),
 *                     @OA\Property(
 *                         property="rol_company_id",
 *                         type="number",
 *                         example="5"
 *                     ),
 *                     @OA\Property(
 *                         property="status",
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
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error"
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
    
/**
 * Crea un nuevo empleado
 * 
 * @param  \App\Http\Requests\CompanyRequest  $request
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 * 
 * @OA\Post (
 *     path="/api/employees",
 *     tags={"Empleados"},
 *     description="",
 *     @OA\RequestBody(
 *         required=true,
 *         description="",
 *         @OA\JsonContent(
 *                 @OA\Property(
 *                     property="first_name",
 *                     type="string",
 *                     example="Maria"
 *                 ),
 *                 @OA\Property(
 *                     property="last_name",
 *                     type="string",
 *                     example="López"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     example="maria.1234566@example.com"
 *                 ),
 *                 @OA\Property(
 *                     property="phone_number",
 *                     type="string",
 *                     example="+371234567890"
 *                 ),
 *                 @OA\Property(
 *                     property="company_id",
 *                     type="number",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="rol_company_id",
 *                     type="number",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="status",
 *                     type="boolean",
 *                     example=true
 *                 ),
 *                 @OA\Property(
 *                     property="X-Requested-By",
 *                     type="string",
 *                     example="API",
 *                     description="Encabezado para identificar que la solicitud proviene de la API"
 *                 ),
 *        )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empleado creado exitosamente"
 *     ),
 *     @OA\Response(
 *         response=419,
 *         description="Token CSRF mismatch"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error, Email Duplicated, Try with other email"
 *     ),
 * )
 */

    public function store(EmployeeRequest $request)
    {
        $validatedData = $request->validated();
        
        $employee = Employee::create($validatedData);
    
        // Verifica si la solicitud proviene de la API si no retorna una vista
        if ($request->has('X-Requested-By') && $request->input('X-Requested-By') === 'API') {
            return response()->json($employee, 200);
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
 * Actualiza los datos de una empleado
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
 *                 property="first_name",
 *                 type="string",
 *                 example="Pedro"
 *             ),
 *             @OA\Property(
 *                 property="last_name",
 *                 type="string",
 *                 example="Rojas"
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email",
 *                 example="pedro123@empleado.com"
 *             ),
 *             @OA\Property(
 *                 property="phone_number",
 *                 type="string",
 *                 example="+571234567890"
 *             ),
 *             @OA\Property(
 *                 property="company_id",
 *                 type="number",
 *                 example="2"
 *             ),
 *             @OA\Property(
 *                 property="rol_company_id",
 *                 type="string",
 *                 example="3"
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="boolean",
 *                 example="true"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empleado actualizado correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="first_name",
 *                 type="string",
 *                 example="Pedro"
 *             ),
 *             @OA\Property(
 *                 property="last_name",
 *                 type="string",
 *                 example="Rojas"
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email",
 *                 example="pedro123@empleado.com"
 *             ),
 *             @OA\Property(
 *                 property="phone_number",
 *                 type="string",
 *                 example="+571234567890"
 *             ),
 *             @OA\Property(
 *                 property="company_id",
 *                 type="number",
 *                 example="2"
 *             ),
 *             @OA\Property(
 *                 property="rol_company_id",
 *                 type="string",
 *                 example="3"
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
 * Elimina un empleado
 * 
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 * 
 * @OA\Post (
 *     path="/api/employees/{id}/delete",
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
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *            @OA\Property(
 *                property="X-Requested-By",
 *                type="string",
 *                example="API",
 *                description="Encabezado para identificar que la solicitud proviene de la API"
 *            )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Empleado eliminado correctamente"
 *     )
 * )
 */

    public function destroy($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->update(['status' => false]);

        // Verifica si la solicitud proviene de la API si no retorna una vista
        if ($request->has('X-Requested-By') && $request->input('X-Requested-By') === 'API') {
            return response()->json($employee, 200);
        } else {
            return redirect()->route('employees.index')->with('success', 'Empleado eliminado correctamente');
        }
    }
}
