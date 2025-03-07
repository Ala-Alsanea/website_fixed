<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('details_ar')->nullable();
            $table->text('details_en')->nullable();
            $table->string('photo')->nullable();
            $table->string('icon')->nullable();
            $table->tinyInteger('status');
            $table->integer('visits');
            $table->integer('webmaster_id');
            $table->integer('father_id');
            $table->integer('row_no');
            $table->string('seo_title_ar')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->string('seo_description_ar')->nullable();
            $table->string('seo_description_en')->nullable();
            $table->string('seo_keywords_ar')->nullable();
            $table->string('seo_keywords_en')->nullable();
            $table->string('seo_url_slug_ar')->nullable();
            $table->string('seo_url_slug_en')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('sections');
    }
}
