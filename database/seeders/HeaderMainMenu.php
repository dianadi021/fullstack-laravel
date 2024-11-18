<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class HeaderMainMenu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        // DB::table('list_menus')->insert([
        //     'name' => 'Dashboard',
        //     'route_name' => 'dashboard',
        //     'link' => '/dashboard',
        // ]);

        $lastID = DB::table('list_menus')->insertGetId([
            'name' => 'Master Data',
            'is_parent' => 1,
        ]);

        $datas = [
            [
                'name' => 'Obat',
                'route_name' => 'master-data.obat',
                'link' => '/master-data/obat',
                'icon' => 'assets/images/icons/main-menu/1529570.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Golongan Darah',
                'route_name' => 'master-data.golongan-darah',
                'link' => '/master-data/golongan-darah',
                'icon' => 'assets/images/icons/main-menu/4633210.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Wilayah',
                'route_name' => 'master-data.wilayah',
                'link' => '/master-data/wilayah',
                'icon' => 'assets/images/icons/main-menu/9747001.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Jenis Kelamin',
                'route_name' => 'master-data.jenis-kelamin',
                'link' => '/master-data/jenis-kelamin',
                'icon' => 'assets/images/icons/main-menu/2517445.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'User System',
                'route_name' => 'master-data.user-system',
                'link' => '/master-data/user-system',
                'icon' => 'assets/images/icons/main-menu/8965339.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Pekerjaan',
                'route_name' => 'master-data.pekerjaan',
                'link' => '/master-data/pekerjaan',
                'icon' => 'assets/images/icons/main-menu/3281289.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Suku/Ras',
                'route_name' => 'master-data.suku-ras',
                'link' => '/master-data/suku-ras',
                'icon' => 'assets/images/icons/main-menu/3778638.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Agama',
                'route_name' => 'master-data.agama',
                'link' => '/master-data/agama',
                'icon' => 'assets/images/icons/main-menu/11531428.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Module Menu',
                'route_name' => 'master-data.module-menu',
                'link' => '/master-data/module-menu',
                'icon' => 'assets/images/icons/main-menu/12087772.png',
                'id_parent' => $lastID,
            ],
        ];

        DB::table('list_menus')->insert($datas);

        $lastID = DB::table('list_menus')->insertGetId([
            'name' => 'Transaksi',
            'is_parent' => 1,
        ]);

        $datas = [
            [
                'name' => 'Pelaksanaan Pelayanan',
                'route_name' => 'transaksi.pelaksanaan-pelayanan',
                'link' => '/transaksi/pelaksanaan-pelayanan',
                'icon' => 'assets/images/icons/main-menu/6898949.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Pembayaran',
                'route_name' => 'transaksi.pembayaran',
                'link' => '/transaksi/pembayaran',
                'icon' => 'assets/images/icons/main-menu/10535988.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Billing',
                'route_name' => 'transaksi.billing',
                'link' => '/transaksi/billing',
                'icon' => 'assets/images/icons/main-menu/1651907.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Pendaftaran Pasien',
                'route_name' => 'transaksi.pendaftaran-pasien',
                'link' => '/transaksi/pendaftaran-pasien',
                'icon' => 'assets/images/icons/main-menu/3456388.png',
                'id_parent' => $lastID,
            ]
        ];

        DB::table('list_menus')->insert($datas);

        $lastID = DB::table('list_menus')->insertGetId([
            'name' => 'Inventory',
            'is_parent' => 1,
        ]);

        $datas = [
            [
                'name' => 'Stok Barang',
                'route_name' => 'inventory.stok-barang',
                'link' => '/inventory/stok-barang',
                'icon' => 'assets/images/icons/main-menu/7656409.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Stok Obat',
                'route_name' => 'inventory.stok-obat',
                'link' => '/inventory/stok-obat',
                'icon' => 'assets/images/icons/main-menu/1529570.png',
                'id_parent' => $lastID,
            ]
        ];

        DB::table('list_menus')->insert($datas);

        $lastID = DB::table('list_menus')->insertGetId([
            'name' => 'Informasi',
            'is_parent' => 1,
        ]);

        $datas = [
            [
                'name' => 'Rekam Medis',
                'route_name' => 'informasi.rekam-medis',
                'link' => '/informasi/rekam-medis',
                'icon' => 'assets/images/icons/main-menu/11411453.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Kunjungan Pasien',
                'route_name' => 'informasi.kunjungan-pasien',
                'link' => '/informasi/kunjungan-pasien',
                'icon' => 'assets/images/icons/main-menu/1376203.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Transaksi Pasien',
                'route_name' => 'transaksi.transaksi-pasien',
                'link' => '/transaksi/transaksi-pasien',
                'icon' => 'assets/images/icons/main-menu/10535988.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Keuangan Klinik',
                'route_name' => 'transaksi.keuangan-klinik',
                'link' => '/transaksi/keuangan-klinik',
                'icon' => 'assets/images/icons/main-menu/10535988.png',
                'id_parent' => $lastID,
            ],
        ];

        DB::table('list_menus')->insert($datas);

        $lastID = DB::table('list_menus')->insertGetId([
            'name' => 'Seklinik',
            'is_parent' => 1,
        ]);

        $datas = [
            [
                'name' => 'Pengaturan',
                'route_name' => 'seklinik.pengaturan',
                'link' => '/seklinik/pengaturan',
                'icon' => 'assets/images/icons/main-menu/3953226.png',
                'id_parent' => $lastID,
            ],
            [
                'name' => 'Pegawai',
                'route_name' => 'pengaturan.pegawai',
                'link' => '/pengaturan/pegawai',
                'icon' => 'assets/images/icons/main-menu/17941466.png',
                'id_parent' => $lastID,
            ]
        ];

        DB::table('list_menus')->insert($datas);
    }
}
