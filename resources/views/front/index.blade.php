<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLN</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logos/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 dark:bg-[#08080a]">
    <nav class="border-gray-200 bg-white shadow dark:bg-[#19191c]">
        <div class="mx-auto flex max-w-screen-xl flex-wrap items-center justify-between p-4">
            <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('assets/logos/logo.png') }}" class="h-8" alt="Logo PLN" />
            </a>
        </div>
    </nav>

    <div class="container mx-auto mt-10 max-w-lg rounded-lg bg-white p-6 shadow-lg dark:bg-[#19191c]">
        <h1 class="mb-6 text-center text-2xl font-bold dark:text-white">Pencarian Tagihan Listrik</h1>

        <form action="{{ route('pemakaian.index') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="no_kontrol" class="block font-medium text-gray-700 dark:text-gray-200">No. Kontrol</label>
                <input type="number" name="no_kontrol" id="no_kontrol" required
                    class="mt-1 w-full rounded border p-2 focus:outline-none focus:ring focus:ring-[#a5dde4] dark:border-gray-700 dark:bg-[#19191c] dark:text-white"
                    min="0" inputmode="numeric" placeholder="Masukkan No. Kontrol">

            </div>

            <div>
                <label for="tahun" class="block font-medium text-gray-700 dark:text-gray-200">Tahun</label>
                <select name="tahun" id="tahun" required
                    class="mt-1 w-full rounded border p-2 focus:outline-none focus:ring focus:ring-[#a5dde4] dark:border-gray-700 dark:bg-[#19191c] dark:text-white">
                    @foreach ([2025, 2026, 2027] as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="bulan" class="block font-medium text-gray-700 dark:text-gray-200">Bulan</label>
                <select name="bulan" id="bulan" required
                    class="mt-1 w-full rounded border p-2 focus:outline-none focus:ring focus:ring-[#a5dde4] dark:border-gray-700 dark:bg-[#19191c] dark:text-white">
                    @foreach (range(1, 12) as $bulan)
                        <option value="{{ $bulan }}">
                            {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="w-full rounded bg-[#00a4ba] py-2 font-semibold text-white shadow hover:bg-[#318893]">
                Cari
            </button>
        </form>

        @if ($pemakaian)
            <div class="mt-6 rounded bg-green-100 p-4 shadow dark:bg-[#1e2d25] dark:text-white">
                <h3 class="mb-2 text-lg font-bold">Hasil Pencarian</h3>
                <p><strong>No. Kontrol:</strong> {{ $pemakaian->no_kontrol }}</p>
                <p><strong>Tahun:</strong> {{ $pemakaian->tahun }}</p>
                <p><strong>Bulan:</strong> {{ $pemakaian->bulan }}</p>
                <p><strong>Jumlah Pemakaian:</strong> {{ $pemakaian->jumlah_pakai }} kWh</p>
                <p><strong>Total Bayar:</strong> Rp {{ number_format($pemakaian->total_bayar, 0, ',', '.') }}</p>
            </div>
        @elseif ($pemakaian === null && request()->isMethod('post'))
            <div class="mt-6 rounded bg-red-100 p-4 shadow dark:bg-[#2f2224] dark:text-white">
                <h3 class="mb-2 text-lg font-bold">Hasil Pencarian</h3>
                <p>Data tidak ditemukan.</p>
            </div>
        @endif

    </div>
</body>

</html>
