<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pelaksanaan Pelayanan') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="shadow max-w-7xl mx-auto sm:p-6 lg:p-8">
            <div class="max-w-full mx-auto">
                <div class="border rounded-xl divide-y">
                    <div class="group">
                        <input type="checkbox" id="accordion_data_kunjungan" class="peer hidden" checked>

                        <label for="accordion_data_kunjungan" class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                            <span class="text-lg font-semibold">{{ __('Data Kunjungan') }}</span>

                            <div class="peer-checked:rotate-90 transition-all duration-300 w-5 h-5 text-gray-700">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </label>

                        <div class="overflow-hidden max-h-0 peer-checked:max-h-[fit-content] transition-all duration-300 text-gray-600 px-5">
                            <fieldset>
                                <div class="w-full flex mb-4 justify-between">
                                    <div class="w-full sm:w-2/5 flex flex-wrap">
                                        <table class="w-full table-no-border">
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="norm" class="block text-sm font-medium text-gray-700 mb-2">
                                                        No.Rekam Medis
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="norm" readonly autocomplete="norm" value="{{ $dataPasienKunjungan['norm'] }}" />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="nama_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Nama Pasien
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="nama_pasien" readonly autocomplete="nama_pasien" value="{{ $dataPasienKunjungan['fullname'] }}" />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Tanggal Lahir / Umur Pasien
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="birthdate" readonly autocomplete="birthdate" value="{{ $dataPasienKunjungan['birthdate'] }} / {{ $dataPasienKunjungan['umur'] }} Tahun" />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="goldar" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Golongan Darah
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="goldar" readonly autocomplete="goldar" value="{{ $dataPasienKunjungan['goldar'] }}" />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Jenis Kelamin
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="gender" readonly autocomplete="gender" value="{{ $dataPasienKunjungan['jenis_kelamin'] }}" />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="full_address" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Alamat
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td class="content-center">
                                                    <textarea name="full_address" cols="30" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block px-3 py-2 w-full resize-none" readonly>{{ $dataPasienKunjungan['full_address'] }}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="w-full sm:w-2/5 flex flex-wrap">
                                        <table class="w-full table-no-border">
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Tanggal Kunjungan
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="tanggal_kunjungan" readonly autocomplete="tanggal_kunjungan" value="{{ $dataPasienKunjungan['tanggal_kunjungan'] }}" />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Unit
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="unit" readonly autocomplete="unit" value="" />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="bed_poli" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Bed / Poli
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="bed_poli" readonly autocomplete="bed_poli" value="" />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline text-nowrap">
                                                <td>
                                                    <label for="dokter_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Dokter Kunjungan
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input class="block mt-1 w-full" type="text" name="dokter_kunjungan" readonly autocomplete="dokter_kunjungan" value="" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(async function() {
            (async function() {
                // Load After Component Created START
                setTimeout(async () => {}, 100);
                // Load After Component Created END
            })();
        });

        // Function On CLICK START
        // Function On CLICK END
    </script>

    <style>
        .table-no-border {
            height: fit-content;
        }

        .table-no-border td:first-child,
        .table-no-border td:last-child {
            max-width: 100px
        }
    </style>
</x-dynamic-layout>
