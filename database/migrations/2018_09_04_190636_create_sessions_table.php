<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('google_event');
            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')
                  ->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->tinyInteger('number');
            $table->dateTime('date');
            $table->tinyInteger('confirmed')->nullable()->default(null);
            $table->decimal('paid', 8, 2);
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
        Schema::dropIfExists('sessions');
    }
}
