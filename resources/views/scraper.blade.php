
@extends('layouts.app')

@section('title', 'Scrapper Kit')

@component('layouts.header')
@endcomponent

@section('sidebar')
    @parent

    {{-- <p>This child sidebar is appended to the master sidebar.</p> --}}


@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <form method="POST" action="/scraper">
        @csrf

        {{-- <input type="hidden" name="urlGetTarget" value=""> --}}
        <div class="form-group">
            <label for="urlInputScrape">Url Endpoint</label>
            <input type="text" name="urlTarget" class="form-control" id="urlInputScrape" aria-describedby="urlHelp"
                    placeholder="Enter URL or API to scrape" aria-required="true" required>
            <small id="urlHelp" class="form-text text-muted">Input URL or API Endpoint to scrape</small>
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Upload Excel file w/ 1 column for of folio Reference.</label>
            <input type="file" name="referenceList" class="form-control-file" id="exampleFormControlFile1">
        </div>
{{--
        <div class="form-group">
            <div class="form-group custom-file col-xl-5 col-lg-5 col-md-5 col-xs-4">
                <input type="file" name="referenceList2" class="form-control-file custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div> --}}

        {{-- <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" class="form">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
        </div> --}}

        <button type="submit" class="btn btn-primary">SCRAPE !</button>
    </form>
@endsection

{{-- @component('alert')
    @slot('title')
        Forbidden
    @endslot

    You are not allowed to access this resource!
@endcomponent --}}