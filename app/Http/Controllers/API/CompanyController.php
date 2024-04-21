<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Str;
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
 *     description="Se ha agregado un campo más sólo para validar que es API y pueda responder con un JSON y no con la vista para blade, esto no se hace normalmente pero lo agregue para que ustedes pudieran testear ya sea desde la API de Swagger o desde la interfaz de usuario. Para testear solo ve cambiando los emails en cada prueba y carga una imagen.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos de la empresa incluyendo el logo",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Nombre de la empresa"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     example="empresa123456@example123456.com"
 *                 ),
 *                 @OA\Property(
 *                     property="logo",
 *                     type="string",
 *                     format="binary",
 *                     description="Logo de la empresa (archivo)"
 *                 ),
 *                 @OA\Property(
 *                     property="website",
 *                     type="string",
 *                     example="https://www.empresa.com"
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
 *                 )
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
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error, Email Duplicated, Try with other email"
 *     )
 * )
 */

    public function store(CompanyRequest $request)
    {
        

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

            $url = Storage::url($fileName);
            error_log($url);
        }
        
        $company->save();

        // Verifica si la solicitud proviene de la API si no retorna una vista
        if ($request->has('X-Requested-By') && $request->input('X-Requested-By') === 'API') {
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
 *     description="Se ha agregado un campo más sólo para validar que es API y pueda responder con un JSON y no con la vista para blade, esto no se hace normalmente pero lo agregue para que ustedes pudieran testear ya sea desde la API de Swagger o desde la interfaz de usuario. Para testear solo ve cambiando los emails en cada prueba y carga una imagen. Puedes ejecutar el endpoint para traer todas las empresas y tomar el id del registro para introducirlo.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos de la empresa incluyendo el logo",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Nombre de la empresa"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     example="empresa123456@example123456.com"
 *                 ),
 *                 @OA\Property(
 *                     property="logo",
 *                     type="string",
 *                     format="binary",
 *                     description="Logo de la empresa (archivo)"
 *                 ),
 *                 @OA\Property(
 *                     property="website",
 *                     type="string",
 *                     example="https://www.empresa.com"
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
 *                 )
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
 *     )
 * )
 */

    public function update(CompanyRequest $request, $id)
    {
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
    
        // Verifica si la solicitud proviene de la API si no retorna una vista
        if ($request->has('X-Requested-By') && $request->input('X-Requested-By') === 'API') {
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
 * @OA\Post (
 *     path="/api/companies/{id}/delete",
 *     tags={"Empresas"},
 *     description="Se ha agregado un campo más sólo para validar que es API y pueda responder con un JSON. Ademas se utilizó el metodo POST porque solo inactivamos el registro. Coloca solo un ID existente de alguna empresa y ejecuta.",
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
 *         description="Empresa eliminada correctamente"
 *     )
 * )
 */

    public function destroy($id, Request $request)
    {
        $company = Company::findOrFail($id);
        $company->update(['status' => false]);

        // Verifica si la solicitud proviene de la API si no retorna una vista
        if ($request->has('X-Requested-By') && $request->input('X-Requested-By') === 'API') {
            return response()->json($company, 200);
        } else {
            return redirect()->route('companies.index')->with('success', 'Empresa eliminada correctamente');
        }
    }

}
