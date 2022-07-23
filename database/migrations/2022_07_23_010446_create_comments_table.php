<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('user_id');
            $table->morphs('commentable');
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->restrictOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
