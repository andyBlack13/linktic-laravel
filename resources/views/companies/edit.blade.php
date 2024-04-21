<!-- resources/views/companies/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('companies.index') }}" class="inline-block border border-gray-700 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-700 hover:text-white">
                    <span class="mr-2">&lt;</span> Atrás
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ $company->name }}" class="form-input rounded-md shadow-sm mt-1 block w-full"/>
                        </div>
                        <br>
                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                            <input type="text" name="email" id="email" value="{{ $company->email }}" class="form-input rounded-md shadow-sm mt-1 block w-full"/>
                        </div>
                        <br>
                        <div>
                            <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Logo:</label>
                            <input type="file" name="logo" id="logo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @if ($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="mt-2 image-logo">
                            @endif

                        </div>
                        <br>
                        <div>
                            <label for="website" class="block font-medium text-sm text-gray-700">Sitio web</label>
                            <input type="text" name="website" id="website" value="{{ $company->website }}" class="form-input rounded-md shadow-sm mt-1 block w-full"/>
                        </div>
                        <br>
                        <div class="mb-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                                Actualizar Empresa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
