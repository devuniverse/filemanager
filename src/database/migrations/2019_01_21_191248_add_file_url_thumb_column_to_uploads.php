<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileUrlThumbColumnToUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('uploads', 'file_url_thumb')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->string('file_url_thumb')->after("file_url")->nullable();
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
      if (Schema::hasColumn('uploads', 'file_url_thumb')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->string('file_url_thumb');
        });
      }
    }
}
