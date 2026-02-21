<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(config('user-devices.db_table_name', 'devices'), function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('deviceable_type');
            $table->unsignedBigInteger('deviceable_id');
            $table->enum('type', ['mobile', 'web', 'desktop'])->default('mobile');
            $table->string('token')->unique();
            $table->string('identifier')->nullable();
            $table->string('platform')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('user-devices.db_table_name', 'devices'));
    }
};
