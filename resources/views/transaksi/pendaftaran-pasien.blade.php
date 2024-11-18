<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Pasien') }}
        </h2>
    </x-slot>

    {{-- DOM Focused Start --}}
    <a id="click_onload_page" href="#content_container"></a>
    <div id="container_modal_wrapper" x-cloak x-data="{ search_pasienModal: false }" @click.outside="search_pasienModal = false" @close.stop="search_pasienModal = false"></div>
    {{-- DOM Focused End --}}

    <div class="w-full py-12">
        <div class="relative shadow w-full mx-auto sm:px-6 lg:px-8">
            <form id="biodata_pendaftaran_pasien_form">
                @csrf
                <input type="hidden" name="token" class="csrf-token" />

                <div>
                    <div id="content_container" thumbsSlider="" class="swiper swiper_content_pagination">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide cursor-pointer fit_content_container">
                                <div class="relative bg-red-600 text-white p-3 clip-arrow-right">
                                    <h2 class="text-xs font-bold">Pasien</h2>
                                </div>
                            </div>
                            <div class="swiper-slide cursor-pointer fit_content_container">
                                <div class="relative bg-red-600 text-white p-3 clip-arrow-right">
                                    <h2 class="text-xs font-bold">Penanggung Jawab</h2>
                                </div>
                            </div>
                            <div class="swiper-slide cursor-pointer fit_content_container">
                                <div class="relative bg-red-600 text-white p-3 clip-arrow-right">
                                    <h2 class="text-xs font-bold">Rencana Pembayaran</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper swiper_content_container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                @include('layouts.partials.pasien.data-lengkap')
                            </div>
                            <div class="swiper-slide">
                                <div class="w-full flex gap-10 justify-between py-5">
                                    <div class="w-1/2">
                                        <h3 class="font-semibold text-xl text-gray-800 leading-tight">Data Penanggung Jawab</h3>
                                        <table class="w-full table-no-border">
                                            <tr class="align-baseline">
                                                <td>
                                                    <fieldset class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm">
                                                        <legend>Rencana Pembayaran<span class="text-red-500">*</span></legend>
                                                        <div class="flex gap-10">
                                                            <div class="flex gap-2 items-center">
                                                                <x-text-input id="jenis_pembayaran_pasen" type="radio" name="jenis_pembayaran_pasen" required value="Bayar Sendiri" checked />
                                                                <x-input-label for="jenis_pembayaran_pasen" :value="__('Bayar Sendiri')" />
                                                            </div>
                                                            <div class="flex gap-2 items-center">
                                                                <x-text-input id="jenis_pembayaran_pasen" type="radio" name="jenis_pembayaran_pasen" required value="Asuransi" />
                                                                <x-input-label for="jenis_pembayaran_pasen" :value="__('Asuransi')" />
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <fieldset class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm">
                                                        <legend>Penanggung Jawab<span class="text-red-500">*</span></legend>
                                                        <div class="flex gap-10">
                                                            <table class="w-full table-no-border">
                                                                <tr class="align-baseline">
                                                                    <td colspan="3">
                                                                        <div class="flex gap-2 items-center">
                                                                            <x-text-input type="checkbox" id="penanggung_jawab_sama_dengan_pasien" />
                                                                            <x-input-label for="penanggung_jawab_sama_dengan_pasien" :value="__('Penanggung Jawab Sama Dengan Pasien')" class="text-nowrap" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="align-baseline">
                                                                    <td>
                                                                        <label for="nama_penanggung_jawab_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                                            Nama<span class="text-red-500">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <x-text-input id="nama_penanggung_jawab_pasien" class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm" type="text" name="nama_penanggung_jawab_pasien" required />
                                                                    </td>
                                                                </tr>
                                                                <tr class="align-baseline">
                                                                    <td>
                                                                        <label for="hubungan_penanggung_jawab_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                                            Hubungan Keluarga<span class="text-red-500">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <x-autocomplete-layout id="hubungan_penanggung_jawab_pasien" name="hubungan_penanggung_jawab_pasien" section="ssr-dropdown" get="list_hubungan_keluarga" placeholder="Pilih Hubungan Keluarga..." />
                                                                    </td>
                                                                </tr>
                                                                <tr class="align-baseline">
                                                                    <td>
                                                                        <label for="alamat_penanggung_jawab_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                                            Alamat<span class="text-red-500">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <x-text-input id="alamat_penanggung_jawab_pasien" class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm" type="text" name="alamat_penanggung_jawab_pasien" required />
                                                                    </td>
                                                                </tr>
                                                                <tr class="align-baseline">
                                                                    <td>
                                                                        <label for="nohandphone_penanggung_jawab_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                                            No. Handphone<span class="text-red-500">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <x-text-input type="text" id="nohandphone_penanggung_jawab_pasien" name="nohandphone_penanggung_jawab_pasien" class="block mt-1 w-full text-number-input" inputmode="numeric" pattern="[0-9]*" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <fieldset class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm">
                                                        <legend>Keluarga yang bisa diihubungi<span class="text-red-500">*</span></legend>
                                                        <div class="flex gap-10">
                                                            <table class="w-full table-no-border">
                                                                <tr class="align-baseline">
                                                                    <td colspan="3">
                                                                        <div class="flex gap-2 items-center">
                                                                            <x-text-input type="checkbox" id="keluarga_sama_dengan_penanggung_jawab" />
                                                                            <x-input-label for="keluarga_sama_dengan_penanggung_jawab" :value="__('Keluarga Sama Dengan Penanggung Jawab')" class="text-nowrap" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="align-baseline">
                                                                    <td>
                                                                        <label for="nama_keluarga_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                                            Nama<span class="text-red-500">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <x-text-input id="nama_keluarga_pasien" class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm" type="text" name="nama_keluarga_pasien" required />
                                                                    </td>
                                                                </tr>
                                                                <tr class="align-baseline">
                                                                    <td>
                                                                        <label for="hubungan_keluarga_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                                            Hubungan Keluarga<span class="text-red-500">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <x-autocomplete-layout id="hubungan_keluarga_pasien" name="hubungan_keluarga_pasien" section="ssr-dropdown" get="list_hubungan_keluarga" placeholder="Pilih Hubungan Keluarga..." />
                                                                    </td>
                                                                </tr>
                                                                <tr class="align-baseline">
                                                                    <td>
                                                                        <label for="alamat_keluarga_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                                            Alamat<span class="text-red-500">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <x-text-input id="alamat_keluarga_pasien" class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm" type="text" name="alamat_keluarga_pasien" required />
                                                                    </td>
                                                                </tr>
                                                                <tr class="align-baseline">
                                                                    <td>
                                                                        <label for="nohandphone_keluarga_pasien" class="block text-sm font-medium text-gray-700 mb-2">
                                                                            No. Handphone<span class="text-red-500">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <x-text-input type="text" id="nohandphone_keluarga_pasien" name="nohandphone_keluarga_pasien" class="block mt-1 w-full text-number-input" inputmode="numeric" pattern="[0-9]*" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                            <tr class="align-baseline">
                                                <td>
                                                    <fieldset class="border rounded-lg w-full px-3 py-2 focus:outline-none text-sm">
                                                        <legend>Riwayat Kunjungan Pasien</legend>
                                                        <div class="flex gap-10">
                                                            <table id="DataTablesRiwayatKunjunganPasien" class="min-w-full table-auto table-text-center-important">
                                                                <thead>
                                                                    <tr class="bg-gray-100">
                                                                        <th class="px-4 py-2">Tanggal</th>
                                                                        <th class="px-4 py-2">Status</th>
                                                                        <th class="px-4 py-2">No. Registrasi</th>
                                                                        <th class="px-4 py-2">Poli/Unit</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </fieldset>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="w-full flex justify-center py-5">
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
                        </div>
                    </div>
                </div>

                <button id="resetBtn" type="reset"></button>
            </form>

            <div class="absolute flex right-10 bottom-3 z-50">
                <div class="btn-prev-swiper">
                    <x-btn-customize-layout section="warning" class="ms-4">
                        {{ __('Sebelumnya') }}
                        </x-secondary-button>
                </div>
                <div class="btn-next-swiper">
                    <x-btn-customize-layout section="primary" class="ms-4">
                        {{ __('Selanjutnya') }}
                    </x-btn-customize-layout>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // onLoad Start
            (async function() {
                // Modal Section START
                const $modalSlotContent = `
                    <div id="listPasienTable" class="min-w-full table-auto table-text-center-important h-96 z-0">
                    </div>
                `;
                await CreatePopUpModal(["#search_pasien_container", "#container_modal_wrapper"], "search_pasienModal", "search_pasienForm", ["", ""], $modalSlotContent, ["Cari Pasien", "Simpan", "Reset", "Tutup"], ["List Pasien"], null, {
                    btn: false,
                    funcBtnOpen: "DataTablesListPasien()"
                });

                setTimeout(() => {
                    $("#click_onload_page")[0].click();
                    $('html, body').animate({
                        scrollTop: $("#content_container").offset().top
                    }, 1000);
                }, 500);
                // Modal Section END
            })();
            // onLoad End

            // Radio Button Jenis Pasien onClick/onChecked START
            $("input[type=radio][name=jenis_pasien]").on("change", function() {
                if ($(this).val() == "Baru") {
                    $(".hidden_if_pasien_baru").hide();

                    ForceEmptyFormValue();
                } else {
                    $(".hidden_if_pasien_baru").show();
                }
            })
            // Radio Button Jenis Pasien onClick/onChecked END
        })

        // FUNCTIONS START
        function CheckFormBeforeSubmit() {
            let $isInputFormValid = true;
            const $allDataInputForm = $("#biodata_pendaftaran_pasien_form").serializeArray();
            for (const $list of $allDataInputForm) {
                const { name, value } = $list;

                if (!IsValidVal(value) && $(`input[name=${name}]`).is(':visible') && $(`input[name=${name}]`).attr("type") != "hidden") {
                    const $tmpNama = name.replace("_", " ").toUpperCase();

                    $(`input[name=${$list.name}]`).focus();
                    AllNotify(`<strong>${$tmpNama}</strong> tidak boleh kosong!`, "error");
                    $isInputFormValid = false;
                    break;
                }
            }

            return $isInputFormValid;
        }

        function execFormSection($section, $this = null) {
            if ($section == "btnFormReset") {
                localStorage.removeItem("search_params");
                $("#resetBtn").click();
            }

            if ($section == "btnFormSimpan") {
                setTimeout(async function() {
                    await CheckForm();
                }, 10);

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
                        $(".csrf-token").val($('meta[name="csrf-token"]').attr('content'));

                        // const $isInputFormValid = CheckFormBeforeSubmit();
                        // if (!$isInputFormValid) { return; }

                        $("#loadingAjax").show();

                        $($this).hide();
                        toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");

                        $.ajax({
                            url: `${$base_url}/v1/transaksi/pendaftaran-pasien`,
                            type: "POST",
                            data: $("#biodata_pendaftaran_pasien_form").serializeArray(),
                            xhrFields: {
                                withCredentials: true
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(callback) {
                                const { messages, message } = callback;
                                console.dir(callback);
                                toastr.success(messages || message, "Success!");

                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            },
                            error: function(callback) {
                                const { responseJSON } = callback;
                                const { errors, message, messages, data } = getVarValue(responseJSON);
                                let errorInfo, validator;
                                if (data) {
                                    const { errorInfo: errInfo, validator: validCallback } = data
                                    errorInfo = errInfo;
                                    validator = validCallback;
                                }
                                console.dir(callback);

                                if (errors) {
                                    for (let key in errors) {
                                        AllNotify(errors[key][0], "error");
                                        $(`#err_${key}`).show();
                                        $(`#err_${key} li`).html(errors[key][0]);
                                    }
                                } else if (message || messages || errorInfo || validator) {
                                    const $txtMsgAlert = (validator ? "input data tidak sesuai atau tidak boleh kosong" : (errorInfo ? errorInfo[2] : (messages ? messages : message)));
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
                setTimeout(function() {
                    $(".optn_list_nomor_pasien").each(function() {
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
                setTimeout(function() {
                    $(".optn_list_nomor_pasien").each(function() {
                        if ($(this).val() == $inputID) {
                            $(this).show();
                            $(".optn_list_nomor_pasien").parent().show();
                        }
                    })
                }, 10);
            }
        }

        async function DataTablesListPasien() {
            class CompanyLogoRenderer {
                eGui;

                init(params) {
                    let companyLogo = document.createElement('img');
                    companyLogo.src = `https://www.ag-grid.com/example-assets/space-company-logos/${params.value.toLowerCase()}.png`
                    companyLogo.setAttribute('style', 'display: block; width: 25px; height: auto; max-height: 50%; margin-right: 12px; filter: brightness(1.1)');
                    let companyName = document.createElement('p');
                    companyName.textContent = params.value;
                    companyName.setAttribute('style', 'text-overflow: ellipsis; overflow: hidden; white-space: nowrap;');
                    this.eGui = document.createElement('span');
                    this.eGui.setAttribute('style', 'display: flex; height: 100%; width: 100%; align-items: center')
                    this.eGui.appendChild(companyLogo)
                    this.eGui.appendChild(companyName)
                }

                getGui() {
                    return this.eGui;
                }

                refresh(params) {
                    return false
                }
            };

            const $setColoumn = [
                { field: "mission", filter: true },
                { field: "company", filter: true, cellRenderer: CompanyLogoRenderer },
                { field: "location", filter: true },
                { field: "date", filter: true },
                { field: "price", filter: true, valueFormatter: (params) => { return '£' + params.value.toLocaleString(); } },
                { field: "successful", filter: true },
                { field: "rocket", filter: true }
            ];

            setTimeout(async () => {
                $("#listPasienTable").html("");
                await ContentLoaderDataTableV4(`/assets/space-mission-data.json`, "#listPasienTable", $setColoumn);

                $("#container_modal_wrapper button").click();
            }, 1000);
        }

        function CheckForm() {
            setTimeout(function() {
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
            const { data } = await GetFromAPI(`/api/search?get_data=list_pasien_lama&id_pasien=${$id_pasien}`);
            console.dir(data);

            if (!IsValidVal(data, 0)) {
                AllNotify("Data Pasien tidak ditemukan!", "error");
                return false;
            }

            const $isPasienLama = ($("input[type=radio][name=jenis_pasien]:checked").val() == "pasien_lama" ? true : false);
            if ($isPasienLama) {
                ForceEmptyFormValue();
            }

            const { handphone, whatsapp, telegram } = getVarValue(data, 0);
            const { norm, fullname, nik, birthdate, goldar, gender } = getVarValue(data, 0);
            const { alamat_ktp, provinsi, id_provinsi, kabupaten, id_kabupaten, kecamatan, id_kecamatan, kelurahan, id_kelurahan } = getVarValue(data, 0);


            $("#norm_pasien").val(norm);
            $("#nama_pasien").val(fullname);
            $("#nik_pasien").val(nik);
            $("#tanggal_lahir").val(birthdate);
            $("#address_pasien").val(alamat_ktp);
            $("#goldar").val(goldar).trigger('change');
            $("#gender").val(gender).trigger('change');

            // Wilayah Pilih Pasien Lama START
            $("#provinsi").val(provinsi);
            $("#id_provinsi").val(id_provinsi);
            $("#kabupaten").val(kabupaten);
            $("#id_kabupaten").val(id_kabupaten);
            $("#kecamatan").val(kecamatan);
            $("#id_kecamatan").val(id_kecamatan);
            $("#kelurahan").val(kelurahan);
            $("#id_kelurahan").val(id_kelurahan);
            // Wilayah Pilih Pasien Lama END

            if (IsValidVal(handphone)) {
                $("#nomor_ponsel_pasien").val("handphone").trigger('change');
                setTimeout(function() {
                    $("#handphone_pasien").val(handphone);
                }, 10);
            }

            if (IsValidVal(whatsapp)) {
                $("#nomor_ponsel_pasien").val("whatsapp").trigger('change');
                setTimeout(function() {
                    $("#whatsapp_pasien").val(whatsapp);
                }, 10);
            }

            if (IsValidVal(telegram)) {
                $("#nomor_ponsel_pasien").val("telegram").trigger('change');
                setTimeout(function() {
                    $("#telegram_pasien").val(telegram);
                }, 10);
            }

            $(".modal_section_close_btn").click();
        }

        async function OnLoadDatasPasien() {}

        // DO NOT ADD THIS FUNCTION IN *Radio Button Jenis Pasien onClick/onChecked
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

            $(".list_nomor_pasien").each(function() {
                $(this).remove();
            })

            $(".optn_list_nomor_pasien").each(function() {
                $(this).show();
            })

            $("#nomor_ponsel_pasien").show();
        }
        // FUNCTIONS END

        // SWIPER START
        let swiper = new Swiper(".swiper_content_pagination", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                renderBullet: function(index, className) {
                    const labels = ["Pasien", "Penanggung Jawab", "Rencana Pembayaran"];
                    return `
                        <div class="${className} bg-red-${index === 0 ? '600' : '300'} text-white font-bold px-4 py-2 arrow-shape -ml-[1px]">
                        ${labels[index]}
                        </div>
                    `;
                },
            }
        });
        let swiper2 = new Swiper(".swiper_content_container", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".btn-next-swiper",
                prevEl: ".btn-prev-swiper",
            },
            thumbs: {
                swiper: swiper,
            },
        });
        // SWIPER END
    </script>

    <style>
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper_content_pagination .swiper-slide {
            width: 25%;
            opacity: 0.4;
        }

        .swiper_content_pagination .swiper-slide-thumb-active {
            opacity: 1;
        }

        .clip-arrow-right {
            clip-path: polygon(0 0, 90% 0, 100% 50%, 90% 100%, 0 100%);
        }

        .fit_content_container {
            margin: 0 !important;
            width: fit-content !important;
        }
    </style>
</x-dynamic-layout>
