@extends('layouts.app')

@section('content')

<h1>Home Page</h1>

<h2>All Products</h2>

@foreach($allProducts as $product)
<article>
	<h1>{{ $product->name }}</h1>
</article>
@endforeach 

@endsection

