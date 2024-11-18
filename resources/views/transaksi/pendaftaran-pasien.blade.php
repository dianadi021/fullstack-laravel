<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Pasien') }}
        </h2>
    </x-slot>

    <div class="w-full py-12">
        <div class="shadow max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <fieldset>
                        <div class="w-full mb-4">
                            <form id="biodata_pendaftaran_pasien_form">
                                @csrf
                                <input type="hidden" name="token" class="csrf-token" />
                                <div class="flex gap-10 justify-between">
                                    <div class="w-1/2 h-screen overflow-auto">
                                        <h3 class="font-semibold text-xl text-gray-800 leading-tight">Biodata Pasien</h3>
                                        <table class="w-full table-no-border">
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="jenis_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Jenis Pasien<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <div class="flex gap-10">
                                                        <div class="flex gap-2 items-center">
                                                            <x-text-input id="jenis_pasien_lama" type="radio" name="jenis_pasien" required value="pasien_lama" checked />
                                                            <x-input-label for="jenis_pasien_lama" :value="__('Lama')" />
                                                        </div>
                                                        <div class="flex gap-2 items-center">
                                                            <x-text-input id="jenis_pasien_baru" type="radio" name="jenis_pasien" required value="pasien_baru" />
                                                            <x-input-label for="jenis_pasien_baru" :value="__('Baru')" />
                                                        </div>
                                                        <div class="flex gap-2 items-center hidden_if_pasien_baru">
                                                            <div id="search_pasien_container" x-cloak x-data="{ search_pasienModal: false }" @click.outside="search_pasienModal = false" @close.stop="search_pasienModal = false"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="jenis_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Jenis Kunjungan<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <div class="flex gap-10">
                                                        <div class="flex gap-2 items-center">
                                                            <x-text-input id="jenis_kunjungan_rajal" type="radio" name="jenis_kunjungan" required value="kunjungan_rajal" checked />
                                                            <x-input-label for="jenis_kunjungan_rajal" :value="__('Rawat Jalan')" />
                                                        </div>
                                                        <div class="flex gap-2 items-center">
                                                            <x-text-input id="jenis_kunjungan_ranap" type="radio" name="jenis_kunjungan" required value="kunjungan_ranap" />
                                                            <x-input-label for="jenis_kunjungan_ranap" :value="__('Rawat Inap')" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Unit<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-autocomplete-layout id="unit" name="unit" section="ssr-dropdown" get="unit" placeholder="Pilih Unit..." />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline hidden_if_pasien_baru">
                                                <td>
                                                    <label for="norm_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        No. Rekam Medis<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input type="text" id="norm_pasien" name="norm_pasien" class="block mt-1 w-full text-number-input cursor-default" inputmode="numeric" pattern="[0-9]*" :value="old('norm_pasien')" required readonly />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="nama_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Nama Pasien<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input type="text" id="nama_pasien" name="nama_pasien" class="block mt-1 w-full text-capitalize-input" :value="old('nama_pasien')" required />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="nik_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        NIK<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-text-input type="text" id="nik_pasien" name="nik_pasien" class="block mt-1 w-full text-number-input" inputmode="numeric" pattern="[0-9]*" :value="old('nik_pasien')" required />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="nik_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Tanggal Lahir<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-date-time-picker-layout id="tanggal_lahir" name="tanggal_lahir" section="datepicker"></x-date-time-picker-layout>
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="nik_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Golongan Darah<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-autocomplete-layout id="goldar" name="goldar" section="ssr-dropdown" get="golongan_darah" placeholder="Pilih Golongan Darah..." />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="nik_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Jenis Kelamin<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <x-autocomplete-layout id="gender" name="gender" section="ssr-dropdown" get="gender" placeholder="Pilih Jenis Kelamin..." />
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="nik_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Alamat Pasien<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <div>
                                                        <div>
                                                            <x-text-input id="address_pasien" class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm" type="text" name="address_pasien" required placeholder="Desa RT000/RW000 No. 000" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div>
                                                            <label for="id_provinsi" class="block text-sm font-medium text-gray-700 mb-2">
                                                                Provinsi<span class="text-red-500">*</span>
                                                            </label>
                                                            <x-autocomplete-layout class="check_form_client_register" section="ssr-dropdown" get="provinsi" placeholder="Pilih provinsi..." />
                                                        </div>

                                                        <div id="container_kabupaten" class="address_hidden">
                                                            <label for="id_kabupaten" class="block text-sm font-medium text-gray-700 mb-2">
                                                                Kabupaten<span class="text-red-500">*</span>
                                                            </label>
                                                            <x-autocomplete-layout class="check_form_client_register" section="ssr-dropdown" get="kabupaten" placeholder="Pilih kabupaten..." onclick="DropdownGetLoad('kabupaten', 'provinsi', 'wilayah', '#biodata_pendaftaran_pasien_form')" />
                                                        </div>

                                                        <div id="container_kecamatan" class="address_hidden">
                                                            <label for="id_kecamatan" class="block text-sm font-medium text-gray-700 mb-2">
                                                                Kecamatan<span class="text-red-500">*</span>
                                                            </label>
                                                            <x-autocomplete-layout class="check_form_client_register" section="ssr-dropdown" get="kecamatan" placeholder="Pilih kecamatan..." onclick="DropdownGetLoad('kecamatan', 'kabupaten', 'wilayah', '#biodata_pendaftaran_pasien_form')" />
                                                        </div>

                                                        <div id="container_kelurahan" class="address_hidden">
                                                            <label for="id_kelurahan" class="block text-sm font-medium text-gray-700 mb-2">
                                                                Kelurahan<span class="text-red-500">*</span>
                                                            </label>
                                                            <x-autocomplete-layout class="check_form_client_register" section="ssr-dropdown" get="kelurahan" placeholder="Pilih kelurahan..." onclick="DropdownGetLoad('kelurahan', 'kecamatan', 'wilayah', '#biodata_pendaftaran_pasien_form')" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <label for="nik_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Nomor Ponsel<span class="text-red-500">*</span>
                                                    </label>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    <div>
                                                        <select id="nomor_ponsel_pasien" onchange="execFormSection('nomor_ponsel_pasien', this)" class="w-full px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-700 hover:bg-gray-100 transition-all duration-200">
                                                            <option value="" selected disabled>Pilih Opsi...</option>
                                                            <option value="handphone" class="optn_list_nomor_pasien">Handphone</option>
                                                            <option value="whatsapp" class="optn_list_nomor_pasien">Whatsapp</option>
                                                            <option value="telegram" class="optn_list_nomor_pasien">Telegram</option>
                                                        </select>
                                                        <div id="container_nomor_ponsel_pasien">
                                                            <table class="w-full table-no-border"></table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="w-1/2 h-screen overflow-auto">
                                        <table class="w-full table-no-border">
                                            <tr class="align-baseline"></tr>
                                        </table>
                                    </div>
                                </div>

                                <button id="resetBtn" type="reset"></button>
                            </form>
                            <div class="w-full flex justify-center pt-5">
                                <div class="flex gap-1">
                                    <x-secondary-button class="ms-4" onclick="execFormSection('btnBack')">
                                        {{ __('Kembali') }}
                                    </x-secondary-button>
                                    <x-btn-customize-layout class="ms-4" section="danger" onclick="execFormSection('btnFormReset')">
                                        {{ __('Reset') }}
                                    </x-btn-customize-layout>
                                    <x-btn-customize-layout class="ms-4" section="success" onclick="execFormSection('btnFormSimpan', this)">
                                        {{ __('Simpan') }}
                                    </x-btn-customize-layout>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // onLoad Start
            (async function () {
                // Modal Section START
                const $modalSlotContent = `
                    <table id="listPasienTable" class="min-w-full table-auto table-text-center-important">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">Aksi</th>
                                <th class="px-4 py-2">NIK</th>
                                <th class="px-4 py-2">No.RM</th>
                                <th class="px-4 py-2">Nama Pasien</th>
                                <th class="px-4 py-2">Tanggal Lahir</th>
                                <th class="px-4 py-2">Jenis Kelamin</th>
                                <th class="px-4 py-2">Alamat</th>
                            </tr>
                        </thead>
                    </table>
                `;
                await CreatePopUpModal("#search_pasien_container", "search_pasienModal", "search_pasienForm", ["", ""], $modalSlotContent, ["Cari Pasien", "Simpan", "Reset", "Tutup"], ["List Pasien"], null, { btn: false, funcBtnOpen: "DataTablesListPasien()" });
                // Modal Section END
            })();
            // onLoad End

            // Radio Button Jenis Pasien onClick/onChecked START
            $("input[type=radio][name=jenis_pasien]").on("change", function () {
                if ($(this).val() == "pasien_baru") {
                    $(".hidden_if_pasien_baru").hide();

                    ForceEmptyFormValue();
                } else {
                    $(".hidden_if_pasien_baru").show();
                }
            })
            // Radio Button Jenis Pasien onClick/onChecked END
        })

        // FUNCTIONS START
        function execFormSection($section, $this = null) {
            if ($section == "btnFormReset") {
                localStorage.removeItem("search_params");
                $("#resetBtn").click();
            }

            if ($section == "btnFormSimpan") {
                setTimeout(async function () { await CheckForm(); }, 10);

                Swal.fire({
                    title: "Apakah data pasien sudah benar?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Batal",
                    confirmButtonText: "Lanjutkan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#loadingAjax").show();
                        $(".csrf-token").val($('meta[name="csrf-token"]').attr('content'));

                        $($this).hide();
                        toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");

                        $.ajax({
                            url: `${$base_url}/control/pendaftaran-pasien`,
                            type: "POST",
                            data: $("#biodata_pendaftaran_pasien_form").serializeArray(),
                            xhrFields: {
                                withCredentials: true
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(callback) {
                                const { messages } = callback;
                                console.dir('success', callback);
                                toastr.success(messages, "Success!");

                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            },
                            error: function(callback) {
                                const { responseJSON } = callback;
                                const { errors, message, messages, datas } = responseJSON;
                                let errorInfo, validator;
                                if (datas) {
                                    const { errorInfo: errInfo, validator: validCallback } = datas
                                    errorInfo = errInfo;
                                    validator = validCallback;
                                }
                                console.dir('error', callback);

                                if (errors) {
                                    for (let key in errors) {
                                        AllNotify(errors[key][0], "error");
                                        $(`#err_${key}`).show();
                                        $(`#err_${key} li`).html(errors[key][0]);
                                    }
                                } else if (message || messages || errorInfo || validator) {
                                    const $txtMsgAlert = (validator ? "input data tidak sesuai atau tidak boleh kosong" : ( errorInfo ? errorInfo[2] : (messages ? messages : message)));
                                    AllNotify($txtMsgAlert, "error");
                                }

                                $("#loadingAjax").hide();
                                $($this).show();
                            },
                        });
                    }
                });
            }

            if ($section == "btnBack") {
                window.history.back();
            }

            if ($section == "nomor_ponsel_pasien") {
                const $txtOptnValue = $($this).val();
                const $appendnomorPonselPasien = `
                    <tr class="align-baseline list_nomor_pasien">
                        <td class="capitalize">${$($this).val()}</td>
                        <td>:</td>
                        <td>
                            <x-text-input type="text" id="${$txtOptnValue}_pasien" name="${$txtOptnValue}_pasien" class="block mt-1 w-full text-number-input" inputmode="numeric" pattern="[0-9]*" :value="old('${$txtOptnValue}_pasien')" required />
                        </td>
                        <td>
                            <span class='inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer' onclick='execAction("hapus_nomor_pasien", this, "${$txtOptnValue}")'>Hapus</span>
                        </td>
                    </tr>
                `;
                $("#container_nomor_ponsel_pasien table").append($appendnomorPonselPasien);
                ClassDOMInputStrict();
                setTimeout(function () {
                    $(".optn_list_nomor_pasien").each(function () {
                        if ($(this).val() == $($this).val()) {
                            $(this).hide();
                        }
                    })

                    if (($(".list_nomor_pasien")).length == 3) {
                        $($this).hide();
                    }
                }, 10);
            }
        }

        function execAction($action, $this, $inputID = null) {
            if ($action == "hapus_nomor_pasien") {
                $($this).parent().parent().remove();
                setTimeout(function () {
                    $(".optn_list_nomor_pasien").each(function () {
                        if ($(this).val() == $inputID) {
                            $(this).show();
                            $(".optn_list_nomor_pasien").parent().show();
                        }
                    })
                }, 10);
            }
        }

        async function DataTablesListPasien() {
            const $coloumnsArray = [];
            $coloumnsArray.push({
                data: null,
                autoWidth: false,
                orderable: false,
                searchable: false,
                render: (data) =>
                    `<div class='flex gap-1 justify-center'>
                        <span class='inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary focus:bg-primary active:bg-primary focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer' onclick='PilihPasienLama(${data.id_pasien})'>pilih</span>
                    </div>` // Template class btn ada di file CustomizeBtnLayout.blade.php
            });
            $coloumnsArray.push({ data: 'nik' }, { data: 'norm' }, { data: 'fullname' }, { data: 'birthdate' }, { data: 'jenis_kelamin' }, { data: 'address' });
            setTimeout(async function () { await ContentLoaderDataTableV3(`/api/search?get_data=list_pasien_lama`,"#listPasienTable", $coloumnsArray); }, 10);
        }

        function CheckForm() {
            setTimeout(function () {
                const $isPasienLama = ($("input[type=radio][name=jenis_pasien]:checked").val() == "pasien_lama" ? true : false);
                const $isEmptyNoRM = (!IsValidVal($("#norm_pasien").val()) ? true : false);

                if ($isPasienLama) {
                    if ($isEmptyNoRM) {
                        AllNotify("Nomor Rekam Medis tidak boleh kosong! Harus memilih dari <strong>Cari Pasien</strong>", "error");
                        return false;
                    }
                }
            }, 10);
        }

        async function PilihPasienLama($id_pasien) {
            const { datas } = await GetFromAPI(`/api/search?get_data=list_pasien_lama&id_pasien=${$id_pasien}`);

            if (!IsValidVal(datas, "bool", null, 0)) {
                AllNotify("Data Pasien tidak ditemukan!", "error");
                return false;
            }

            const $isPasienLama = ($("input[type=radio][name=jenis_pasien]:checked").val() == "pasien_lama" ? true : false);
            if ($isPasienLama) {
                ForceEmptyFormValue();
            }

            const { norm, fullname, nik, birthdate, id_goldar, id_gender } = IsValidVal(datas, "value", null, "0");
            const { address, id_provinsi, id_kabupaten, id_kecamatan, id_kelurahan } = IsValidVal(datas, "value", null, "0");
            const { handphone, whatsapp, telegram } = IsValidVal(datas, "value", null, "0");


            $("#norm_pasien").val(norm);
            $("#nama_pasien").val(fullname);
            $("#nik_pasien").val(nik);
            $("#tanggal_lahir").val(birthdate);
            $("#address_pasien").val(address);
            $("#goldar").val(id_goldar).trigger('change');
            $("#gender").val(id_gender).trigger('change');

            if (IsValidVal(handphone)) {
                $("#nomor_ponsel_pasien").val("handphone").trigger('change');
                setTimeout(function () { $("#handphone_pasien").val(handphone); }, 10);
            }

            if (IsValidVal(whatsapp)) {
                $("#nomor_ponsel_pasien").val("whatsapp").trigger('change');
                setTimeout(function () { $("#whatsapp_pasien").val(whatsapp); }, 10);
            }

            if (IsValidVal(telegram)) {
                $("#nomor_ponsel_pasien").val("telegram").trigger('change');
                setTimeout(function () { $("#telegram_pasien").val(telegram); }, 10);
            }

            $(".modal_section_close_btn").click();
        }

        function ForceEmptyFormValue() {
            $("#norm_pasien").val("");
            $("#nama_pasien").val("");
            $("#nik_pasien").val("");
            $("#tanggal_lahir").val("");
            $("#address_pasien").val("");
            $("#handphone_pasien").val("");
            $("#whatsapp_pasien").val("");
            $("#telegram_pasien").val("");
            $("#goldar").val("").trigger('change');
            $("#gender").val("").trigger('change');

            $(".list_nomor_pasien").each(function () {
                $(this).remove();
            })
            $(".optn_list_nomor_pasien").each(function () {
                $(this).show();
            })
            $("#nomor_ponsel_pasien").show();
        }
        // FUNCTIONS END
    </script>
</x-dynamic-layout>
