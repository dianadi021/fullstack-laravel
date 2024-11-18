<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Golongan Darah') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="shadow max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div id="goldar_container" x-cloak x-data="{ goldarModal: false }" @click.outside="goldarModal = false" @close.stop="goldarModal = false"></div>

                <div class="mt-6 overflow-x-auto">
                    <table id="golonganDarahTable" class="min-w-full table-auto table-text-center-number">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">{{ __('No') }}</th>
                                <th class="px-4 py-2 text-left">{{ __('Nama') }}</th>
                                <th class="px-4 py-2 text-left">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-layout>

<script>
    $(document).ready(async function () {
        (async function () {
            const $modalSlotContent = `
            <div class="mt-4">
                <label for="nama">Nama *</label>
                <input type="text" id="nama" name="nama" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
            </div>
            `;
            await CreatePopUpModal("#goldar_container", "goldarModal", "goldarForm", ["simpanGoldar()"], $modalSlotContent, ["Tambah Data", "Simpan", "Reset", "Tutup"], ["Form Tambah Data", "Golongan Darah"], null, { btn: true });
        })();

        setTimeout(async function () { await ContentLoaderDataTableV3(`/api/search?get_data=goldar`,"#golonganDarahTable", [
            { data: null, render: (data, type, row, meta) => meta.row + 1 }, // No urut
            { data: 'name' }, // Nama
            {
                data: null,
                render: (data) =>
                `<div class='flex gap-5 justify-center'>
                    <button class='inline-flex items-center px-4 py-2 bg-warning border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-warning focus:bg-warning active:bg-warning focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' data-id='${data.id}'>Edit</button>
                    <button class='inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' data-id='${data.id}'>Hapus</button>
                </div>` // Template class btn ada di file CustomizeBtnLayout.blade.php
            }
        ]); }, 10);
    });

    function simpanGoldar() {
        AllNotify("Data berhasil disimpan!", "success");
    }
</script>
