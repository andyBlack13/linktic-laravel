<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
//use Storage;
use Illuminate\Support\Facades\Storage;

use OpenApi\Annotations as OA;

/**
* @OA\Info(
*             title="Linktic", 
*             version="1.0",
*             description="Documentación de API para empresas y empleados"
* )
*
* @OA\Server(url="http://localhost:8000")
*/

class CompanyController extends Controller
{
/**
 * Obtiene las empresas activas
 * @OA\Get (
 *     path="/api/companies",
 *     tags={"Empresas"},
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
        $companies = Company::where('status', true)->get();

        if ($request->wantsJson()) {
            return response()->json($companies);
        } else {
            return view('companies.index', compact('companies'));
        }
    }

    public function create()
    {
        return view('companies.create');
    }

/**
 * Crea una nueva empresa
 * 
 * @param  \App\Http\Requests\CompanyRequest  $request
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 * 
 * @OA\Post (
 *     path="/api/companies",
 *     tags={"Empresas"},
 *     security={{"X-CSRF-TOKEN": {}}},
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

    public function store(CompanyRequest $request)
    {
        // Obtener el token CSRF de la cookie
        $csrfToken = Cookie::get('XSRF-TOKEN');

        // Agregar el token CSRF como encabezado X-CSRF-TOKEN
        $request->headers->add(['X-CSRF-TOKEN' => $csrfToken]);

        $validatedData = $request->validated();
    
        $company = new Company();
        $company->name = $validatedData['name'];
        $company->email = $validatedData['email'];
        $company->website = $validatedData['website'];

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($validatedData['name']) . '-' . now()->format('Y-m-d-H-i-s') . '.' . $extension;
            $file->storeAs('public', $fileName);
            $company->logo = $fileName;
        }
        
        $company->save();

        $url = Storage::url($fileName);
        error_log($url);

        if ($request->wantsJson()) {
            return response()->json($company, 201);
        } else {
            return redirect()->route('companies.index');
        }
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($company);
        } else {
        }
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }
    
/**
 * Actualiza los datos de una empresa
 * 
 * @param  \App\Http\Requests\CompanyRequest  $request
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 * 
 * @OA\Put (
 *     path="/api/companies/{id}",
 *     tags={"Empresas"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la empresa",
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

    public function update(CompanyRequest $request, $id)
    {
        // Obtener el token CSRF de la cookie
        $csrfToken = Cookie::get('XSRF-TOKEN');

        // Agregar el token CSRF como encabezado X-CSRF-TOKEN
        $request->headers->add(['X-CSRF-TOKEN' => $csrfToken]);

        $company = Company::findOrFail($id);
        $validatedData = $request->validated();
        
        $company->name = $validatedData['name'];
        $company->email = $validatedData['email'];
        $company->website = $validatedData['website'];

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($validatedData['name']) . '-' . now()->format('Y-m-d-H-i-s') . '.' . $extension;
            $file->storeAs('public', $fileName);
            $company->logo = $fileName;

            $url = Storage::url($fileName);
            error_log($url);

        }
        
        $company->save();
    
        if ($request->wantsJson()) {
            return response()->json($company, 200);
        } else {
            return redirect()->route('companies.index');
        }
    }

/**
 * Elimina una empresa
 * 
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
 * 
 * @OA\Delete (
 *     path="/api/companies/{id}",
 *     tags={"Empresas"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la empresa",
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
            return redirect()->route('companies.index')->with('success', 'Empresa eliminada correctamente');
        }
    }

}
