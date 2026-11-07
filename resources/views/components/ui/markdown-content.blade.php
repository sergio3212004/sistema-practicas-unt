@props(['content' => ''])
<div {{ $attributes->class(['prose max-w-none break-words text-gray-700']) }}>{!! \Illuminate\Support\Str::markdown($content ?? '', ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</div>
