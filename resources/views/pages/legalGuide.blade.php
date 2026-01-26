@extends('layouts.app')

@section('content')
    @php
        $legalGuides = [
            [
                'title' => 'Family Law',
                'topics' => ['Divorce', 'Child Custody', 'Adoption'],
            ],
            [
                'title' => 'Criminal Law',
                'topics' => ['DUI', 'Drug Crimes', 'Sex Crimes'],
            ],
        ];
    @endphp

    <div class="container">
        <h2>Legal Guides</h2>

        <div class="row">
            @foreach ($legalGuides as $guide)
                <div class="col-md-6 mb-3">
                    <h5>{{ $guide['title'] }}</h5>
                    <p>{{ implode(', ', $guide['topics']) }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
