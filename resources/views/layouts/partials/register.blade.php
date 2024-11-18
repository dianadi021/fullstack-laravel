<x-card-box-shadow-layout>
    <form id="registerForm" onsubmit="submitForm('registerForm')">
        @csrf
        <input type="hidden" name="token" id="csrf-token" />

        <div id="clientRegist">
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Klinik<span class="text-red-500">*</span>
                </label>
                <x-text-input id="company_name" class="block mt-1 w-full check_form_client_register" type="text" name="company_name" autofocus />
                <ul class="hide_notif text-sm text-red-600 space-y-1 mt-2" id="err_company_name">
                    <li></li>
                </ul>
            </div>

            <div>
                <label for="id_provinsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Provinsi<span class="text-red-500">*</span>
                </label>
                <x-autocomplete-layout class="check_form_client_register" section="ssr-dropdown" get="provinsi" placeholder="Pilih provinsi..." />
            </div>

            <div>
                <label for="id_kabupaten" class="block text-sm font-medium text-gray-700 mb-2">
                    Kabupaten<span class="text-red-500">*</span>
                </label>
                <x-autocomplete-layout class="check_form_client_register" section="ssr-dropdown" get="kabupaten" placeholder="Pilih kabupaten..." onclick="DropdownGetLoad('kabupaten', 'provinsi', 'wilayah', '#registerForm')" />
            </div>

            <div>
                <label for="id_kecamatan" class="block text-sm font-medium text-gray-700 mb-2">
                    Kecamatan<span class="text-red-500">*</span>
                </label>
                <x-autocomplete-layout class="check_form_client_register" section="ssr-dropdown" get="kecamatan" placeholder="Pilih kecamatan..." onclick="DropdownGetLoad('kecamatan', 'kabupaten', 'wilayah', '#registerForm')" />
            </div>

            <div>
                <label for="id_kelurahan" class="block text-sm font-medium text-gray-700 mb-2">
                    Kelurahan<span class="text-red-500">*</span>
                </label>
                <x-autocomplete-layout class="check_form_client_register" section="ssr-dropdown" get="kelurahan" placeholder="Pilih kelurahan..." onclick="DropdownGetLoad('kelurahan', 'kecamatan', 'wilayah', '#registerForm')" />
            </div>
        </div>

        <div id="userRegist">
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap<span class="text-red-500">*</span>
                </label>
                <x-text-input id="fullname" class="block mt-1 w-full" type="text" name="fullname" :value="old('fullname')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username<span class="text-red-500">*</span>
                </label>
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email<span class="text-red-500">*</span>
                </label>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password<span class="text-red-500">*</span>
                </label>
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm Password<span class="text-red-500">*</span>
                </label>
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <p class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer"
                onclick="openSection('loginSection')">
                {{ __('Sudah terdaftar?') }}
            </p>

            <x-btn-customize-layout id="nextRegist" section="success" class="ms-4" onclick="registSection('userRegist')">
                {{ __('Lanjutkan') }}
            </x-btn-customize-layout>

            <x-secondary-button class="submitRegistSection ms-4" onclick="registSection('clientRegist')">
                {{ __('Kembali') }}
            </x-secondary-button>

            <x-btn-customize-layout class="submitRegistSection ms-4" section="primary">
                {{ __('Simpan') }}
            </x-btn-customize-layout>
        </div>
    </form>

    <script>
        $(document).ready(async function() {
            $("#userRegist").hide();
            $(".submitRegistSection").hide();
        });

        // FUNCTION ON CLICK ON CLICK START
        function registSection($sections) {
            if ($sections == 'clientRegist') {
                $(".submitRegistSection").hide();
                $("#userRegist").hide();
                $("#nextRegist").show();
                $("#clientRegist").show();
            }

            if ($sections == 'userRegist') {
                let isFilled = false;
                $(".check_form_client_register").each(function () {
                    if (!IsValidVal($(this).val())) {
                        $(this).focus();
                        toastr.error("Inputan harus diisi!", "Kesalahan!");
                        isFilled = false;
                        return false;
                    } else {
                        isFilled = true;
                        return true;
                    }
                })

                if (IsValidVal(isFilled)) {
                    $("#nextRegist").hide();
                    $("#clientRegist").hide();
                    $("#userRegist").show();
                    $(".submitRegistSection").show();
                }
            }
        }
        // FUNCTION ON CLICK ON CLICK END
    </script>
</x-card-box-shadow-layout>
