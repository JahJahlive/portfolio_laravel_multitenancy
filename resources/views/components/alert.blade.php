{{-- resources/views/components/alert.blade.php --}}
@props(['type' => 'info', 'message'])

@php
    $icon = match($type) {
        'success' => 'check',
        'danger'  => 'alert-triangle',
        'warning' => 'alert-circle',
        default   => 'info-circle',
    };
@endphp

<div {{ $attributes->merge(['class' => "alert alert-{$type} alert-dismissible"]) }} role="alert">
    <div class="d-flex">
        <div>
            <i class="ti ti-{{ $icon }} icon alert-icon"></i>
        </div>
        <div>
            {{ $message ?? $slot }}
        </div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
</div>