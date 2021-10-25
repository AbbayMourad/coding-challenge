<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longText("image");
        });
    }

     public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn("image");
        });
    }
}
