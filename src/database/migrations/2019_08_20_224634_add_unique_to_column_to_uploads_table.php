<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueToColumnToUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('uploads', 'uniqueto')){
        Schema::table('uploads', function (Blueprint $table) {
            $table->string('module')->default('')->after('file_url');
            $table->string('uniqueto')->default('')->after('module');
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      if (Schema::hasColumn('uploads', 'uniqueto')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->dropColumn('module');
          $table->dropColumn('uniqueto');
        });
      }
    }
}
