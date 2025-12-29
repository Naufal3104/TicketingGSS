@extends('app')
@section('title', 'Public Calendar')

@section('content')
<div class="bg-gray-100 flex-1 p-6 md:mt-16 grid grid-cols-8 h-screen">

    {{-- BAGIAN SIDEBAR (Kiri - Form Input Jadwal) --}}
    <div class="col-span-2 bg-white border rounded p-6 mr-8 h-full shadow-sm flex flex-col overflow-y-auto">

        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Tambah Jadwal</h3>
            <p class="text-xs text-gray-500">Menambah data langsung ke Google Calendar.</p>
        </div>

        {{--
                FORMULIR KE CONTROLLER
                Pastikan Anda memiliki Route::post('/calendar/store', [CalendarController::class, 'store'])->name('calendar.store');
            --}}
        <form action="{{ route('calendar.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Kegiatan</label>
                <input type="text" name="title" required
                    class="w-full p-2 border rounded text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition duration-200"
                    placeholder="Contoh: Rapat Mingguan">
            </div>

            <div class="grid grid-cols-1 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Mulai</label>
                    <input type="datetime-local" name="start_date" required
                        class="w-full p-2 border rounded text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition duration-200">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Selesai</label>
                    <input type="datetime-local" name="end_date" required
                        class="w-full p-2 border rounded text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition duration-200">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3"
                    class="w-full p-2 border rounded text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition duration-200"
                    placeholder="Detail kegiatan..."></textarea>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition duration-200 text-sm font-bold flex justify-center items-center shadow-sm">
                <i class="fad fa-plus-circle mr-2"></i>
                Simpan ke Kalender
            </button>
        </form>

        <hr class="my-6" />

        <div class="bg-blue-50 border border-blue-100 rounded p-4">
            <div class="text-blue-600 font-bold flex items-center text-sm mb-1">
                <i class="fad fa-info-circle mr-2"></i>
                Status Sinkronisasi
            </div>
            <p class="text-xs text-blue-500 leading-relaxed">
                Data yang Anda input di atas akan diproses oleh server dan dikirim ke Google Calendar. Refresh
                halaman jika jadwal belum muncul di kanan.
            </p>
        </div>

        <div class="mt-auto pt-6 border-t text-center">
            <a href="https://calendar.google.com" target="_blank"
                class="text-xs text-indigo-500 hover:text-indigo-700 font-medium transition duration-200">
                Buka Google Calendar Asli <i class="fad fa-external-link-alt ml-1"></i>
            </a>
        </div>
    </div>

    {{-- BAGIAN UTAMA (Kanan - Tampilan Google Calendar Asli) --}}
    <div class="col-span-6 card flex flex-col bg-white rounded shadow-sm h-full overflow-hidden">

        {{--
                CATATAN PENTING UNTUK HARI LIBUR:
                Agar hari libur muncul, Anda harus mengedit URL di 'src' iframe di bawah ini.
                1. Buka Google Calendar -> Settings -> Integrate Calendar -> Customize.
                2. Centang "Holidays in Indonesia".
                3. Copy URL src yang baru dan tempel di bawah ini menggantikan yang lama.
            --}}
        <div class="flex-1 w-full h-full relative">
            <iframe
                src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Asia%2FJakarta&showPrint=0&src=bmF1ZmFuc3lhaDMxQGdtYWlsLmNvbQ&src=NDBmYTQ1NmU2NWFmZWU5OWY2ZGZmMjkyNjgxNDcyYzljYzNhZjZjMzZkNWUxMWYwOWM5YTM0YjU0NWFlZGRlZEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=c21rbjEtc2J5LnNjaC5pZF9jbGFzc3Jvb201ZTM1ZTYxNkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y2xhc3Nyb29tMTA4MjQwMTM5MjkzNjY1NjI0MzA0QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTExODI1NDg3MjI3NTgxODczOTc2QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTA3MzcyMDE4MTE5ODc5OTg3NjYwQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTEyMzE5NjA3MjA1Mjk5MjYxMDI5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE3NDI4ODIyNDA5MzY5MTU2ODgwQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb21iYmIwMTVhZEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y2xhc3Nyb29tMTExNTAyOTU1NzM3NDY0MTE5MzY5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAzODU4OTE0NjA3NTMwMzIzNTc5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=aWQuaW5kb25lc2lhbiNob2xpZGF5QGdyb3VwLnYuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=Y2xhc3Nyb29tMTAxMDQ0NDEyNDA4NzkzNzQ0OTU3QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE1NzU0ODA2MzA1NTY1NTA5Mjc3QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE2MTg3MTg2Nzg2MTA3ODk5MDM1QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTExNDU2NjQzNTg4MDE3MDQyNjc2QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAwMzQyMDI2NTk2MDMxNDc5MjU2QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTA4Mjg1MjIxMTg2NzA4MTc4NTQ3QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE1NzA2ODUwNjQxNDAwNzg0MTA3QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTEwMDcwNjk5MTUxNDIwMDI5NjA0QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE4MjE4OTc3MDI4NjQxMzE0NjI1QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTA2ODI4NjczODYwMTk2NzkzMjkyQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAxNzY4Mzk2Mzc0NDQ4NDkwMjcxQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAyMDkzMDYxNDI2MDg2MTM2MDk0QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTEzNzc2NDg1MzEyMDY1MTk0MDk0QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTEzOTAwMzA5MjM4MDMwMjI3MDgyQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTA5OTM0NDE0OTk2OTQyNTU0ODU0QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTA1OTUwNDc3MDgwODI4NTQ3ODk5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTA0NTY5NTY0ODgwMzUwNTQxMzU5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAzNDU1MDE0NDkwNjE5ODQzMjg2QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb200Y2U4ZTcwOUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y2xhc3Nyb29tMTAxMDU5NDY3NjcyNzUxODg4OTIyQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTExMDkzODQxOTk3NzMxMzE1MjA0QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTA0MDMxMTkzNzAzNzA2MjgzMjM0QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAwNzE3ODIzNjc4MDIyMDU5ODg1QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE4MjM1MzkxMDI1NDA1MzM0NjU5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAwMTYxMjQ4NDkxOTgxNjAyNjA5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE1NzIwNDIzMDY4NDg0Mjg0NjQxQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE3MzkxOTE1NDQzMzIyMjYxNDIxQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTA2ODY3OTAxMTA5NjM0Mjc2MTk4QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE0MTAwNTE5MDk2NTMxMTQ2NjM3QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAwNzA2NzYzNzM0OTg5NTkwMDg5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTE0Njk2MDcyODA4MTc2OTIzOTQ0QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb21lZTRiY2RlY0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=c21rbjEtc2J5LnNjaC5pZF9jbGFzc3Jvb20iOWFmNDFhNEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y2xhc3Nyb29tMTEyMTE3MDE2MTk0NzU4MjY0NjA1QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAyNzkyMTM3NzExNjgxODU3NDUzQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb202ODAzMDg1YUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y2xhc3Nyb29tMTAzOTY5Mzg1MDkzODMyMzE0NDAxQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTEwOTk5MzMzMTQ0MjczNzExMjUxQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAyMzQyMDc1MTQ3MzU1MjUwMDM4QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb20yNGMyODIyOUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y2xhc3Nyb29tMTEzNjE1MTY5MDYzMzA4ODc5NzEzQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y2xhc3Nyb29tMTAyNDk0MTg3ODg2MTA3NTE3ODIyQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039be5&color=%23795548&color=%231967d2&color=%231967d2&color=%23007b83&color=%23202124&color=%231967d2&color=%23007b83&color=%23137333&color=%23c26401&color=%23202124&color=%230b8043&color=%23137333&color=%23007b83&color=%23202124&color=%231967d2&color=%23007b83&color=%23137333&color=%23202124&color=%23007b83&color=%23202124&color=%23c26401&color=%237627bb&color=%23202124&color=%231967d2&color=%23137333&color=%231967d2&color=%231967d2&color=%231967d2&color=%23007b83&color=%231967d2&color=%231967d2&color=%23137333&color=%237627bb&color=%23007b83&color=%23b80672&color=%23137333&color=%23c26401&color=%23137333&color=%231967d2&color=%23c26401&color=%231967d2"
                style="border:solid 1px #777" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>

            {{-- Overlay Loading (Opsional, untuk estetika) --}}
            <div class="absolute top-4 right-4 z-10">
                <button onclick="document.querySelector('iframe').src = document.querySelector('iframe').src"
                    class="bg-white p-2 px-3 rounded-full shadow border border-gray-200 text-gray-600 hover:text-indigo-600 hover:border-indigo-200 text-xs font-semibold transition duration-200">
                    <i class="fad fa-sync mr-1"></i> Refresh
                </button>
            </div>
        </div>

    </div>
</div>
@endsection