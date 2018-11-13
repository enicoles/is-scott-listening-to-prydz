@extends('layouts.master')

@section('content')
        <div class="row">
                <div class="col-7">
                        <h5>Not right now, but he last listened to this on {{ $lastPlayed }}</h5>
                        <br>
                        <h3>Title: <a href="{{ $url }}" target="_blank">{{ $title }}</a></h3>
                        <h3>Artist: {{ $artist }}</h3>
                        <h3>Album: {{ $album }}</h3>
                </div>
                <div class="col-4 offset-1">
                        <a href="{{ $url }}"><img src="{{ $img }}"></a>
                </div>
        </div>
@endsection
