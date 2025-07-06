<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatitudeAndLongitudeToWisataDesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wisata_desas', function (Blueprint $table) {
            $table->double('latitude', 10, 8)->nullable()->after('alamat'); // Menentukan presisi dan skala
            $table->double('longitude', 11, 8)->nullable()->after('latitude'); // Sesuaikan setelah kolom mana
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wisata_desas', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
}