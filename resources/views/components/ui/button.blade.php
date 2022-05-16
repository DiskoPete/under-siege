@props(['href' => null])
<?php
/**
 * @var \Illuminate\View\ComponentAttributeBag $attributes
 */
$tag = 'button';

if ($href) {
    $tag = 'a';
}
?>
<<?= $tag ?>
    {{$attributes->merge()}}
    class="
        inline-block
        px-7 py-2
        font-bold bg-primary-500 text-white
        rounded
        text-lg
        hover:bg-primary-600

        transition-colors
    "
    @if($href)href="{{$href}}"@endif
>
    {{$slot}}
</<?= $tag ?>>
