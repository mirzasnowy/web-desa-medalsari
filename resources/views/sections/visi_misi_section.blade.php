{{-- resources/views/sections/visi_misi_section.blade.php --}}
<section id="visi-misi" class="section">
    <h2 class="section-title fade-in">Visi & Misi Desa Medalsari</h2>
    <div class="info-block fade-in">
        <x-visi-misi-info-card type="visi" title="Visi Kami" content="Mewujudkan Desa Medalsari yang Maju, Sejahtera, Mandiri, dan Berbudaya melalui Tata Kelola Pemerintahan yang Baik dan Partisipasi Masyarakat." />
        
        <x-visi-misi-info-card 
            type="misi" 
            title="Misi Kami" 
            :content="[
                ['icon' => 'fa-graduation-cap', 'text' => 'Meningkatkan kualitas sumber daya manusia melalui pendidikan dan pelatihan berkelanjutan.'],
                ['icon' => 'fa-leaf', 'text' => 'Mengembangkan potensi ekonomi lokal, terutama sektor pertanian dan UMKM yang inovatif.'],
                ['icon' => 'fa-city', 'text' => 'Membangun infrastruktur desa yang memadai, modern, dan berkelanjutan untuk kesejahteraan bersama.'],
                ['icon' => 'fa-heartbeat', 'text' => 'Menciptakan lingkungan yang bersih, sehat, asri, dan lestari bagi seluruh warga.'],
                ['icon' => 'fa-gavel', 'text' => 'Memperkuat tata kelola pemerintahan desa yang transparan, akuntabel, dan partisipatif.'],
                ['icon' => 'fa-users', 'text' => 'Mendorong partisipasi aktif masyarakat dalam setiap aspek pembangunan desa.'],
                ['icon' => 'fa-hand-holding-heart', 'text' => 'Melestarikan dan mengembangkan kearifan lokal serta budaya desa sebagai identitas.'],
            ]" 
        />
    </div>
</section>