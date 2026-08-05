<div wire:poll.30s="$refresh">

    @forelse ($activities as $activity)
        <div class="activity-item d-flex">
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
