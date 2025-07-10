{{-- resources/views/components/visi_misi_info_card.blade.php --}}
@props(['type', 'title', 'content'])

<div class="visi-misi-card" style="background-color: var(--background-color); border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px;">
    <h3>
        @if($type == 'visi')
            <i class="fas fa-eye" style="color: var(--primary-color);"></i>
        @else
            <i class="fas fa-lightbulb" style="color: var(--accent-color);"></i>
        @endif
        {{ $title }}
    </h3>
    @if($type == 'visi')
        <p><strong>"{!! $content !!}"</strong></p>
        <p style="text-align: center; font-style: italic; color: var(--secondary-text-color);">"Visi adalah bintang penuntun yang mengarahkan semua langkah kita menuju masa depan yang lebih baik."</p>
    @else
        <ul class="misi-list">
            @foreach($content as $misi)
                <li>
                    <i class="fas {{ $misi['icon'] ?? 'fa-check' }}" style="color: var(--primary-color-dark);"></i>
                    {{ $misi['text'] }}
                </li>
            @endforeach
        </ul>
    @endif
</div>