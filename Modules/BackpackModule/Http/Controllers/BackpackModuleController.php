<?php

namespace Modules\BackpackModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use File;

class BackpackModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        
        $path = app_path() . "/Models";
        $list_file = $this->getModels($path);

        $list_module = [];
        
        foreach(Module::all() as $key => $value) {
            $list_module[] = $key;
        }  

        $this->moveFileByModule('BackpackModule', 'BackpackModule');

        return view('backpackmodule::index',[
            'list_file'=>$list_file,
            'list_module'=>$list_module
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('backpackmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('backpackmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('backpackmodule::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    
    function getModels($path){ 
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $out[]=substr($result,0,-4);
        }
        return $out;
    }

    public function moveFileByModule($file, $MD)
    {
        $DS = DIRECTORY_SEPARATOR;
        
        $path = [
            [app_path().$DS."Models".$DS.$file.'php', Module::getPath().$DS.$MD.$DS."Entities".$DS.$file.'php'],
            [app_path().$DS."Http".$DS."Controllers".$DS."Admin".$DS.$file.'CrudController.php', Module::getPath().$DS.$MD.$DS."Http".$DS."Controllers".$DS.$file.'CrudController.php'],
            [app_path().$DS."Http".$DS."Requests".$DS.$file.'Request.php', Module::getPath().$DS.$MD.$DS."Http".$DS."Requests".$DS.$file.'Request.php']
        ];

        foreach($path as $k => $v) {
            try {
                File::move($v[0], $v[1]);  

            } catch (\Throwable $th) {} 
        }
    }
}
