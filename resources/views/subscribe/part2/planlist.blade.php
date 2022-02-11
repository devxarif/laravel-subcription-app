@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Plans</div>

                <div class="card-body d-flex">
                    @foreach ($plans as $plan)
                        <div class="me-5">
                            <h5>Name: {{ $plan->name }}</h5>
                            <h5>Price: ${{ $plan->price }}</h5>
                            <a href="{{ route('payments', ['plan' => $plan->stripe_id]) }}" class="btn btn-primary">
                                Subscribe Now
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
