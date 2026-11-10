{{--
    components/kondisi-badge.blade.php

    Badge Bootstrap untuk kondisi fisik buku bekas (Bagian 7.7:
    "Manajemen Kondisi Buku Bekas").

    Penggunaan:
        @include('components.kondisi-badge', ['buku' => $buku])

    Memanfaatkan accessor Buku::getKondisiLabelAttribute() dan
    Buku::getKondisiBadgeAttribute() yang sudah didefinisikan di Model.
--}}
<span class="badge bg-{{ $buku->kondisi_badge }}">
    {{ $buku->kondisi_label }}
</span>
