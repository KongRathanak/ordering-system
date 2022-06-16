<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
			$table->id();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->string('address')->nullable();
			$table->boolean('status')->default(1);
			$table->string('position')->nullable();
            $table->bigInteger('merchant_id')->unsigned()->nullable();
			$table->text('account_id')->nullable();
			$table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
			$table->bigInteger('updated_by')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
