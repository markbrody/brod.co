<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("articles", function (Blueprint $table) {
            $table->uuid("id");
            $table->string("slug")->index();
            $table->string("headline");
            $table->string("subheading")->nullable();
            $table->text("markdown");
            $table->boolean("is_published")->default(0)->index();
            $table->uuid("user_id")->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->primary("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("articles");
    }
}
