<?php

use App\Models\Media;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Purchase())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignId('warehouse_id')->constrained((new Warehouse())->getTable());
            $table->foreignId('supplier_id')->constrained((new Supplier())->getTable());
            $table->foreignId('tax_id')->nullable()->constrained((new Tax())->getTable());
            $table->integer('item');
            $table->integer('total_qty');
            $table->float('total_discount');
            $table->float('total_tax');
            $table->float('total_cost');
            $table->float('order_tax_rate')->nullable();
            $table->float('order_tax')->nullable();
            $table->float('order_discount')->nullable();
            $table->float('shipping_cost')->nullable();
            $table->float('grand_total');
            $table->float('paid_amount')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->string('payment_method')->nullable();
            $table->foreignId('document_id')->nullable()->constrained((new Media())->getTable());
            $table->longText('note')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists((new Purchase())->getTable());
    }
}
