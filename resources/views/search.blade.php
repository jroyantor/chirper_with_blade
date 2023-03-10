<x-app-layout>

<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search') }}
        </h2>
    </x-slot>
<div class="m-5">
 <form action="{{ route('search') }}" method="POST">
    @csrf
    <input type="text" name="keyword" placeholder="search query...."/>
    <button type="submit">Search</button>
 </form>
</div>

</x-app-layout>