<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pelaksanaan Pelayanan') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="shadow max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="p-6 text-gray-900">
                    <fieldset>
                        <legend class="text-xl font-semibold text-gray-800">
                            {{ __('Parameter Pencarian') }}
                        </legend>
                        <div class="w-full flex mb-4">
                            <div class="w-full sm:w-2/5 flex flex-wrap">
                                <form id="searchForm" onsubmit="search('submit')">
                                    <table class="w-full table-no-border">
                                        <tr class="align-baseline">
                                            <td>
                                                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Tanggal
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <div class="flex gap-5 align-baseline">
                                                    <x-date-time-picker-layout id="tanggal_awal" name="tanggal_awal" class="text-center" section="datepicker"></x-date-time-picker-layout>
                                                    <span class="content-center">-</span>
                                                    <x-date-time-picker-layout id="tanggal_akhir" name="tanggal_akhir" class="text-center" section="datepicker"></x-date-time-picker-layout>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="align-baseline">
                                            <td>
                                                <label for="jenis_kunjungan" class="block text-sm font-medium text-gray-700 mb-2 text-nowrap">
                                                    Jenis Kunjungan<span class="text-red-500">*</span>
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td><x-autocomplete-layout id="jenis_kunjungan" name="jenis_kunjungan" class="check_form_search w-full px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-700 hover:bg-gray-100 transition-all duration-200" section="ssr-dropdown" get="jenis_kunjungan" placeholder="Pilih Jenis Kunjungan..." /></td>
                                        </tr>
                                        <tr class="align-baseline">
                                            <td>
                                                <label for="status_kunjungan" class="block text-sm font-medium text-gray-700 mb-2 text-nowrap">
                                                    Status Kunjungan<span class="text-red-500">*</span>
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td><x-autocomplete-layout id="status_kunjungan" name="status_kunjungan" class="check_form_search w-full px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-700 hover:bg-gray-100 transition-all duration-200" section="ssr-dropdown" get="status_pendaftaran" placeholder="Pilih Status Kunjungan..." /></td>
                                        </tr>
                                        <tr class="align-baseline">
                                            <td>
                                                <label for="id_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Unit
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td><x-autocomplete-layout id="unit" name="unit" class="check_form_search w-full px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-700 hover:bg-gray-100 transition-all duration-200" section="ssr-dropdown" get="unit" placeholder="Pilih Unit..." /></td>
                                        </tr>
                                    </table>

                                    <x-btn-customize-layout type="button" id="btnSearch" section="success" class="ms-4" onclick="search('cari')">
                                        {{ __('Cari') }}
                                    </x-btn-customize-layout>

                                    <x-btn-customize-layout type="button" section="danger" class="ms-4" onclick="search('reset')">
                                        {{ __('Reset') }}
                                    </x-btn-customize-layout>
                                </form>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="mt-6 overflow-x-auto">
                    <table id="pelaksanaan_pelayananTable" class="cek_datatables_content min-w-full table-auto table-text-center-number">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">{{ __('No') }}</th>
                                <th class="px-4 py-2">{{ __('Aksi') }}</th>
                                <th class="px-4 py-2">{{ __('No.RM') }}</th>
                                <th class="px-4 py-2">{{ __('NIK') }}</th>
                                <th class="px-4 py-2">{{ __('Nama') }}</th>
                                <th class="px-4 py-2">{{ __('Alamat') }}</th>
                                {{-- <th class="px-4 py-2">{{ __('Dokter') }}</th>
                                <th class="px-4 py-2">{{ __('Poli/Unit') }}</th>
                                <th class="px-4 py-2">{{ __('Label') }}</th>
                                <th class="px-4 py-2">{{ __('Status') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(async function() {
            (async function() {
                // Load After Component Created START
                setTimeout(async() => {
                    $("#tanggal_awal").val("{{ date('d-m-Y') }}");
                    $("#tanggal_akhir").val("{{ date('d-m-Y') }}");

                    await DataTablesListKunjungan();
                }, 100);
                // Load After Component Created END
            })();
        });

        async function DataTablesListKunjungan() {
            const $coloumnsArray = [{
                data: null,
                render: (data, type, row, meta) => meta.row + 1
            }];
            $coloumnsArray.push({
                data: null,
                autoWidth: false,
                orderable: false,
                searchable: false,
                render: (data) =>
                    `<div class='flex gap-1 justify-center'>
                        <span class='inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary focus:bg-primary active:bg-primary focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer' onclick="OpenLink('/transaksi/pelaksanaan-pelayanan/${data.id_kunjungan}', 'self')">pilih</span>
                    </div>` // Template class btn ada di file CustomizeBtnLayout.blade.php
            });
            $coloumnsArray.push({ data: 'norm' }, { data: 'nik' }, { data: 'nama_pasien' }, { data: 'alamat' });//, { data: 'nama_dpjp' }, { data: 'nama_poli' }, { data: 'label_kunjungan' }, { data: 'status_pendaftaran' });

            const $formArray = $(`#searchForm`).serializeArray();
            const $listParamsContent = [];
            $formArray.forEach(function ($list) {
                const { name } = $list;
                if (IsValidVal($(`#${name}`).val())) {
                    $listParamsContent.push(`${name}=${$(`#${name}`).val()}`);
                }
            });

            const $params = $listParamsContent.length > 0 ? $listParamsContent.join("&") : $listParamsContent;
            const $fxdParams = IsValidVal($params) ? `&${$params}` : "";

            if ($.fn.DataTable.isDataTable(`#pelaksanaan_pelayananTable`)) {
                $(`#pelaksanaan_pelayananTable`).DataTable().destroy();
            }

            setTimeout(async function () { await ContentLoaderDataTableV3(`/api/search?get_data=list_pasien_pelaksanaan_pelayanan_kunjungan${$fxdParams}`,"#pelaksanaan_pelayananTable", $coloumnsArray); }, 10);
        }

        // Function On CLICK START
        async function search(method) {
            if (method == "reset") {
                $("#searchForm")[0].reset();
                $("#tanggal_awal").val("{{ date('d-m-Y') }}");
                $("#tanggal_akhir").val("{{ date('d-m-Y') }}");
            }

            if (method == "cari") {
                await DataTablesListKunjungan();
            }
        }
        // Function On CLICK END
    </script>
</x-dynamic-layout>
