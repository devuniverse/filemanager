<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileUrlColumnToUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('uploads', 'file_url')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->string('file_url')->after("file_url")->default('')->nullable();
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
      if (Schema::hasColumn('uploads', 'file_url')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->dropColumn('file_url');
        });
      }
    }
}
