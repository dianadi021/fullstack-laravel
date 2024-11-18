<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP TYPE IF EXISTS gender_enum");
        DB::statement("CREATE TYPE gender_enum AS ENUM ('Tidak Diketahui', 'Laki-Laki', 'Perempuan', 'Tidak Dapat Ditentukan', 'Tidak Mengisi')");

        DB::statement("DROP TYPE IF EXISTS jenis_unit_enum");
        DB::statement("CREATE TYPE jenis_unit_enum AS ENUM ('Rawat Darurat', 'Rawat Jalan', 'Rawat Inap')");

        DB::statement("DROP TYPE IF EXISTS status_billing_pendaftaran_enum");
        DB::statement("CREATE TYPE status_billing_pendaftaran_enum AS ENUM ('Belum', 'Lunas', 'Dicicil', 'Batal')");

        DB::statement("DROP TYPE IF EXISTS status_jenis_pasien_enum");
        DB::statement("CREATE TYPE status_jenis_pasien_enum AS ENUM ('Baru', 'Lama')");

        DB::statement("DROP TYPE IF EXISTS status_pendaftaran_pasien_enum");
        DB::statement("CREATE TYPE status_pendaftaran_pasien_enum AS ENUM ('Batal', 'Masuk', 'Menunggu', 'Diperiksa', 'Resep', 'Mutasi Rajal', 'Ranap', 'Mutasi Ranap', 'Keluar', 'Selesai', 'Booking')");

        DB::statement("DROP TYPE IF EXISTS pendidikan_pasien_enum");
        DB::statement("CREATE TYPE pendidikan_pasien_enum AS ENUM ('Tidak Diketahui', 'Tidak Sekolah', 'SD', 'SLTP', 'SLTA', 'D1-D3', 'D4', 'S1', 'S2', 'S3')");

        DB::statement("DROP TYPE IF EXISTS pekerjaan_pasien_enum");
        DB::statement("CREATE TYPE pekerjaan_pasien_enum AS ENUM ('Tidak Diketahui', 'Tidak Bekerja', 'PNS', 'TNI/POLRI', 'BUMN', 'Pegawai', 'Swasta/Wirausaha', 'Buruh', 'Lain-lain')");

        DB::statement("DROP TYPE IF EXISTS status_pernikahan_pasien_enum");
        DB::statement("CREATE TYPE status_pernikahan_pasien_enum AS ENUM ('Tidak Diketahui', 'Laki-Laki', 'Perempuan', 'Tidak Dapat Ditentukan', 'Tidak Mengisi')");


        $dbDriver = Schema::getConnection()->getDriverName();

        if ($dbDriver === 'pgsql') {
            if (Schema::hasColumn('gender', 'name')) {
                DB::statement("ALTER TABLE gender ALTER COLUMN name TYPE gender_enum USING (name::gender_enum);");
                DB::statement("ALTER TABLE penduduk ALTER COLUMN gender TYPE gender_enum USING (gender::gender_enum);");
            }

            if (Schema::hasColumn('unit', 'jenis_unit')) {
                DB::statement("ALTER TABLE unit ALTER COLUMN jenis_unit TYPE jenis_unit_enum USING (jenis_unit::jenis_unit_enum);");
            }

            if (Schema::hasTable('penduduk')) {
                DB::statement("ALTER TABLE penduduk ALTER COLUMN pendidikan TYPE pendidikan_pasien_enum USING (pendidikan::pendidikan_pasien_enum);");
                DB::statement("ALTER TABLE penduduk ALTER COLUMN pekerjaan TYPE pekerjaan_pasien_enum USING (pekerjaan::pekerjaan_pasien_enum);");
                DB::statement("ALTER TABLE penduduk ALTER COLUMN status_pernikahan TYPE status_pernikahan_pasien_enum USING (status_pernikahan::status_pernikahan_pasien_enum);");
            }

            if (Schema::hasTable('pendaftaran')) {
                DB::statement("ALTER TABLE pendaftaran ALTER COLUMN is_lunas TYPE status_billing_pendaftaran_enum USING (is_lunas::status_billing_pendaftaran_enum);");

                DB::statement("ALTER TABLE pendaftaran ALTER COLUMN jenis_pasien TYPE status_jenis_pasien_enum USING (jenis_pasien::status_jenis_pasien_enum);");

                DB::statement("ALTER TABLE pendaftaran ALTER COLUMN status_pendaftaran TYPE status_pendaftaran_pasien_enum USING (status_pendaftaran::status_pendaftaran_pasien_enum);");
            }

            if (Schema::hasTable('kunjungan')) {
                DB::statement("ALTER TABLE kunjungan ALTER COLUMN status_kunjungan TYPE status_pendaftaran_pasien_enum USING (status_kunjungan::status_pendaftaran_pasien_enum);");
            }

            if (Schema::hasTable('penjualan')) {
                DB::statement("ALTER TABLE penjualan ALTER COLUMN is_lunas TYPE status_billing_pendaftaran_enum USING (is_lunas::status_billing_pendaftaran_enum);");
            }

            if (Schema::hasTable('billing')) {
                DB::statement("ALTER TABLE billing ALTER COLUMN is_lunas TYPE status_billing_pendaftaran_enum USING (is_lunas::status_billing_pendaftaran_enum);");
            }

            if (Schema::hasTable('pembayaran')) {
                DB::statement("ALTER TABLE pembayaran ALTER COLUMN is_lunas TYPE status_billing_pendaftaran_enum USING (is_lunas::status_billing_pendaftaran_enum);");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gender', function (Blueprint $table) {
            $dbDriver = Schema::getConnection()->getDriverName();

            if ($dbDriver === 'pgsql') {
                DB::statement("DROP TYPE IF EXISTS gender_enum");
                DB::statement("DROP TYPE IF EXISTS jenis_unit_enum");
                DB::statement("DROP TYPE IF EXISTS status_billing_pendaftaran_enum");
                DB::statement("DROP TYPE IF EXISTS status_jenis_pasien_enum");
                DB::statement("DROP TYPE IF EXISTS status_pendaftaran_pasien_enum");
            }
        });
    }
};
