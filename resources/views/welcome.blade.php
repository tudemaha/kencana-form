<x-layouts.app title="Kencana Wisata | Tour & Travel">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 fixed w-full z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <a href="/" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                    <img src="/images/kencana-wisata.webp" alt="Kencana Wisata" class="h-10 w-auto object-contain">
                    <span class="font-bold text-xl text-primary">Kencana Wisata</span>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-primary transition-colors">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="pt-32 pb-16 sm:pt-40 sm:pb-24 lg:pb-32 overflow-hidden bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                <div class="lg:col-span-6 text-center lg:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-gray-900 mb-6 leading-tight">
                        Mitra Perjalanan <span class="text-primary">Anda</span> yang Terpercaya
                    </h1>
                    <p class="text-lg text-gray-600 mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Melayani berbagai paket perjalanan wisata domestik dan internasional. Kami hadir dengan totalitas, loyalitas, dan integritas untuk memberikan pengalaman tour yang berkesan bagi setiap kalangan.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="#tentang" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl bg-primary py-3.5 px-8 text-base font-bold text-white shadow-md hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-6 mt-16 lg:mt-0 relative">
                    <div class="absolute inset-0 bg-secondary rounded-[2.5rem] transform translate-x-4 translate-y-4 -z-10"></div>
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&q=80&w=800&h=600" alt="Bali Temple" class="rounded-[2.5rem] shadow-2xl object-cover w-full h-100 lg:h-125">
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="tentang" class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <h2 class="text-3xl font-bold text-primary mb-6">Tentang Kencana Wisata</h2>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-2 gap-12 text-gray-600 leading-relaxed text-lg">
                <div>
                    <p class="mb-6">
                        <strong class="text-gray-900 font-bold">Kencana Wisata Tour and Travel</strong> merupakan sebuah perusahaan yang bergerak di bidang jasa agen/biro perjalanan wisata yang didirikan pada tanggal 28 Juni 2000. Perusahaan ini juga sudah mengantongi izin operasional dan telah diakui secara sah oleh Dinas Pariwisata sebagai salah satu biro perjalanan wisata resmi di Pulau Bali.
                    </p>
                    <p>
                        Saat ini kami melayani paket perjalanan tour domestik dan internasional. Kami menyediakan berbagai bentuk perjalanan wisata, baik perseorangan maupun rombongan sehingga kami dapat memberikan pelayanan yang menyeluruh terhadap semua kalangan.
                    </p>
                </div>
                <div>
                    <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 h-full flex flex-col justify-center relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-secondary/20 rounded-full blur-2xl"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-tertiary mb-6 relative z-10">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.53a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        <p class="text-xl font-medium text-gray-900 mb-4 relative z-10">
                            "Totalitas, loyalitas, dan integritas adalah modal kami dalam menjalankan usaha ini."
                        </p>
                        <p class="text-base relative z-10">
                            Ditunjang dengan pengalaman yang profesional dalam jasa biro perjalanan, kami yakin perusahaan kami dapat menjadi mitra perjalanan Anda dengan pelayanan yang baik dan memuaskan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact & Footer -->
    <footer class="bg-primary pt-20 pb-10 text-white border-t-4 border-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-24 mb-16">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <img src="/images/kencana-wisata.webp" alt="Kencana Wisata" class="h-10 w-auto object-contain">
                        <span class="font-bold text-xl">Kencana Wisata</span>
                    </div>
                    <p class="text-white/70 text-sm leading-relaxed mb-6">
                        Biro perjalanan wisata resmi di Pulau Bali sejak tahun 2000. Melayani paket perjalanan tour domestik dan internasional.
                    </p>
                    <a href="/admin" class="inline-flex items-center gap-2 text-sm font-bold text-secondary hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        Akses Admin
                    </a>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-lg mb-6 text-secondary">Hubungi Kami</h3>
                    <ul class="space-y-4 text-white/80 text-sm">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-secondary shrink-0 mt-0.5">
                                <path d="M3 21l1.65-3.8a9 9 0 1 1 3.4 2.9L3 21" />
                                <path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0v1a5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1" />
                            </svg>
                            <div class="flex flex-col gap-1.5">
                                <a href="https://wa.me/6282144994968" target="_blank" rel="noopener noreferrer" class="hover:text-secondary transition-colors">+62 821 4499 4968 (WhatsApp)</a>
                                <a href="https://wa.me/6287761395248" target="_blank" rel="noopener noreferrer" class="hover:text-secondary transition-colors">+62 877 6139 5248 (WhatsApp)</a>
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-secondary shrink-0">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                            </svg>
                            <span>(0361) 9065467</span>
                        </li>
                    </ul>
                </div>

                <!-- Location & Socials -->
                <div>
                    <h3 class="font-bold text-lg mb-6 text-secondary">Lokasi & Sosial Media</h3>
                    <ul class="space-y-4 text-white/80 text-sm">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-secondary shrink-0 mt-0.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <a href="https://maps.app.goo.gl/hbwhJoYopnBU8Cib6" target="_blank" rel="noopener noreferrer" class="hover:text-secondary transition-colors">
                                Jl. Sari Dana I No. 5, Citraland Cargo,<br>Ubung Kaja, Denpasar
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-secondary shrink-0"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                            <a href="https://instagram.com/kencanawisatatour" target="_blank" rel="noopener noreferrer" class="hover:text-secondary transition-colors">
                                @kencanawisatatour
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/10 text-center text-white/50 text-xs flex flex-col sm:flex-row justify-between items-center gap-4">
                <p>&copy; {{ date('Y') }} Kencana Wisata Tour & Travel. Hak Cipta Dilindungi.</p>
                <p>Designed for Kencana Wisata</p>
            </div>
        </div>
    </footer>
</x-layouts.app>
