<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Golongan Darah') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="shadow max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <fieldset>
                        <legend class="text-xl font-semibold text-gray-800">
                            {{ __('Parameter Pencarian') }}
                        </legend>
                        <div class="w-full flex mb-4">
                            <div class="w-full sm:w-1/2 flex flex-wrap">
                                <form id="searchForm" onsubmit="">
                                    <table class="w-full table-no-border">
                                        <tr>
                                            <td>
                                                <label for="id_provinsi" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Nama
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td><x-autocomplete-layout section="ssr-dropdown" get="golongan_darah" placeholder="Pilih Golongan Darah..." /></td>
                                        </tr>
                                    </table>

                                    <x-btn-customize-layout section="success" class="ms-4" onclick="cari(this)">
                                        {{ __('Cari') }}
                                    </x-btn-customize-layout>
                                </form>
                            </div>
                        </div>
                    </fieldset>
                </div>

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
            const $inputSlot = `
            <div class="mt-4">
                <label for="nama">Nama *</label>
                <input type="text" id="nama" name="nama" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
            </div>
            `;
            await CreatePopUpModal("#goldar_container", "goldarModal", "Tambah Data", "goldarForm", "simpanGoldar()", $inputSlot, "Form Tambah Data", "Golongan Darah", null, "Simpan", "Reset", "Tutup");
        })();

        await ContentLoaderDataTableV2(@json($goldar), '#golonganDarahTable', [
            { data: null, render: (data, type, row, meta) => meta.row + 1 }, // No urut
            { data: 'name' }, // Nama
            {
                data: null,
                render: (data) =>
                `<div class='flex gap-5 justify-center'>
                    <button class='inline-flex items-center px-4 py-2 bg-warning border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-warning focus:bg-warning active:bg-warning focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' data'>Edit</button>
                    <button class='inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150' data'>Hapus</button>
                </div>` // Template class btn ada di file CustomizeBtnLayout.blade.php
            }
        ]);
    });

</script>
