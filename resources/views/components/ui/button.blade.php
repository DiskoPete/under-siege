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
        inline-block border-2 border-primary-500
        px-7 py-1
        font-bold bg-primary-500 text-white
        rounded-full
        text-lg
    "
    @if($href)href="{{$href}}"@endif
>
    {{$slot}}
</<?= $tag ?>>
