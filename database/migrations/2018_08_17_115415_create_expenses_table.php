<?php

use App\Models\Account;
use App\Models\ExpenseCategory;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->foreignId('expense_category_id')->constrained((new ExpenseCategory())->getTable());
            $table->foreignId('warehouse_id')->constrained((new Warehouse())->getTable());
            $table->foreignId('account_id')->nullable()->constrained((new Account())->getTable());
            $table->integer('user_id');
            $table->double('amount');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
