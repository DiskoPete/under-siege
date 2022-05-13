<?php

use App\Models\Siege;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sieges', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->integer(Siege::COLUMN_STATUS);
            $table->json('configuration');
            $table->json('results')->nullable();
            $table->timestamps();
            $table->dateTime(Siege::COLUMN_STARTED_AT)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sieges');
    }
};
