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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("customer_name", 80);
            $table->string("customer_email", 120);
            $table->string("customer_mobile", 40);
            $table->enum("status",["CREATED","PAYED","REJECTED"]);
            $table->timestamps();
        });
        $order_demo = new \App\Models\Order([
            "customer_name"=> "Andres Felipe Penna Ramirez",
            "customer_email" => "andres.felipe.penna@gmail.com",
            "customer_mobile" =>"3118452133",
            "status"=>"CREATED"
            ]
        );
        $order_demo->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
