@extends('layouts.main')

@section('content')
    <table>
        @foreach ($items as $item)
            <tr>
                <td>{{ $post->user->name }}</td>    {{-- виводимо ім'я користувача і назву категорії зі зв'язаних таблиць --}}
                <td>{{ $post->category->title }}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->created_at}}</td>
            </tr>
        @endforeach
    </table>
@endsection


