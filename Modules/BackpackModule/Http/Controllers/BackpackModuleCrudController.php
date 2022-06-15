<?php

namespace Modules\BackpackModule\Http\Controllers;

use Nwidart\Modules\Facades\Module;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Modules\BackpackModule\Http\Requests\BackpackModuleRequest;
use File;
/**
 * Class BackpackModuleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BackpackModuleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        $this->crud->setModel(\Modules\BackpackModule\Entities\BackpackModule::class);
        $this->crud->setRoute('/backpack-module');
        $this->crud->setEntityNameStrings('backpack module', 'backpack modules');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $this->crud->addColumn(['name' => 'model', 'type' => 'text']);
        $this->crud->addColumn(['name' => 'module', 'type' => 'text']);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - $this->crud->column('price')->type('number');
         * - $this->crud->addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(BackpackModuleRequest::class);

        $path = app_path() . "/Models";
        $list_file = $this->getModels($path);

        $list_module = [];
        foreach(Module::all() as $key => $value) {
            $list_module[$key] = $key;
        }

        $this->crud->addField([   // select2_from_array
            'name'        => 'model',
            'label'       => "Model",
            'type'        => 'select2_from_array',
            'options'     => $list_file,
            'allows_null' => false,
            // 'default'     => 'one',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        $this->crud->addField([   // select2_from_array
            'name'        => 'module',
            'label'       => "Module",
            'type'        => 'select2_from_array',
            'options'     => $list_module,
            'allows_null' => false,
            // 'default'     => 'one',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - $this->crud->field('price')->type('number');
         * - $this->crud->addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store()
    {
        $t = $this->crud->getRequest()->model;
        $m = $this->crud->getRequest()->module;
        $this->moveFileByModule($t,$m);

        return $this->traitStore();
    }

    function getModels($path){
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..'){ continue; }
            $f = substr($result,0,-4);
            $out[$f]=$f;
        }
        return $out;
    }

    public function moveFileByModule($file, $MD)
    {
        $DS = DIRECTORY_SEPARATOR;

        $path = [
            [
                app_path().$DS."Models".$DS.$file.'.php',
                Module::getPath().$DS.$MD.$DS."Entities".$DS.$file.'.php',
                [
                    ['App\Models',"Modules\\".$MD."\Entities"]
                ]
            ],
            [
                app_path().$DS."Http".$DS."Controllers".$DS."Admin".$DS.$file.'CrudController.php',
                Module::getPath().$DS.$MD.$DS."Http".$DS."Controllers".$DS.$file.'CrudController.php',
                [
                    ['App\Http\Controllers\Admin',"Modules\\".$MD."\Http\Controllers"],
                    ['App\Models',"Modules\\".$MD."\Entities"],
                    ['App\Http\Requests',"Modules\\".$MD."\Http\Requests"]
                ]
            ],
            [
                app_path().$DS."Http".$DS."Requests".$DS.$file.'Request.php',
                Module::getPath().$DS.$MD.$DS."Http".$DS."Requests".$DS.$file.'Request.php',
                [
                    ['namespace App\Http\Requests;',"namespace Modules\\".$MD."\Http\Requests;"]
                ]
            ]
        ];

        foreach($path as $k => $v) {
            try {
                error_log($v[0]);
                error_log($v[1]);
                File::move($v[0], $v[1]);

                foreach ($v[2] as $key => $value) {
                    $this->replaceFileContent($v[1],$value[0],$value[1]);
                }
            } catch (\Throwable $th) {}
        }

        $ov = "Route::crud('".strtolower($file)."', '".$file."CrudController')";
        $nv = "// ".$ov;
        $bp_route_path = base_path().$DS.'routes'.$DS.'backpack'.$DS.'custom.php';
        $this->replaceFileContent($bp_route_path,$ov,$nv);

        $ov = "\nRoute::crud('".strtolower($file)."', '".$file."CrudController');";
        $bpm_route_path = Module::getPath().$DS.$MD.$DS.'Routes'.$DS.'web.php';
        $this->appendNewLineFileContent($bpm_route_path,$ov);

    }

    public function replaceFileContent($file, $old_str, $new_str)
    {
        //read the entire string
        $str=file_get_contents($file);

        //replace something in the file string - this is a VERY simple example
        $str=str_replace($old_str, $new_str,$str);

        //write the entire string
        file_put_contents($file, $str);
    }

    public function appendNewLineFileContent($file, $str)
    {
        //read the entire string
        $file_str=file_get_contents($file);

        //replace something in the file string - this is a VERY simple example
        $file_str=$file_str.$str;

        //write the entire string
        file_put_contents($file, $file_str);
    }
}
