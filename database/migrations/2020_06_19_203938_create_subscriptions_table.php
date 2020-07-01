<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $now = Carbon::now();
            $table->id();
            $table->unsignedInteger('user_id')->default(Auth::id());
            $table->string('subscription_name');
            $table->double('price', 6, 2)->default('9.99');
            $table->string('category')->nullable();
            $table->date('first_date')->default($now);
            $table->date('next_date')->default($now);
            $table->string('period')->default('Monthly');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('subscriptions');
        Schema::enableForeignKeyConstraints();
    }
}
