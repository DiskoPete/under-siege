<?php
/**
 * @var \Illuminate\View\ComponentAttributeBag $attributes
 */
?>
<button
    {{$attributes->merge(['type' => 'submit'])}}
    class="
        inline-block border-2 border-secondary-500
        px-7 py-1
        font-bold bg-secondary-500 text-white
        rounded-full
        text-lg
    "
>
    {{$slot}}
</button>
