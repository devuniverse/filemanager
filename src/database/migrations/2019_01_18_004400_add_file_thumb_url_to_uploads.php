<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileThumbUrlToUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('uploads', 'amazon_thumb_url')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->string('amazon_thumb_url')->after("amazon_url")->default('')->nullable();
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
      if (Schema::hasColumn('uploads', 'amazon_thumb_url')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->dropColumn('amazon_thumb_url');
        });
      }
    }
}
