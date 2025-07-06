<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatitudeAndLongitudeToUmkmsTable extends Migration
{
    public function up()
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->double('latitude', 10, 8)->nullable()->after('gambar'); // Sesuaikan posisi kolom
            $table->double('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('alamat')->nullable()->after('longitude'); // Tambahkan kolom alamat jika belum ada
        });
    }

    public function down()
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'alamat']);
        });
    }
}