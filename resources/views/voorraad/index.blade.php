@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Voorraad Overzicht') }}</div>

                <div class="card-body">
                    @if($producten->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Naam</th>
                                        <th>Hoeveelheid</th>
                                        <th>Vervaldatum</th>
                                        <th>Categorie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($producten as $product)
                                        <tr class="{{ $product->stock <= 5 ? 'table-warning' : '' }}">
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                {{ $product->stock }}
                                                @if($product->stock <= 5)
                                                    <span class="badge badge-warning">Laag</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->expiry_date)
                                                    {{ $product->expiry_date->format('d-m-Y') }}
                                                    @if($product->expiry_date->isPast())
                                                        <span class="badge badge-danger">Verlopen</span>
                                                    @elseif($product->expiry_date->diffInDays(now()) <= 3)
                                                        <span class="badge badge-warning">Bijna verlopen</span>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $product->category->name ?? 'Onbekend' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Er zijn momenteel geen actieve producten op voorraad.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
