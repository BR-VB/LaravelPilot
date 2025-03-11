@props(['created_at' => null, 'updated_at' => null, 'created_label' => 'Created at', 'updated_label' => 'Updated at'])

<div class="created-and-updated">
    {{ $created_label }}:
    {{ $created_at ? \Illuminate\Support\Carbon::parse($created_at)->diffForHumans() : 'N/A' }},
    {{ $updated_label }}:
    {{ $updated_at ? \Illuminate\Support\Carbon::parse($updated_at)->diffForHumans() : 'N/A' }}
</div>