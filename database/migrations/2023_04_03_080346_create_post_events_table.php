<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('post_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->float('amount')->default(1000);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('post_events');
    }
};
