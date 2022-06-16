<?php

namespace Modules\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\Account;

class AccountDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * php artisan module:seed Account
     *
     * @return void
     */

    public function run() {
        $model = Account::class;

        $z1 = $this->createAccount($model, [
            ['id' => 1, 'name' => 'Zillion Trust Plc.']
        ]);

        $this->createAccount($model, [
            ['id' => 3, 'name' => 'Individual'],
            ['parent_id' => $z1->id]
        ]);
        if (env('DB_CONNECTION') === 'pgsql') {
            DB::statement("ALTER SEQUENCE accounts_id_seq RESTART WITH 1000;");
        } else {
            DB::statement("ALTER TABLE accounts AUTO_INCREMENT = 1000;");
        }
    }

    public function createAccount($model, $data) {
        return $model::firstOrCreate($data[0], isset($data[1]) ? $data[1] : []);
    }
}
