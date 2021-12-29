<div>
    @if (Gate::check('addTeamMember', $team))
        <x-jet-section-border />
        <livewire:team-billing :team="$team" />
    @endif
</div>
