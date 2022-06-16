<?php

namespace Modules\Type\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Modules\Type\Database\Seeders\TypeDatabaseSeeder;

class OperationTypeSeederTableSeeder extends TypeDatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * php artisan module:seed --class=OperationTypeSeederTableSeeder type --force
     *
     * @return void
     */
    public function run() {

        DB::statement("ALTER SEQUENCE roles_id_seq RESTART WITH 1000;");

        $arrParents = [
            36 => [
                "name" => "Operation",
                "code" => 'Operation',
                "auto_code" => true,
            ]
        ];
        $this->checkIfHaveParentAndCreate($arrParents);
        $arrTemplateType = [

            [
                'name' => 'Transfer',
                'code' => 'transfer',
                'auto_code' => true,
            ],
            [
                'name' => 'Cashout',
                'code' => 'cashout',
                'auto_code' => true,
            ],
            [
                'name' => 'Receive',
                'code' => 'receive',
                'auto_code' => true,
            ],
            [
                'name' => 'Loyalty to salary',
                'code' => 'loyalty_to_salary',
                'auto_code' => true,
            ],
            [
                'name' => 'Salary to loyalty',
                'code' => 'salary_to_loyalty',
                'auto_code' => true,
            ]
        ];
        $this->runLooping(36, $arrTemplateType, 'option');
    }
}
