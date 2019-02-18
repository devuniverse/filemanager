<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMimeTypeColumnToUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('uploads', 'file_mime')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->string('file_mime')->after("file_url")->nullable();
          $table->string('file_extension')->after("file_mime")->default('jpeg');
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
      if (Schema::hasColumn('uploads', 'file_mime')){
        Schema::table('uploads', function (Blueprint $table) {
           $table->dropColumn('file_mime');
           $table->dropColumn('file_extension');
        });
      }
    }
}
