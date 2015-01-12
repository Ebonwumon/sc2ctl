<a href="{{ URL::route('team.show', $team->id) }}">
    <div class="team-profile-card">
        <div class="logo-img">
            <img src="{{ $team->logo_img }}" />
        </div>
        <span class="primary-name">[{{ $team->tag }}]</span>
        <span class="secondary-name">{{ $team->name }}</span>
    </div>
</a>
