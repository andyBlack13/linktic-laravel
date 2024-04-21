
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Principal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <strong>¡Bienvenido!</strong> <br><br>
                        <ul>
                            <li>* Este es un ejemplo del funcionamiento de nuestra API para la administración de Empresas y Empleados.</li>
                            <li>* Puedes ingresar a la documentación de los endpoints en la ruta <strong>api/documentation</strong> y probarlos desde allí utilizando <strong>Try it out -> Execute</strong>. Dependiendo del método, es posible que necesites proporcionar un ID o datos adicionales.</li>
                            <li>* Para probar el almacenamiento de logotipos de las empresas, simplemente actualiza alguna de las empresas de prueba.</li>
                            <li>* Para una experiencia más interactiva, he creado vistas blade donde puedes visualizar los datos en una tabla y realizar pruebas directamente desde allí.</li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
