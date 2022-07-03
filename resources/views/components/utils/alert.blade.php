@props(['dismissable' => true, 'type' => 'success', 'ariaLabel' => __('Close')])

<div {{ $attributes->merge(['class' => 'alert alert-dismissible alert-' . $type]) }} role="alert">
    {{ $slot }}

    @if ($dismissable)
        <button type="button" class="btn-close" data-bs-dismiss="alert" data-coreui-dismiss="alert" aria-label="{{ $ariaLabel }}"></button>
    @endif
</div>
