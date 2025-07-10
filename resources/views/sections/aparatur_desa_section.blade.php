{{-- resources/views/sections/aparatur_desa_section.blade.php --}}
<section id="aparatur-desa" class="section">
    <h2 class="section-title fade-in">Aparatur Desa Medalsari</h2>
    @php
        $aparaturDesas = $aparaturDesas ?? [];
        if (empty($aparaturDesas)) {
            $aparaturDesas = [
                (object)['nama' => 'Bapak Kepala Desa', 'jabatan' => 'Kepala Desa', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567890'],
                (object)['nama' => 'Ibu Sekretaris', 'jabatan' => 'Sekretaris Desa', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567891'],
                (object)['nama' => 'Bapak Bendahara', 'jabatan' => 'Kaur Keuangan', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567892'],
                (object)['nama' => 'Ibu Kasi Pem.', 'jabatan' => 'Kasi Pemerintahan', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567893'],
                (object)['nama' => 'Bapak Kadus I', 'jabatan' => 'Kepala Dusun I', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567894'],
                (object)['nama' => 'Bapak Kadus II', 'jabatan' => 'Kepala Dusun II', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567895'],
            ];
        }
    @endphp 

    <div class="aparatur-grid">
        @forelse($aparaturDesas as $aparatur)
            <x-aparatur-card :aparatur="$aparatur" />
        @empty
            <div class="col-12 text-center">
                <p>Belum ada data aparatur desa.</p>
            </div>
        @endforelse
    </div>
    @if(count($aparaturDesas) > 0)
    <div class="text-center mt-5">
        <a href="{{ url('/aparatur-desa') }}" class="cta-button">Lihat Struktur Lengkap</a>
    </div>
    @endif
</section>