@extends('includes.body')
@section('title', 'Meus Interesses')
@section('content')

<div class=" p-6 mb-6">
    <h1 class="text-2xl font-bold mb-2" style="font-weight: bold; margin-bottom: 8px;">Partikhe conosco seus interesses!</h1>
    <h6>Selecione seus interesses abaixo para obter recomendações mais personalizadas</h6>
  </div>

<div class="max-w-7xl mx-auto py-8 px-4 mb-4" id="interest-List" style="border-bottom: 1px solid grey;">
    <!-- Título -->
    <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Música</h1>
    
    <!-- Lista -->
    <ul class="flex gap-4">
      <li>
        <a href="#" style="border-color: gray; border: 1px solid gray; font-size:12px;" class="px-4 py-2 bg-gray-100 rounded-full text-gray-800 font-bold hover:bg-gray-200 transition">
          Todos
        </a>
      </li>
      <li>
        <a href="#" style="border-color: gray; border: 1px solid gray; font-size:12px;" class="px-4 py-2 bg-gray-100 rounded-full text-gray-800 font-bold hover:bg-gray-200 transition">
        Hoje
        </a>
      </li>
      <li>
       
        <a href="#" style="border-color: gray; border: 1px solid gray; font-size:12px;" class="px-4 py-2 bg-gray-100 rounded-full text-gray-800 font-bold hover:bg-gray-200 transition">
             Amanhã
        </a>
      </li>
      <li>
        <a href="#" style="border-color: gray; border: 1px solid gray; font-size:12px;" class="px-4 py-2 bg-gray-100 rounded-full text-gray-800 font-bold hover:bg-gray-200 transition">
        Esta Semana
        </a>
      </li>
      <li>
        <a href="#" style="border-color: gray; border: 1px solid gray; font-size:12px;" class="px-4 py-2 bg-gray-100 rounded-full text-gray-800 font-bold hover:bg-gray-200 transition">
        Livre
        </a>
      </li>
    </ul>
  </div>
  
 

@endsection
