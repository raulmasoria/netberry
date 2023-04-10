@extends('layouts.plantilla')

@section('contenido')   
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl">
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Gestor de tareas</p>
            </div>
            <hr class="mt-5 mb-5">
            <div class="mx-auto max-w-2xl mt-1 flex" id="form">                
                <input type="text" class="block w-full border-gray-500 border-2 shadow-sm mr-2 p-2" placeholder="Nueva tarea..." name="name_category" id="name_category">
                @foreach ($categories as $id_categorie => $categorie)
                    <input type="checkbox" name="categorie" id="{{$categorie['name']}}" value="{{$categorie['name']}}" class="mt-2 ml-2 border-gray-500 border-2 w-5 h-5"> 
                    <label class="m-2" for="{{$categorie["name"]}}">{{$categorie["name"]}}</label>
                @endforeach
                @csrf
                <button class="button bg-gray-300 border-2 border-gray-500 p-2 ml-5 inline-flex" id="anadir">Añadir</button>
            </div>
            <div class="mx-auto max-w-2xl mt-3">
                <table class="w-full table-auto text-sm text-left data-table" id="tableTask">
                    <thead class="bg-gray-300 font-medium">
                        <tr>
                            <th class="text-base font-bold text-gray-900 border-2 border-gray-500">Tarea</th>
                            <th class="text-base font-bold text-gray-900 border-2 border-gray-500">Categoria</th>
                            <th class="text-base font-bold text-gray-900 border-2 border-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y">
                        @foreach ($tasks as $task)                        
                            <tr>
                                <td class="text-base p-2">{{$task->name}}</td>
                                <td class="text-base" style="text-align: center">
                                    @foreach ($categorieTasks as $categorieTask)
                                        @if ($categorieTask->task_id == $task->id)                                           
                                            <label class="m-2 px-6 bg-gray-300 border-2 border-gray-500">{{$categories[$categorieTask->category_id]['name']}}</label>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-base" style="text-align: center">
                                    <button id="{{$task->id}}" class="mx-auto deleteTask">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>   
            </div>
        </div>
    </div>
    
    <script type="module">       

        $("#anadir").click(function (e) {
            e.preventDefault();
            var name_category = $('#name_category').val();
            var php = $('input[id="PHP"]:checked').val();
            var css = $('input[id="CSS"]:checked').val();
            var javascript = $('input[id="Javascript"]:checked').val();                      
            var token = '{{csrf_token()}}';
           
            var data={name_category:name_category,php:php,css:css,javascript:javascript,_token:token};

            $.ajax({
                type: "post",
                url: "{{route('anadir-tarea')}}",
                data: data,
                success: function (msg) {
                    $('#tableTask').load(document.URL +  ' #tableTask');
                    $('#name_category').val("");
                    $("#PHP").prop('checked', false);
                    $("#CSS").prop('checked', false);
                    $("#Javascript").prop('checked', false);
                }
            });
            
        });

        $(document).on('click', '.deleteTask', function(e){	            
            e.preventDefault();
            var id = $(this).attr('id');
            var token = '{{csrf_token()}}';

            var data = {id:id,_token:token};

            $.ajax({
                type: "delete",
                url: "{{route('eliminar-tarea')}}",
                data: data,
                success: function (msg) {
                    $('#tableTask').load(document.URL +  ' #tableTask');
                }
            });

        });

    </script>
@endsection    
  