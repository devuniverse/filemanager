<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAmazonColumnToUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('uploads', 'amazon_url')){
          Schema::table('uploads', function (Blueprint $table) {
            $table->string('amazon_url')->after("original_name")->default('')->nullable()->comments('The URL in amazon if uploaded there');
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
      if (Schema::hasColumn('uploads', 'amazon_url')){
        Schema::table('uploads', function (Blueprint $table) {
          $table->dropColumn('amazon_url');
        });
      }
    }
}
