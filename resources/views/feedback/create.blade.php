<!DOCTYPE html>
<html lang="id">
<head>
            <style>
            .splash-bg {
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: #17687a;
                z-index: 50;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                transition: transform 1s cubic-bezier(.68,-0.55,.27,1.55), opacity 0.7s;
            }
            .splash-bg.splash-slide {
                transform: translateY(-100vh);
                opacity: 0;
            }
            .pln-logo {
                width: 220px;
                height: 220px;
                background: #ffe600;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                position: relative;
                margin-bottom: 24px;
            }
            .pln-light {
                position: absolute;
                left: 50%;
                top: 120px;
                transform: translateX(-50%);
                width: 32px;
                height: 80px;
                background: linear-gradient(180deg, #ffe600 0%, #ffe600 60%, #fff200 100%);
                border-radius: 16px 16px 8px 8px;
                box-shadow: 0 0 24px 8px #ffe60099;
                opacity: 0;
                z-index: 2;
                transition: top 1s cubic-bezier(.68,-0.55,.27,1.55), opacity 0.5s;
            }
            .pln-light.active {
                top: 40px;
                opacity: 1;
            }
            .pln-icon {
                width: 120px;
                height: 120px;
                z-index: 3;
            }
            .pln-text {
                font-size: 2.5rem;
                font-weight: bold;
                color: #13b3e6;
                letter-spacing: 0.2em;
                margin-top: 12px;
                z-index: 3;
            }
            .splash-hide {
                opacity: 0;
                pointer-events: none;
            }
            </style>
        <style>
        .select2-container--default .select2-selection--single {
            height: 48px !important;
            padding: 8px 16px;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            font-size: 1rem;
            background: #fff;
            box-sizing: border-box;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px !important;
            color: #374151;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px !important;
            right: 8px;
        }
        .select2-container { width: 100% !important; }
        </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/storage/pln-logo.png">
    <title>Feedback Implementasi Inovasi - PLN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $("select[name='unit_id']").select2({width:'100%', placeholder:'Ketik sendiri atau cari nama unit'});
        $("select[name='inovasi_id']").select2({width:'100%', placeholder:'Ketik sendiri atau cari nama inovasi'});
        $("select[name='lama_implementasi']").select2({width:'100%', tags:true, placeholder:'Ketik sendiri atau pilih lama implementasi (bulan)', allowClear:true});

        // Focus input on dropdown open for all select2
        $("select[name='unit_id'], select[name='inovasi_id'], select[name='lama_implementasi']").on('select2:open', function(e) {
            setTimeout(function() {
                let searchField = $('.select2-container--open .select2-search__field');
                if (searchField.length) searchField[0].focus();
            }, 0);
        });

        // Only allow integer for lama_implementasi if user types
        $("select[name='lama_implementasi']").on('change', function(e) {
            var val = $(this).val();
            if (val && isNaN(val)) {
                alert('Lama implementasi harus berupa angka (bulan).');
                $(this).val('').trigger('change');
            }
        });

        // Fix star rating click: make SVG or label clickable and update radio, and update star color
        $(document).on('click', '.star-rating-group label, .star-rating-group label svg', function(e) {
            var $label = $(this).is('label') ? $(this) : $(this).closest('label');
            var $radio = $label.find('input[type=radio]');
            $radio.prop('checked', true).trigger('change').trigger('input');
            $radio[0] && $radio[0].click && $radio[0].click();

            // Update star color
            var group = $label.closest('.star-rating-group');
            var name = $radio.attr('name');
            var val = parseInt($radio.val());
            group.find('label').each(function(idx) {
                var $svg = $(this).find('svg');
                if (idx < val) {
                    $svg.removeClass('text-gray-300').addClass('text-yellow-400');
                } else {
                    $svg.removeClass('text-yellow-400').addClass('text-gray-300');
                }
            });
        });

        // On page load, if old value exists, color stars
        $('.star-rating-group').each(function() {
            var group = $(this);
            var checked = group.find('input[type=radio]:checked');
            if (checked.length) {
                var val = parseInt(checked.val());
                group.find('label').each(function(idx) {
                    var $svg = $(this).find('svg');
                    if (idx < val) {
                        $svg.removeClass('text-gray-300').addClass('text-yellow-400');
                    } else {
                        $svg.removeClass('text-yellow-400').addClass('text-gray-300');
                    }
                });
            }
        });
    });
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #0e7490 0%, #164e63 100%);
            min-height: 100vh;
        }
        .lightning-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M40 10 L50 40 L45 40 L55 70 L40 50 L45 50 Z' fill='%23fbbf24' opacity='0.1'/%3E%3C/svg%3E");
            background-size: 100px 100px;
        }
    </style>
</head>
<body class="lightning-bg">
                <!-- Splash screen restored -->
                <div id="splash" class="splash-bg">
                    <img src="/storage/pln-logo.png" alt="PLN Logo" style="width:340px;height:340px;object-fit:contain;">
                </div>
        <!-- Splash screen removed: form and header show immediately -->
    <!-- Header at the very top -->
    <div class="w-full bg-white rounded-b-2xl shadow-xl flex flex-col sm:flex-row items-center justify-between gap-2 px-2 sm:px-8 py-4" style="position:fixed; top:0; left:0; right:0; z-index:40;">
        <img src="/storage/pln-horizontal.png" alt="PLN Logo" class="h-8 sm:h-10 w-auto object-contain mb-2 sm:mb-0 sm:mr-6">
        <h1 class="flex-1 text-center font-bold text-cyan-700 text-lg sm:text-2xl md:text-3xl leading-tight" style="font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif; letter-spacing:0.04em; margin:0;">
            Feedback Implementasi Inovasi
        </h1>
        <img src="/storage/danantara-logo.png" alt="Danantara" class="h-10 w-auto object-contain mt-2 sm:mt-0 sm:ml-6">
    </div>
    <div id="main-content" class="min-h-screen flex items-center justify-center p-2 sm:p-6" style="padding-top:110px; background: url('/storage/background.jpg') center center / cover no-repeat;">
        <div class="w-full max-w-3xl">

            <!-- Form -->
            <div class="bg-gray-50 rounded-t-2xl rounded-b-2xl p-2 sm:p-4 md:p-8 shadow-xl">
                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                        <script>
                        window.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                document.getElementById('splash').classList.add('splash-slide');
                            }, 1200);
                        });
                        </script>
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('nama') border-red-500 @enderror" 
                               placeholder="Nama" required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('nip') border-red-500 @enderror" 
                               placeholder="NIP" required>
                        @error('nip')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unit -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Unit</label>
                        <select name="unit_id" class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white @error('unit_id') border-red-500 @enderror" required data-placeholder="Ketik sendiri atau cari nama unit">
                            <option value="">Ketik sendiri atau cari nama unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Implementasi/Inovasi -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Implementasi/Inovasi</label>
                        <select name="inovasi_id" class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white @error('inovasi_id') border-red-500 @enderror" required data-placeholder="Ketik sendiri atau cari nama inovasi">
                            <option value="">Ketik sendiri atau cari nama inovasi</option>
                            @foreach($inovasis as $inovasi)
                                <option value="{{ $inovasi->id }}" {{ old('inovasi_id') == $inovasi->id ? 'selected' : '' }}>{{ $inovasi->nama_inovasi }}</option>
                            @endforeach
                        </select>
                        @error('inovasi_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lama Implementasi -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Lama Implementasi/Inovasi</label>
                        <select name="lama_implementasi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white @error('lama_implementasi') border-red-500 @enderror" required data-placeholder="Ketik sendiri atau pilih lama implementasi (bulan)">
                            <option value="">Ketik sendiri atau pilih lama implementasi (bulan)</option>
                            <option value="1" {{ old('lama_implementasi') == 1 ? 'selected' : '' }}>1 Bulan</option>
                            <option value="3" {{ old('lama_implementasi') == 3 ? 'selected' : '' }}>3 Bulan</option>
                            <option value="6" {{ old('lama_implementasi') == 6 ? 'selected' : '' }}>6 Bulan</option>
                            <option value="12" {{ old('lama_implementasi') == 12 ? 'selected' : '' }}>12 Bulan</option>
                            @if(old('lama_implementasi') && !in_array(old('lama_implementasi'), [1,3,6,12]))
                                <option value="{{ old('lama_implementasi') }}" selected>{{ old('lama_implementasi') }} Bulan</option>
                            @endif
                        </select>
                        @error('lama_implementasi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hasil Implementasi -->
                    <div class="space-y-4">
                        <label class="block text-gray-700 font-medium mb-4">Hasil Implementasi</label>
                        <!-- Rating Kemudahan -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                            <span class="text-gray-700">Kemudahan Penggunaan</span>
                            <div class="flex space-x-2 star-rating-group">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating_kemudahan" value="{{ $i }}" class="hidden peer" required>
                                        <svg class="w-8 h-8 text-gray-300 hover:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <!-- Rating Kesesuaian -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                            <span class="text-gray-700">Kesesuaian Dengan kebutuhan Lapangan</span>
                            <div class="flex space-x-2 star-rating-group">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating_kesesuaian" value="{{ $i }}" class="hidden peer" required>
                                        <svg class="w-8 h-8 text-gray-300 hover:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <!-- Rating Keandalan -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                            <span class="text-gray-700">Keandalan/Stabilitas Alat</span>
                            <div class="flex space-x-2 star-rating-group">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating_keandalan" value="{{ $i }}" class="hidden peer" required>
                                        <svg class="w-8 h-8 text-gray-300 hover:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Any Feedback -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Any Feedback</label>
                        <textarea name="feedback" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent resize-none"
                                  placeholder="Feedback Anda...">{{ old('feedback') }}</textarea>
                    </div>

                    <!-- Saran -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Saran Untuk Pengembangan Selanjutnya</label>
                        <textarea name="saran" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent resize-none"
                                  placeholder="Manfaat untuk perkembangan">{{ old('saran') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center pt-4">
                        <button type="submit" 
                                class="w-full sm:w-auto px-8 sm:px-12 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg shadow-lg transition duration-200 transform hover:scale-105">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>