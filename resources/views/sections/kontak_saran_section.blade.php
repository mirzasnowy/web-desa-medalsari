{{-- resources/views/sections/kontak_saran_section.blade.php --}}
<section id="kontak-saran" class="section">
    <h2 class="section-title fade-in">Hubungi Kami / Beri Saran</h2>
    <div class="detail-container" style="text-align: left;">
        <p class="detail-description" style="text-align: center;">Punya pertanyaan atau saran untuk Desa Medalsari? Silakan isi formulir di bawah ini.</p>
        <form action="{{ route('kontak.submit') }}" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label for="nama" style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--text-color);">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--background-color); color: var(--text-color);">
            </div>
            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--text-color);">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--background-color); color: var(--text-color);">
            </div>
            <div style="margin-bottom: 20px;">
                <label for="subjek" style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--text-color);">Subjek:</label>
                <input type="text" id="subjek" name="subjek" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--background-color); color: var(--text-color);">
            </div>
            <div style="margin-bottom: 30px;">
                <label for="pesan" style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--text-color);">Pesan / Saran Anda:</label>
                <textarea id="pesan" name="pesan" rows="6" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--background-color); color: var(--text-color); resize: vertical;"></textarea>
            </div>
            <button type="submit" class="cta-button" style="width: 100%; padding: 15px; font-size: 1.2em;">Kirim Pesan</button>
        </form>
    </div>
</section>