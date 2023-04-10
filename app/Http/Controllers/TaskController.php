<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Category_task;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        
        $tasks = Task::all();
        $categorieTask = Category_task::all();
        $categories = Category::all();

        $arrayCategories = array();
        foreach($categories as $categorie){
            $arrayCategories[$categorie['id']] = array("name" => $categorie->name);
        }

        return view('gestor-tareas',[
            'categories' => $arrayCategories,
            'tasks' => $tasks,
            'categorieTasks' => $categorieTask
        ]);
    }

    public function store(Request $request, Task $task)
    {

        $request->validate([
            'name_category' => ['string', 'max:255'],
        ]);

        $task->name = $request->name_category;        
        $task->save();

        if($request->php == 'PHP'){
            $category_task = new Category_task;
            $category_task->category_id = 1;
            $category_task->task_id = $task->id;
            $category_task->save();
        }

        if($request->css == 'CSS'){
            $category_task = new Category_task;
            $category_task->category_id = 2;
            $category_task->task_id = $task->id;
            $category_task->save();
        }

        if($request->javascript == 'Javascript'){
            $category_task = new Category_task;
            $category_task->category_id = 3;
            $category_task->task_id = $task->id;
            $category_task->save();
        }           
     
        return response()->json(['success' => 'created']);

    }

    public function destroy(Request $request, Task $task)
    {
        $task->id = $request->id;     

        Category_task::where('task_id',$task->id)->delete();

        Task::find($task->id)->delete($task->id);


        return response()->json(['success' => 'deleted']);
    }

    
}
