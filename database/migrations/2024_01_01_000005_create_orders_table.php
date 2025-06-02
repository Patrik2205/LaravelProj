<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('email');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}