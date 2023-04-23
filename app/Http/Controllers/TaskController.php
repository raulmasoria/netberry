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
        
        $tasks = DB::table('tasks as t')
            ->join('category_tasks as ct', 't.id', '=', 'ct.task_id')
            ->join('categories as c', 'ct.category_id', '=', 'c.id')
            ->select('t.id as task_id','c.id as categorie_id', 't.name as task_name', 'c.name as categorie_name')
            ->get();

        $arrayTasks = array();
        foreach($tasks as $task)
        {
            if(!empty($arrayTasks[$task->task_id])){
                array_push($arrayTasks[$task->task_id]['categories'], $task->categorie_name);
            } else {
                $arrayTasks[$task->task_id] = array("name" => $task->task_name, "categories" => array($task->categorie_name));
            }
            
        }    

        $categories = Category::all();
        
        $arrayCategories = array();
        foreach($categories as $categorie)
        {
            $arrayCategories[$categorie->id] = array("name" => $categorie->name);
        }

        return view('gestor-tareas',[
            'categories' => $arrayCategories,
            'tasks' => $arrayTasks
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
