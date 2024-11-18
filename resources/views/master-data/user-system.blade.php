<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User System') }}
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
                            <div class="w-full sm:w-1/2 flex flex-wrap">
                                <form id="searchForm" onsubmit="search('submit')">
                                    <table class="w-full table-no-border">
                                        <tr class="align-baseline">
                                            <td>
                                                <label for="id_status" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Status
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td><x-autocomplete-layout section="ssr-dropdown" get="status" class="check_form_search" placeholder="Pilih status..." /></td>
                                        </tr>
                                        <tr class="align-baseline">
                                            <td>
                                                <label for="id_role" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Role
                                                </label>
                                            </td>
                                            <td>:</td>
                                            <td><x-autocomplete-layout section="ssr-dropdown" get="role" class="check_form_search" placeholder="Pilih role..." /></td>
                                        </tr>
                                    </table>

                                    <x-btn-customize-layout type="button" id="btnSearch" section="success" class="ms-4" onclick="search('submit')">
                                        {{ __('Cari') }}
                                    </x-btn-customize-layout>

                                    <x-btn-customize-layout type="reset" section="danger" class="ms-4" onclick="search('reset')">
                                        {{ __('Reset') }}
                                    </x-btn-customize-layout>
                                </form>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div id="user_container" x-cloak x-data="{ userModal: false }" @click.outside="userModal = false" @close.stop="userModal = false"></div>

                <div class="mt-6 overflow-x-auto">
                    <div class="tabs">
                        <div class="flex border-b">
                            <button id="header-roles" class="tab-header px-4 py-2 text-lg font-medium focus:outline-none bg-gray-100" data-tab-target="roles">
                                Roles
                            </button>
                            <button id="header-users" class="tab-header px-4 py-2 text-lg font-medium focus:outline-none" data-tab-target="users">
                                Users
                            </button>
                        </div>

                        <!-- Tab Contents -->
                        <div id="tab_roles" class="tab-content px-4 py-2 text-gray-700">
                            <table id="rolesTable" class="cek_datatables_content min-w-full table-auto table-text-center-number">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">{{ __('No') }}</th>
                                        <th class="px-4 py-2">{{ __('Nama') }}</th>
                                        <th class="px-4 py-2">{{ __('Level') }}</th>
                                        <th class="px-4 py-2">{{ __('Deskripsi') }}</th>
                                        <th class="px-4 py-2">{{ __('Aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="tab_users" class="tab-content hidden px-4 py-2 text-gray-700">
                            <table id="usersTable" class="cek_datatables_content min-w-full table-auto table-text-center-number">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">{{ __('No') }}</th>
                                        <th class="px-4 py-2">{{ __('Nama') }}</th>
                                        <th class="px-4 py-2">{{ __('Username') }}</th>
                                        <th class="px-4 py-2">{{ __('Email') }}</th>
                                        <th class="px-4 py-2">{{ __('Role') }}</th>
                                        <th class="px-4 py-2">{{ __('Status') }}</th>
                                        <th class="px-4 py-2">{{ __('Aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(async function() {
            (async function() {
                const $modalSlotContent = `
                <div class="mt-4">
                    <label for="nama">Nama *</label>
                    <input type="text" id="nama" name="nama" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                </div>
                `;
                await CreatePopUpModal("#user_container", "userModal", "userForm", ["simpanUser()"], $modalSlotContent, ["Tambah Data", "Simpan", "Reset", "Tutup"], ["Form Tambah Data", "User"], null, { btn: true });

                const $htmlParamsType = `
                    <li @click="open = false" x-show="!search || 'Roles'.toLowerCase().includes(search.toLowerCase())" class="list_params_type text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="DropdownSelectAlpine(['Roles', 'provinsi'], 'params_type')">
                        Roles
                    </li>
                    <li @click="open = false" x-show="!search || 'Users'.toLowerCase().includes(search.toLowerCase())" class="list_params_type text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="DropdownSelectAlpine(['Users', 'kabupaten'], 'params_type')">
                        Users
                    </li>
                `;

                $("#list_params_type").append($htmlParamsType);
            })();

            // Functions event onclick start
            $('.tab-header').on('click', async function() {
                const $target = $(this).data('tab-target');
                $('.tab-content').addClass('hidden');
                $(`#tab_${$target}`).removeClass('hidden');

                $('.tab-header').removeClass('bg-gray-100');
                $(this).addClass('bg-gray-100');

                $(`#${$target}Table`).show();
                const $coloumnsArray = tableFormat($target);

                await ContentLoaderDataTable(`/api/search?get_data=${$target}`, `#${$target}Table`, $coloumnsArray);
            });
            // Functions event onclick end
        });

        function tableFormat($target) {
            const $coloumnsArray = [{ data: null, render: (data, type, row, meta) => meta.row + 1 }];

            if ($target == 'roles') {
                $coloumnsArray.push({ data: 'name' }, { data: 'level' }, { data: 'description' });
            } else if ($target == 'users') {
                $coloumnsArray.push({ data: 'fullname' }, { data: 'username' }, { data: 'email' }, { data: 'role_name' });
                $coloumnsArray.push({
                    data: 'is_actived',
                    render: (data) =>
                        `
                        <div class="text-center">
                            <p class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ${data == 1 ? 'bg-success hover:bg-success focus:bg-success active:bg-success' : 'bg-danger hover:bg-danger focus:bg-danger active:bg-danger'}">
                                ${data == 1 ? 'Aktif' : 'Non-aktif'}
                            </p>
                        </div>
                        ` // Template class btn ada di file CustomizeBtnLayout.blade.php
                });
            }

            $coloumnsArray.push({
                data: null,
                orderable: false,
                searchable: false,
                render: (data) =>
                    `<div class='flex gap-1 justify-center'>
                        <button class='inline-flex items-center px-4 py-2 bg-warning border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-warning focus:bg-warning active:bg-warning focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>Edit</button>
                        <button class='inline-flex items-center px-4 py-2 bg-danger border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>Hapus</button>
                    </div>` // Template class btn ada di file CustomizeBtnLayout.blade.php
            });

            return $coloumnsArray;
        }

        // Functions event onclick start
        function simpanUser() {
            AllNotify("Data berhasil disimpan!", "success");
        }

        async function search($method) {
            if ($method == 'reset') {
                localStorage.removeItem("search_params");

                $(".check_form_search").each(function() {
                    $(this).val("");
                })

                $(".cek_datatables_content").each(function() {
                    if ($.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable().destroy();
                        $(this).hide();
                    }
                })
            }

            if ($method == 'submit') {
                const $formArray = $("#searchForm").serializeArray();

                let $getData = '';
                const $listID = [];
                Object.values($formArray).forEach(function($list) {
                    const { name, value                     } = $list;
                    if (name.includes("id_") && !name.includes("params_type") && IsValidVal(value)) {
                        $listID.push(`${name}=${value}`);
                    }
                    if (name.includes("params_type") && IsValidVal(value)) {
                        $getData = `${value}`;
                    }
                });

                const { id_client: $id_client } = @json(session('user_login'));
                if (IsValidVal($id_client)) {
                    $listID.push(`id_client=${$id_client}`);
                }

                const $target = IsValidVal($listID) ? $listID[$listID.length - 1].replace("id_", "").split("=")[0] : null;
                const $params = IsValidVal($listID) && $listID.length > 1 ? $listID.join("&") : $listID;
                const $coloumnsArray = tableFormat($getData);

                $('.tab-header').each(function() {
                    $('.tab-content').addClass('hidden');
                    $(`#tab_${$getData}`).removeClass('hidden');

                    $('.tab-header').removeClass('bg-gray-100');
                    $(`#header-${$getData}`).addClass('bg-gray-100');
                });

                if ($.fn.DataTable.isDataTable(`#${$getData}Table`)) {
                    $(`#${$getData}Table`).DataTable().destroy();
                }

                $(`#${$getData}Table`).show();
                await ContentLoaderDataTable(`/api/search?get_data=${$getData}&${$params}`, `#${$getData}Table`, $coloumnsArray);
            }
        }
        // Functions event onclick end
    </script>
</x-dynamic-layout>
