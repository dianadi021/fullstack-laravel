const base_url = window.location.host;
const [host, port] = base_url.split(':');
const $base_url = (IsValidVal(port) ? `http://${host}:${port}` : `https://${host}`);

$(document).ready(function () {
    // localStorage.clear();

    $.getScript(`${$base_url}/assets/scripts/js/functions.js`, function () {
        DisableRightClickOnMouse();
        // JQueryOnLoad();
        AutoToIDR();
        InputNumberOnly();
        InitAutocomplete();
        ClearLocalStorage();
        HiddenAddressDropdown();

        // Function ReImplement START
        function AllNotify($msg, $section) {
            AllNotify($msg, $section)
        }
        // Function ReImplement END

        // Class for DOM elements START
        function ClassDOMInputStrict() {
            ClassDOMInputStrict();
        }

        $(".capitalize").on("input", function () {
            let $newVal = $(this).val().toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
            $(this).val($newVal);
        });
        $(".text-capitalize-input").on("input", function () {
            TxtCheckInputSymbol(this);

            let $newVal = $(this).val().toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
            $(this).val($newVal);
        });
        $(".text-check-input-symbol").on("input", function () {
            TxtCheckInputSymbol(this);
        });
        $(".text-number-input").on("input", function () {
            TxtCheckInputSymbol(this);

            let $newVal = $(this).val().replace(/\D/g, "");;
            $(this).val($newVal);
        });
        // Class for DOM elements END
    });

    $("#loadingAjax").hide();
    $("#loadingContetLoader").hide();
});

function ConvertToIDR($val) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2 }).format($val);
}

function ContentLoader($url, $id_content) {
    toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");
    $('#loadingContetLoader').show();

    $.ajax({
        url: `${$base_url}${$url}`,
        type: 'GET',
        success: function ($response) {
            const $html = IsValidVal($response.datas) ? $response.datas : $response;
            $(`${$id_content}`).html($html);
        },
        complete: function () {
            $('#loadingContetLoader').hide();
            toastr.success("Berhasil mengambil data", "Success!");
        },
        error: function () {
            $('#loadingContetLoader').hide();
            toastr.error("Gagal mengambil data", "Kesalahan!");
        },
    });
}

async function ContentLoaderDataTable($url, $id_content, $table_coloumn) {
    // if ($.fn.DataTable.isDataTable($id_content)) {
    //     $(`${$id_content}`).DataTable().destroy();
    // }

    if (!$.fn.DataTable.isDataTable($id_content)) {
        await $(`${$id_content}`).DataTable({
            dom: '<"top flex justify-between"Bfr>t<"bottom"lp><"clear">', // Custom DOM layout
            buttons: [
                {
                    extend: 'excelHtml5', // Excel export button
                    text: '<span class="text-sm"><i class="fa-regular fa-file-excel"></i> Excel</span>',
                    className: 'm-0 p-0', // Customize button style
                    exportOptions: {
                        modifier: {
                            page: 'all' // Export all pages of the table, not just the current page
                        },
                        columns: ':visible' // Only export the visible columns
                    }
                },
                {
                    extend: 'colvis', // Excel export button
                    text: '<span class="text-sm"><i class="fa-solid fa-eye"></i> Show</span>',
                    className: 'm-0 p-0 w-fit', // Customize button style
                },
            ],
            pageLength: 5, // Set initial page length (entries per page)
            lengthMenu: [5, 10, 25, 50, 75, 100], // Provide options for entries per page
            columnDefs: [
                {
                    targets: -1, // Last column (Actions column)
                    visible: true // Ensure 'Actions' column is visible
                }
            ],
            // processing: true, // Aktifkan indikator processing bawaan DataTables
            // serverSide: true,
            ajax: {
                url: `${$url}`,
                dataSrc: "datas",
                type: "GET",
                beforeSend: function () {
                    toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");
                    $('#loadingContetLoader').show(); // Tampilkan custom loading
                },
                complete: function () {
                    toastr.success("Berhasil mengambil data", "Success!");
                    $('#loadingContetLoader').hide(); // Sembunyikan custom loading
                },
                error: function (xhr) {
                    toastr.error("Gagal mengambil data", "Kesalahan!");
                    $('#loadingContetLoader').hide();
                }
            },
            columns: $table_coloumn
        })
    }
}

function ContentLoaderDataTableV2($datas, $id_content, $table_coloumn) {
    toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");
    $('#loadingContetLoader').show();

    $(`${$id_content}`).DataTable({
        dom: '<"top flex justify-between"Bfr>t<"bottom"lp><"clear">', // Custom DOM layout
        buttons: [
            {
                extend: 'excelHtml5', // Excel export button
                text: '<span class="text-sm"><i class="fa-regular fa-file-excel"></i> Excel</span>',
                className: 'm-0 p-0', // Customize button style
                exportOptions: {
                    modifier: {
                        page: 'all' // Export all pages of the table, not just the current page
                    },
                    columns: ':visible' // Only export the visible columns
                }
            },
            {
                extend: 'colvis', // Excel export button
                text: '<span class="text-sm"><i class="fa-solid fa-eye"></i> Show</span>',
                className: 'm-0 p-0 w-fit', // Customize button style
            },
        ],
        pageLength: 5, // Set initial page length (entries per page)
        lengthMenu: [5, 10, 25, 50, 75, 100], // Provide options for entries per page
        columnDefs: [
            {
                targets: -1, // Last column (Actions column)
                visible: true // Ensure 'Actions' column is visible
            }
        ],
        data: $datas,
        columns: $table_coloumn
    });

    setTimeout(function () {
        $('#loadingContetLoader').hide();
        toastr.success("Berhasil mengambil data", "Success!");
    }, 1500);
}

async function ContentLoaderDataTableV3($url, $id_content, $table_coloumn) {
    if (!$.fn.DataTable.isDataTable(`${$id_content}`)) {
        await $(`${$id_content}`).DataTable({
            dom: '<"top flex justify-between"Bfr>t<"bottom"lp><"clear">', // Custom DOM layout
            buttons: [
                {
                    extend: 'excelHtml5', // Excel export button
                    text: '<span class="text-sm"><i class="fa-regular fa-file-excel"></i> Excel</span>',
                    className: 'm-0 p-0', // Customize button style
                    exportOptions: {
                        modifier: {
                            page: 'all' // Export all pages of the table, not just the current page
                        },
                        columns: ':visible' // Only export the visible columns
                    }
                },
                {
                    extend: 'colvis', // Excel export button
                    text: '<span class="text-sm"><i class="fa-solid fa-eye"></i> Show</span>',
                    className: 'm-0 p-0 w-fit', // Customize button style
                },
            ],
            pageLength: 5, // Set initial page length (entries per page)
            lengthMenu: [5, 10, 25, 50, 75, 100], // Provide options for entries per page
            columnDefs: [
                {
                    targets: -1, // Last column (Actions column)
                    visible: true // Ensure 'Actions' column is visible
                }
            ],
            // processing: true, // Aktifkan indikator processing bawaan DataTables
            // serverSide: true,
            ajax: {
                url: `${$url}`,
                dataSrc: "datas",
                type: "GET",
                beforeSend: function () {
                    toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");
                    $('#loadingContetLoader').show(); // Tampilkan custom loading
                },
                complete: function () {
                    toastr.success("Berhasil mengambil data", "Success!");
                    $('#loadingContetLoader').hide(); // Sembunyikan custom loading
                },
                error: function (xhr) {
                    toastr.error("Gagal mengambil data", "Kesalahan!");
                    $('#loadingContetLoader').hide();
                }
            },
            columns: $table_coloumn
        })
    } else {
        $(`${$id_content}`).DataTable().ajax.reload();
    }
}

async function GetFromAPI($url) {
    return new Promise(async function (resolve, reject) {
        try {
            $('#loadingContetLoader').show();
            await fetch(`${$base_url}${$url}`).then(async function ($list) {
                $('#loadingContetLoader').hide();
                console.dir("success", $list);
                resolve(await $list.json());
            }).catch(function ($err) {
                $('#loadingContetLoader').hide();
                console.dir("error", $err);
                throw new Error($err);
            });
        } catch (err) {
            reject(err);
        }
    })
}

function IDRToDecimal($val) {
    return parseFloat($val.replace(/[^0-9.-]/g, ''))
}

function isnull($val) {
    return $val === null || $val === "null";
}

function isundefined($val) {
    return $val === undefined || $val === "undefined";
}

function empty($val) {
    if (typeof $val === "undefined" && isundefined($val)) {
        return true;
    } else if (typeof $val === "object" && isnull($val)) {
        return true;
    } else if (typeof $val === "object" && $val.length === 0) {
        return true;
    } else if (typeof $val === "object" && Object.keys($val).length === 0) {
        return true;
    } else if (typeof $val === "boolean" && $val === "") {
        return true;
    } else if (typeof $val === "number" && $val === "") {
        return true;
    } else if (typeof $val === "string" && $val === "") {
        return true;
    }

    return false;
}

function isset($val) {
    if (typeof $val === "undefined" && isundefined($val)) {
        return true;
    } else if (typeof $val === "object" && isnull($val)) {
        return true;
    } else if (typeof $val === "object" && $val.length > 0) {
        return true;
    } else if (typeof $val === "object" && Object.values($val).length > 0) {
        return true;
    } else if (typeof $val === "boolean" && $val) {
        return true;
    } else if (typeof $val === "number" && $val) {
        return true;
    } else if (typeof $val === "string" && $val) {
        return true;
    }

    return false;
}

function IsValidVal($val, $get = ["bool", "value", "equal"], $other = null, $key = null) {
    const $tmpVal = (isset($key) && isset($key) && $key != null ? (isset($val[$key]) ? $val[$key] : "") : (isset($val) ? $val : ""));

    if (isset($tmpVal)) {
        if ($get == "value") {
            if (isset($other) && $other != null) {
                return !empty($tmpVal) || $tmpVal == 0 ? $tmpVal : $other;
            } else {
                return !empty($tmpVal) || $tmpVal == 0 ? $tmpVal : "";
            }
        } else if (isset($other) && $other != null && $get == "equal") {
            return $tmpVal == $other;
        } else if (!empty($tmpVal)) {
            return true;
        } else {
            return false;
        }
    }

    return $get == "value" ? "" : false;
}

function LoadingInput($section, $elemnt) {
    if ($section == 'loading') {
        $(`#${$elemnt}_autocomplete_container div #search-icon`).hide();
        $(`#${$elemnt}_autocomplete_container div #loading-icon`).show();
    }

    if ($section == 'idle') {
        $(`#${$elemnt}_autocomplete_container div #search-icon`).show();
        $(`#${$elemnt}_autocomplete_container div #loading-icon`).hide();
    }
}

function LoginAjaxSection($postFormData) {
    $("._csrf-token").val($('meta[name="csrf-token"]').attr('content'));
    $(".csrf-token").val($('meta[name="csrf-token"]').attr('content'));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    $.ajax({
        url: `${$base_url}/login`,
        type: "POST",
        data: $postFormData,
        xhrFields: {
            withCredentials: true
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (callback) {
            console.dir('success', callback);
            toastr.success('berhasil login!', "Success!");

            setTimeout(() => {
                window.location.href = `${$base_url}/dashboard`;
            }, 1500);
        },
        error: function (callback) {
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
                    toastr.error(errors[key][0], "Kesalahan!");
                    $(`#err_${key}`).show();
                    $(`#err_${key} li`).html(errors[key][0]);
                }
            } else if (message || messages || errorInfo || validator) {
                const tmpMsg = (validator ? "input data tidak sesuai atau tidak boleh kosong" : (errorInfo ? errorInfo[2] : (messages ? messages : message)));
                toastr.error(tmpMsg, "Kesalahan!");
            }

            $("#loadingAjax").hide();
            $(".hideBtnProcess").show();

            Swal.fire({
                title: "Kesalahan!",
                text: message || messages || errorInfo || validator,
                icon: "error"
            });
        },
    });
}

function OpenLink($link, $options = ["self", "new", "popup"]) {
    if ($options == "self") {
        window.location.href = `${$base_url}${$link}`;
    }

    if ($options == "new") {
        window.open(`${$base_url}${$link}`, "_blank");
    }

    if ($options == "popup") {
        window.open(`${$base_url}${$link}`, "_blank", "width=800,height=600,top=100,left=100,resizable=yes,scrollbars=yes");
    }
}

function CreatePopUpModal($idContainer, $valModal, $formID, $formFuncOnSubmit, $slot, $btnTxt = ["Open Modal", "Simpan", "Reset", "Tutup"], $headContent = [], $footerContent = [], $ifSectionShow = { btn: true, funcBtnOpen: null }) {
    const { btn: $isBtnSection, funcBtnOpen } = $ifSectionShow;
    const $txtFuncBtnOpen = (IsValidVal(funcBtnOpen) ? `onclick="${funcBtnOpen}"` : "");
    const $htmlBtnOpen = `<span class="cursor-pointer inline-flex items-center px-4 py-2 bg-info border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-info focus:bg-info active:bg-info focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" @click="${$valModal} = true" ${$txtFuncBtnOpen}>${$btnTxt[0]}</span>`;
    let $htmlBtnSubmit = "";
    let $htmlBtnReset = "";
    let $htmlBtnClose = "";

    if ($isBtnSection) {
        $htmlBtnSubmit = `<span type="submit" class="inline-flex items-center px-4 py-2 bg-success border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-success focus:bg-success active:bg-success focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer" onclick="${$formFuncOnSubmit}">${$btnTxt[1]}</span>`;
        $htmlBtnReset = `<span type="reset" class="inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer hideBtnProcess ms-3">${$btnTxt[2]}</span>`;
        $htmlBtnClose = `<span class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 cursor-pointer" @click="${$valModal} = false">${$btnTxt[3]}</span>`;
    }

    const $htmlTxtHead = (IsValidVal($headContent, "bool", null, 0) ? `<h2 class="text-lg font-bold">${$headContent[0]}</h2>` : "");
    const $htmlTxtDescription = (IsValidVal($headContent, "bool", null, 1) ? `<div class="flex text-lg text-gray-800/50"><h3 class="mt-4">${$headContent[1]}</h3></div>` : "");
    const $htmlTxtFoot = (IsValidVal($footerContent, "bool", null, 0) ? `<div class="mt-6 flex justify-center"><p class="mt-4">${$footerContent[0]}</p></div>` : "");
    const $htmlSlot = (IsValidVal($slot) ? $slot : "");

    const $htmlForm = (IsValidVal($formID) ? `
    <div>
        <div class="mt-4">
            ${$htmlSlot}
        </div>

        <div class="mt-6 flex justify-end space-x-2">
            ${$htmlTxtFoot}

            ${$htmlBtnClose}

            ${$htmlBtnReset}

            ${$htmlBtnSubmit}
        </div>
    </div>
    ` : "");

    const html = `
    ${$htmlBtnOpen}

    <div class="modal_section">
        <div
            x-show="${$valModal}"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;"
        >
            <div class="bg-white w-full max-w-7xl mx-auto rounded-lg shadow-lg p-6 max-h-[80vh] overflow-y-auto" @click.away="${$valModal} = false" @keydown.escape.window="${$valModal} = false">
                <div class="flex justify-between items-center border-b pb-3">
                    ${$htmlTxtHead}
                    <span class="modal_section_close_btn" @click="${$valModal} = false" class="text-gray-500 hover:text-gray-700 text-xl cursor-pointer">
                        &times;
                    </span>
                </div>

                <!-- Konten Modal -->
                <div class="mt-4">
                    ${$htmlTxtDescription}
                    ${$htmlForm}
                </div>
            </div>
        </div>
    </div>
    `;

    $(`${$idContainer}`).html(html);
}

function Dropdown404Alpine($this, $target) {
    const $length = $(`li.list_${$target}`).length;
    const $404length = $(`li.list_${$target}`).filter(function() { return $(this).css('display') == 'none';}).length;

    // if ($404length === $length) {
    //     $(`#404_${$target}`).show();
    // } else {
    //     $(`#404_${$target}`).hide();
    // }
}

async function DropdownSelectAlpine($val = ["name", "id's"], $target) {
    $(`#${$target}`).val($val[0]);

    if (IsValidVal($val[1])) {
        $(`#id_${$target}`).val($val[1]);
    }
}

async function DropdownContentLoader($url, $target, $section = null) {
    await $.ajax({
        url: `${$base_url}${$url}`,
        type: 'GET',
        success: function ($response) {
            const $datas = IsValidVal($response.datas) ? $response.datas : $response;
            if (IsValidVal($datas) && $datas.length > 0) {
                let $html = ``;
                $datas.forEach(function ($list) {
                    const { type, postal_code } = $list;
                    const $tmpType = IsValidVal(type) && $section === "wilayah" ? `${type} ` : "";
                    const $tmpPostalCode = IsValidVal(postal_code) && $section === "wilayah" ? `<p><strong>Kode Pos: </strong>${postal_code}</p> ` : "";
                    const $txtDisplay = IsValidVal($section) && $section === "wilayah" ? `<p>${$tmpType}${$list.name}${$tmpPostalCode}</p>` : `${$list.name}`;

                    $html += `
                    <li @click="open = false" x-show="!search || '${$list.name}'.toLowerCase().includes(search.toLowerCase())" class="list_${$target} text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="DropdownSelectAlpine(['${$list.name}', ${$list.id }], '${$target}')">
                        ${$txtDisplay}
                    </li>
                    `;
                });
                $html += `<li id="404_${$target}" class="text-sm px-4 py-2 text-gray-500 hidden cursor-default" style="display: none !important">Data tidak ditemukan.</li>`;

                $(`#list_${$target}`).html($html);
            } else {
                $(`#list_${$target}`).html("");
            }
        }
    });
}

async function DropdownGetLoad($get, $from, $section = null, $searchForm = null) {
    const $formArray = $(`${$searchForm}`).serializeArray();
    const $localStorage = localStorage.getItem("search_params");

    const $tmpDropdownData = [];
    Object.values($formArray).forEach(function ($list) {
        const { name } = $list;
        if (IsValidVal($(`#id_${name}`).val()) && (name !== $get)) {
            $tmpDropdownData.push({ name: `id_${name}`, value: $(`#id_${name}`).val() });
        }
    });

    let $statusResult = true;
    const $searchParams = (IsValidVal($localStorage) ? JSON.parse($localStorage) : []);
    if (IsValidVal($localStorage)) {
        $searchParams.forEach(function ($list, $index) {
            const { name } = $list;
            if (name.includes("id_") && (name !== $get)) {
                if (JSON.stringify($list) != JSON.stringify($tmpDropdownData[$index])) {
                    $statusResult = false;
                    return;
                }
            }
        });
    }

    if (!$statusResult) {
        Object.values($formArray).forEach(function ($list) {
            const { name } = $list;
            if (IsValidVal($(`#id_${name}`).val()) && !name.includes("provinsi")) {
                $(`#${name}`).val("");
                $(`#id_${name}`).val("");
                return;
            }
        });
    }

    if (IsValidVal($tmpDropdownData)) {
        localStorage.setItem("search_params", JSON.stringify($tmpDropdownData));

        if ($tmpDropdownData.length != $searchParams.length || !$statusResult) {
            const $listID = [];
            Object.values($formArray).forEach(function ($list) {
                const { name, value } = $list;
                if (name.includes("id_") && IsValidVal(value) && (name !== $get)) {
                    $listID.push(`${name}=${value}`);
                }
            });

            const $params = IsValidVal($listID) && $listID.length > 0 ? $listID.join("&") : $listID;
            const $fxdParams = IsValidVal($params) ? `&${$params}` : "";
            await DropdownContentLoader(`/api/search?get_data=${$get}${$fxdParams}`, $get, $section);
        }
    }
}
