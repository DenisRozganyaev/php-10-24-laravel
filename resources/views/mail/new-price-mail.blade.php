<x-mail::message>
    Hello, product from your wish-list was updated.

    Old price: {{ $old_price }}$ <br>
    New price: {{ $price }}$
    <x-mail::panel>
        <img src="{{$imageUrl}}" width="400" >
    </x-mail::panel>

    <x-mail::button :url="$url">
        Visit product page
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
