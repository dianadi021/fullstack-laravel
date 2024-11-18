@if ($section == 'jquery' && !empty($get))
    @if ($get == 'provinsi')
        <div id="provinsi_autocomplete_container" class="relative">
            <div class="flex items-center">
                <x-text-input
                    {{ $attributes->merge(['id' => 'provinsi', 'name' => 'provinsi', 'type' => 'text', 'class' => 'border rounded-lg w-full px-3 py-2 focus:outline-none text-sm']) }} />
                <x-text-input {{ $attributes->merge(['id' => 'id_provinsi', 'name' => 'id_provinsi', 'type' => 'hidden']) }} />
                <span id="search-icon" class="absolute right-3">
                    <i class="fas fa-search text-gray-500"></i>
                </span>
                <span id="loading-icon" class="absolute right-3 hidden">
                    <i class="fas fa-spinner fa-spin text-gray-500"></i>
                </span>
            </div>
        </div>
    @endif
    @if ($get == 'kabupaten')
        <div id="kabupaten_autocomplete_container" class="relative">
            <div class="flex items-center">
                <x-text-input
                    {{ $attributes->merge(['id' => 'kabupaten', 'name' => 'kabupaten', 'type' => 'text', 'class' => 'border rounded-lg w-full px-3 py-2 focus:outline-none text-sm']) }} />
                <x-text-input {{ $attributes->merge(['id' => 'id_kabupaten', 'name' => 'id_kabupaten', 'type' => 'hidden']) }} />
                <span id="search-icon" class="absolute right-3">
                    <i class="fas fa-search text-gray-500"></i>
                </span>
                <span id="loading-icon" class="absolute right-3 hidden">
                    <i class="fas fa-spinner fa-spin text-gray-500"></i>
                </span>
            </div>
        </div>
    @endif
    @if ($get == 'kecamatan')
        <div id="kecamatan_autocomplete_container" class="relative">
            <div class="flex items-center">
                <x-text-input
                    {{ $attributes->merge(['id' => 'kecamatan', 'name' => 'kecamatan', 'type' => 'text', 'class' => 'border rounded-lg w-full px-3 py-2 focus:outline-none text-sm']) }} />
                <x-text-input {{ $attributes->merge(['id' => 'id_kecamatan', 'name' => 'id_kecamatan', 'type' => 'hidden']) }} />
                <span id="search-icon" class="absolute right-3">
                    <i class="fas fa-search text-gray-500"></i>
                </span>
                <span id="loading-icon" class="absolute right-3 hidden">
                    <i class="fas fa-spinner fa-spin text-gray-500"></i>
                </span>
            </div>
        </div>
    @endif
    @if ($get == 'kelurahan')
        <div id="kelurahan_autocomplete_container" class="relative">
            <div class="flex items-center">
                <x-text-input
                    {{ $attributes->merge(['id' => 'kelurahan', 'name' => 'kelurahan', 'type' => 'text', 'class' => 'border rounded-lg w-full px-3 py-2 focus:outline-none text-sm']) }} />
                <x-text-input {{ $attributes->merge(['id' => 'id_kelurahan', 'name' => 'id_kelurahan', 'type' => 'hidden']) }} />
                <span id="search-icon" class="absolute right-3">
                    <i class="fas fa-search text-gray-500"></i>
                </span>
                <span id="loading-icon" class="absolute right-3 hidden">
                    <i class="fas fa-spinner fa-spin text-gray-500"></i>
                </span>
            </div>
        </div>
    @endif
    @if ($get == 'golongan_darah')
        <div id="golongan_darah_autocomplete_container" class="relative">
            <div class="flex items-center">
                <x-text-input
                    {{ $attributes->merge(['id' => 'golongan_darah', 'name' => 'golongan_darah', 'type' => 'text', 'class' => 'border rounded-lg w-full px-3 py-2 focus:outline-none text-sm']) }} />
                <x-text-input {{ $attributes->merge(['id' => 'id_golongan_darah', 'name' => 'id_golongan_darah', 'type' => 'hidden']) }} />
                <span id="search-icon" class="absolute right-3">
                    <i class="fas fa-search text-gray-500"></i>
                </span>
                <span id="loading-icon" class="absolute right-3 hidden">
                    <i class="fas fa-spinner fa-spin text-gray-500"></i>
                </span>
            </div>
        </div>
    @endif
@endif

@if ($section == 'ssr-dropdown' && !empty($get))
    @php
        $listNoAComplete = [
            'provinsi',
            'golongan_darah',
            'gender',
            'unit'
        ];
    @endphp

    @if ($get == 'provinsi')
        <div x-data="{ open: false, search: '' }" @click.outside="open = false" @close.stop="open = false">
            <div id="provinsi_autocomplete_container" class="relative">
                <div class="flex items-center">
                    <x-text-input @click="open = !open"
                        {{ $attributes->merge(['id' => 'provinsi', 'name' => 'provinsi', 'type' => 'text', 'class' => 'border rounded-lg w-full px-3 py-2 focus:outline-none text-sm cursor-pointer']) }} readonly />
                    <x-text-input {{ $attributes->merge(['id' => 'id_provinsi', 'name' => 'id_provinsi', 'type' => 'hidden']) }} />
                    <button type="button" @click="open = !open" class="absolute inset-y-0 right-0 flex items-center px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                style="display: none;" class="relative z-10">
                <div class="absolute z-50 mt-1 bg-white border border-gray-300 rounded-md shadow-lg w-full">
                    <x-autocomplete-layout type="button" section="" get="" x-model="search" type="text" placeholder="Cari provinsi..." @input="Dropdown404Alpine(this, 'provinsi')" />
                    <ul id="list_provinsi" class="absolute z-50 mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-56 overflow-auto w-full">
                        @if (isset($listProvinsi) && !empty($listProvinsi))
                            @foreach ($listProvinsi as $key => $list)
                                <li @click="open = !open" x-show="!search || '{{ $list->name }}'.toLowerCase().includes(search.toLowerCase())" class="list_provinsi text-nowrap text-sm px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="DropdownSelectAlpine(['{{ $list->name }}', {{ $list->id }}], 'provinsi')">
                                    {{ $list->name }}
                                </li>
                            @endforeach

                            <li id="404_provinsi" class="text-sm px-4 py-2 text-gray-500 hidden cursor-default" style="display: none !important">
                                Data tidak ditemukan.
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($get == 'golongan_darah')
        <select {{ $attributes->merge([]) }} class="w-full px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-700 hover:bg-gray-100 transition-all duration-200">
            <option value="" selected disabled>Pilih Opsi...</option>
            @if (isset($listGoldar) && !empty($listGoldar))
                @foreach ($listGoldar as $key => $list)
                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                @endforeach
            @endif
        </select>
    @endif

    @if ($get == 'gender')
        <select {{ $attributes->merge([]) }} class="w-full px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-700 hover:bg-gray-100 transition-all duration-200">
            <option value="" selected disabled>Pilih Opsi...</option>
            @if (isset($listGender) && !empty($listGender))
                @foreach ($listGender as $key => $list)
                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                @endforeach
            @endif
        </select>
    @endif

    @if ($get == 'unit')
        <select {{ $attributes->merge([]) }} class="w-full px-4 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-700 hover:bg-gray-100 transition-all duration-200">
            <option value="" selected disabled>Pilih Opsi...</option>
            @if (isset($listUnit) && !empty($listUnit))
                @foreach ($listUnit as $key => $list)
                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                @endforeach
            @endif
        </select>
    @endif

    @if (isset($get) && !empty($get) && !in_array($get, $listNoAComplete))
        @php
            $idGet = "id_$get";
        @endphp

        <div x-data="{ open: false, search: '' }" @click.outside="open = false" @close.stop="open = false">
            <div id="autocomplete_container" class="relative">
                <div class="flex items-center">
                    <x-text-input @click="open = !open"
                        {{ $attributes->merge(['id' => $get, 'name' => $get, 'type' => 'text', 'class' => 'border rounded-lg w-full px-3 py-2 focus:outline-none text-sm cursor-pointer']) }} readonly />
                    <x-text-input {{ $attributes->merge(['id' => $idGet, 'name' => $idGet, 'type' => 'hidden']) }} />
                    <button type="button" @click="open = !open" class="absolute inset-y-0 right-0 flex items-center px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                style="display: none;" class="relative z-10">
                <div class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg w-full">
                    <x-autocomplete-layout section="" get="" x-model="search" type="text" placeholder="Cari {{ $get }}..." @input="Dropdown404Alpine(this, '{{ $get }}')" />
                    <ul id="list_{{ $get }}" class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-56 overflow-auto w-full">
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endif

@if (empty($section))
    <div id="autocomplete_container" class="relative">
        <div class="flex items-center">
            <x-text-input
                {{ $attributes->merge(['type' => 'text', 'class' => 'border rounded-lg w-full px-3 py-2 focus:outline-none text-sm']) }} />
            <span id="search-icon" class="absolute right-3">
                <i class="fas fa-search text-gray-500"></i>
            </span>
            <span id="loading-icon" class="absolute right-3 hidden">
                <i class="fas fa-spinner fa-spin text-gray-500"></i>
            </span>
        </div>
    </div>
@endif
