<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->float("price");
            $table->integer("m2");
            $table->timestamp("verified")->nullable();
            $table->string("address");
            $table->double("longitude")->nullable();
            $table->double("latitude")->nullable();
            $table->foreignId("user_id")->references("id")->on("users");
            $table->foreignId("category_id")->references("id")->on("categories");
            $table->softDeletes();
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
        Schema::dropIfExists('storages');
    }
};
