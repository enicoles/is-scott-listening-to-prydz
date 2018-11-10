@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Is Scott Listening to Prydz?</div>
                    <h2>Prydz Before</h2>
                    <div class="card-body">
                        Artist {{ $artist }}<br>
                        Title {{ $title }}<br>
                        Album {{ $album }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
