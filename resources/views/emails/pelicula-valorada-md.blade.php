<x-mail::message>
# Valoración realizada.

Has realizado una valoración de la película: {{$pelicula->titulo}}.
Puntuación: {{$valoracion->puntuacion}}

## Comentario:
{{$valoracion->comentario}}


<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
