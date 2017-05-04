@extends('layouts.app')

@section('content')

<img src="/image/blog/{{ $post->image }}" alt="">

<h1>{{ $post->title }}</h1>
<small>Written {{ Carbon::parse($post->created_at)->diffForHumans() }}</small>
{!! $post->content !!}

<h2>Comments (130)</h2>

@if(Auth::check())

	{!! Form::open(['url'=>'/blog/newcomment']) !!}

	{{ Form::textarea('comment') }}

	{!! Form::submit('submit your comment!') !!}

	{!! Form::hidden('posts_id', $post->id) !!}

	{!! Form::close() !!}
	@if($errors->first('comment'))
		<p class="alert-danger">{{ $errors->first('comment') }}</p>
	@endif

@else 
	You must log in

@endif


@endsection