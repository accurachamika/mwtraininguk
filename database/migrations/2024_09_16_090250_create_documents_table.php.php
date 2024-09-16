<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('documents');
        Schema::create('documents', function (Blueprint $table) {
            $table->id('doc_id');
            $table->string('file_name');
            $table->string('doc_type');
            $table->string('std_id');
            $table->string('std_name');
            $table->timestamp('last_updated')->nullable(); 
            $table->string('uploaded_by');
            $table->string('mime');
            $table->text('desc')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
