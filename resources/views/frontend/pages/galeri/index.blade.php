@extends('frontend.layouts.main')

@section('content')
    <div class="content-offset">

        <section class="mt-10">
            <div class="max-w-7xl mx-auto px-4">

                <h1 class="text-3xl font-bold mb-10 text-center">
                    Galeri Desa
                </h1>

                {{-- SKELETON LOADING --}}
                <div id="skeleton" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="animate-pulse">
                            <div class="w-full h-40 bg-gray-300 rounded-xl"></div>
                            <div class="h-4 bg-gray-300 rounded mt-3 w-3/4"></div>
                        </div>
                    @endfor
                </div>

                {{-- DATA --}}
                <div id="galeriContent" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">

                    @forelse ($galeri as $g)
                        <a href="{{ route('galeri.show', $g['slug']) }}" class="group block">
                            <div class="overflow-hidden rounded-xl shadow hover:shadow-lg transition">
                                <img src="{{ asset($g['image']) }}"
                                    class="w-full h-40 object-cover group-hover:scale-110 transition duration-500">
                            </div>

                            <h3 class="mt-3 font-semibold text-gray-800 group-hover:text-green-600">
                                {{ $g['title'] }}
                            </h3>
                        </a>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-10">
                            Belum ada data galeri.
                        </div>
                    @endforelse

                </div>

            </div>
        </section>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.getElementById("skeleton").classList.add("hidden");
                document.getElementById("galeriContent").classList.remove("hidden");
            }, 700);
        });
    </script>
@endsection
