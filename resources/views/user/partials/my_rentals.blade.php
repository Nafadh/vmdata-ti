<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex align-items-center gap-3">
        @php $me = auth()->user(); @endphp
        <img src="{{ $me && $me->avatar ? asset('storage/'.$me->avatar) : asset('images/default-avatar.png') }}" alt="avatar" width="50" height="50" class="rounded-circle" />
        <div>
            <strong>{{ $me->name ?? 'Saya' }}</strong>
            <div style="font-size:0.9rem; opacity:0.9;">Daftar VM yang Saya Sewa</div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-secondary">
                <tr class="text-center">
                    <th>#</th>
                    <th>Nama VM</th>
                    <th>Periode Sewa</th>
                    <th>Status Sewa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myRentals as $i => $rental)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $rental->vm->name ?? 'N/A' }}</strong>
                            @if(isset($rental->vm->description))
                                <br><small class="text-muted">{{ $rental->vm->description }}</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <small>
                                @php
                                    // Prefer VM rental datetime fields if present, otherwise use regular rental dates
                                    $hasStartTime = isset($rental->start_time) && $rental->start_time;
                                    $hasEndTime = isset($rental->end_time) && $rental->end_time;
                                @endphp
                                Mulai:
                                @if($hasStartTime)
                                    {{ optional($rental->start_time)->format('d/m/Y') }}
                                @else
                                    {{ optional($rental->start_date)->format('d/m/Y') ?? '-' }}
                                @endif
                                <br>
                                Selesai:
                                @if($hasEndTime)
                                    {{ optional($rental->end_time)->format('d/m/Y') }}
                                @else
                                    {{ optional($rental->end_date)->format('d/m/Y') ?? '-' }}
                                @endif
                            </small>
                        </td>
                        <td class="text-center">
                            @if($rental->status === 'active')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($rental->status === 'pending')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($rental->status === 'completed')
                                <span class="badge bg-secondary">Expired</span>
                            @else
                                <span class="badge bg-info">{{ ucfirst($rental->status) }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('vmrentals.show', $rental->id) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($rental->status === 'pending')
                                    <a href="{{ route('vmrentals.edit', $rental->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if(in_array($rental->status, ['pending','cancelled']))
                                    <form method="POST" action="{{ route('vmrentals.destroy', $rental->id) }}" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus permintaan sewa ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            <i class="fas fa-info-circle"></i> Anda belum menyewa VM apapun.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
