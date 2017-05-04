@extends('layouts.app')

@section('content')

<h1>Write a new Blog Post</h1>

{!! Form::open(['url'=>'blog', 'files' => 'true']) !!}

<div>
	{!! Form::label('title', 'Title') !!}
	{!! Form::text('title', null, ['placeholder'=>'Lego Batman Review']) !!}

	@if($errors->first('title'))
		<p class="alert-danger">{{ $errors->first('title') }}</p>
	@endif
</div>

<div>
	{!! Form::label('content', 'Your Blog Post: ') !!}
	{!! Form::textarea('content') !!}
</div>
	@if($errors->first('content'))
		<p class="alert-danger">{{ $errors->first('content') }}</p>
	@endif

<div>
	{!! Form::label('image') !!}
	{!! Form::file('image') !!}
</div>
	@if($errors->first('image'))
		<p class="alert-danger">{{ $errors->first('image') }}</p>
	@endif
{!! Form::submit('submit your post!') !!}

{!! Form::close() !!}




@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
<script>
      CKEDITOR.replace( 'content' );
</script>
@endsection