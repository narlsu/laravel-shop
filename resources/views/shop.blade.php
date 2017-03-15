@extends('master')

@section('title', 'Shop')

@section('content')

<h1>Shop</h1>

<h2>All Products</h2>

@foreach($allProducts as $product)
<article>
	<h1>{{ $product->name }}</h1>
	<p>{{ $product->description }}</p>
	<small>${{ $product->price }}</small>
</article>
@endforeach


@endsection