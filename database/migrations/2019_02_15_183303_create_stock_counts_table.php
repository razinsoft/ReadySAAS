<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_counts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no');
            $table->foreignId('warehouse_id')->constrained((new Warehouse())->getTable());
            $table->string('category_id')->nullable();
            $table->string('brand_id')->nullable();
            $table->foreignIdFor(User::class);
            $table->string('type');
            $table->string('initial_file')->nullable();
            $table->string('final_file')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_adjusted');
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
        Schema::dropIfExists('stock_counts');
    }
}
