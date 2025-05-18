@foreach ($peminjaman->sesi as $sesi)
    <div class="border p-3 mb-2 rounded shadow-sm">
        <strong>{{ $sesi->tanggal_mulai_sesi }} - {{ $sesi->tanggal_selesai_sesi }}</strong><br>
        Status:
        <form action="{{ route('ubah_status_sesi', $sesi->id_sesi_pkp) }}" method="POST" style="display: inline;">
            @csrf
            @method('PUT')
            <select name="status" onchange="this.form.submit()">
                <option value="belum" {{ $sesi->status_pengembalian == 'belum' ? 'selected' : '' }}>Belum</option>
                <option value="sudah" {{ $sesi->status_pengembalian == 'sudah' ? 'selected' : '' }}>Sudah</option>
                <option value="bermasalah" {{ $sesi->status_pengembalian == 'bermasalah' ? 'selected' : '' }}>Bermasalah</option>
            </select>
        </form>
        @if ($sesi->status_pengembalian == 'sudah')
            <span class="text-success">(Dikembalikan {{ \Carbon\Carbon::parse($sesi->tanggal_pengembalian)->format('d M Y H:i') }})</span>
        @elseif ($sesi->status_pengembalian == 'bermasalah')
            <span class="text-danger">(Perlu Ditindaklanjuti)</span>
        @endif
    </div>
@endforeach