<?php

use App\Models\Brand;
use App\Models\Media;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Brand())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('thumbnail_id')->nullable()->constrained((new Media())->getTable());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new Brand())->getTable());
    }
}
