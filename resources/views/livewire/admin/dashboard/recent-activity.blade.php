<div wire:poll.5s="$refresh">

    {{--
        <style> ieu SENGAJA ditulis di jero root div (lain jadi sibling
        SAMEMEH-na) — Livewire ngan ngidinan HIJI root element per
        component; upami dijieun sibling, component ieu bisa "leungit"
        sanggeus sababaraha kali polling (kapendak di RingkasanKartu).
    --}}
    <style>
        @keyframes activity-item-in {
            from {
                opacity: 0;
                transform: translateY(-15%);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .activity-item-animated {
            animation: activity-item-in 500ms ease-out forwards;
        }
    </style>

    {{--
        wire:key dumasar kana id aktivitas (lain posisi) supados aktivitas
        anu geus aya moal dianimasikeun deui unggal polling — ngan aktivitas
        ANYAR (id anu can kungsi némbongan) anu bakal muncul make animasi
        "fade-in + slide-down" saperti conto "staggered list animation".
    --}}
    @forelse ($activities as $activity)
        <div wire:key="activity-{{ $activity->id }}" class="activity-item activity-item-animated d-flex"
            style="animation-delay: {{ $loop->index * 70 }}ms">
            <div class="activite-label" style="min-width: 0%"></div>
            <i class='bi bi-circle-fill activity-badge text-{{ $activity->action_color }} align-self-start'></i>
            <div class="activity-content">
                <b class="fw-bold text-dark">{{ $activity->user_name ?? 'Sistem' }}</b>
                {{ $activity->description }}
                - <small>{{ $activity->created_at->locale('id')->diffForHumans() }}</small>
            </div>
        </div><!-- End activity item-->
    @empty
        <div class="activity-item d-flex">
            <div class="activity-content text-muted">
                Belum aya aktivitas nu kacatet.
            </div>
        </div><!-- End activity item-->
    @endforelse

</div>
