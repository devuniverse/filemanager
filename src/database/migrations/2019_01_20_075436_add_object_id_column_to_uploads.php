<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObjectIdColumnToUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('uploads', 'object_id')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->integer('object_id')->after("id")->nullable();
        });
      }
      if (!Schema::hasColumn('uploads', 'user_id')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->integer('user_id')->after("object_id");
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
      if (Schema::hasColumn('uploads', 'object_id')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->dropColumn('object_id');
        });
      }
      if (Schema::hasColumn('uploads', 'user_id')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->dropColumn('user_id');
        });
      }
    }
}
