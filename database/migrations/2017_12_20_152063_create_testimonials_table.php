<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        Schema::create(config('rinvex.testimonials.tables.testimonials'), function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('is_approved')->default(false);
            $table->string('body')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('rinvex.testimonials.tables.testimonials'));
    }
}
