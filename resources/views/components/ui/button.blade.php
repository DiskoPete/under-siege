<?php
/**
 * @var \Illuminate\View\ComponentAttributeBag $attributes
 */
?>
<button
    {{$attributes->merge(['type' => 'submit'])}}
    class="
        inline-block border-2 border-secondary-500
        px-5 py-1
        font-bold bg-secondary-500 text-light-500
        rounded-full
    "
>
    {{$slot}}
</button>
