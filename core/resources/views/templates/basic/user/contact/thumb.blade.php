@php
    $bgClasses = ['bg--success', 'bg--info', 'bg--warning', 'bg--danger'];
    $hash = crc32(@$contact->full_name);
    $bgClass = $bgClasses[$hash % count($bgClasses)];
    $user = auth()->user();
@endphp

@if (@$contact->image && $user->hasAgentPermission('view contact profile'))
    <div class="contact_thumb ">
        <img src="{{ @$contact->image_src }}" alt="Image">
    </div>
@else
    <div class="contact_thumb   {{ $bgClass }}">
        {{ strtoupper(substr(@$contact->firstname ?? '', 0, 1)) }}{{ strtoupper(substr(@$contact->lastname ?? '', 0, 1)) }}
    </div>
@endif