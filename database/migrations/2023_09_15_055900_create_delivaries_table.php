<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('captin_id')->nullable();
            $table->unsignedBigInteger('address_sent')->nullable();
            $table->unsignedBigInteger('address_get')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('finsh_at')->nullable();
            $table->tinyInteger('delivary_status')->default(0);
            $table->bigInteger('price');
            $table->bigInteger('fee');
            $table->string('package');
            $table->boolean('cancel')->default(false);
            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('delivaries');
    }
};