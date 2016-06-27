@extends('layouts.master')

@section('title')
	Trending Quotes
@stop

@section('styles')
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
@stop

@section('content')
<div>
	@if (!empty(Request::segment(1)))
		<section class="filter-bar"> 
			A filter has been set! <a href="{{ route('index') }}">Show all quotes</a>
		</section>
	@endif
	@if(count($errors)>0)
		<section class="info-box fail">
			@foreach($errors->all() as $error)
				{{$error}}
			@endforeach
		</section>
	@endif
	@if(Session::has('success'))
		<section class="info-box success">
			{{ Session::get('success') }}
		</section>
	@endif
	<section class="quotes">
		<h1>Latest Quotes</h1><br><hr>
		@for($i=0; $i<count($quotes); $i++)
			<article class="quote">
				<div class="card">
					<div class="delete">
						<a href="{{route('delete', ['quote_id'=>$quotes[$i]->id])}}">x</a><!--Here 'delete' is the route name, 'quote_id' is any name you want which will pass the quote id in route-->
					</div>
					<div class="card-block">
						<div class="card-text">
							{{ $quotes[$i]->quote }}
							<div class="info">
								Created By <a href="{{ route('index', ['author'=>$quotes[$i]->author->name]) }}">{{ $quotes[$i]->author->name }}</a> on {{ $quotes[$i]->created_at }}
							</div>
						</div>
					</div>
				</div>
			</article>
		@endfor
		<div class="row">
			<div class="pagination">
				@if ($quotes->currentPage() !== 1)
					<a href="{{$quotes->previousPageUrl()}}"><span class="fa fa-arrow-circle-left"></span></a>
				@endif
				@if ($quotes->currentPage() !== $quotes->lastPage() && $quotes->hasPages() )
					<a href="{{$quotes->nextPageUrl()}}"><span class="fa fa-arrow-circle-right"></span></a>
				@endif
			</div>
		</div>
		
	</section>
	<section class="edit-quote">
		<h1>Add a Quote</h1>
		<center>
			<form method="post" action="{{ route('create') }}">
				<div class="input-group">
					<label for="author">Your Name</label>
					<input type="text" name="author" id="author" placeholder="Type your name">
				</div>

				<div class="input-group">
					<label for="email">Your Email</label>
					<input type="text" name="email" id="email" placeholder="Type your e-mail">
				</div>

				<div class="input-group">
					<label for="quote">Your Quote</label>
					<textarea name="quote" id="quote" rows="5" placeholder="Quote"></textarea>
				</div>
				<button type="submit" class="btn btn-warning">Submit Quote</button>
				<input type="hidden" value="{{ Session::token() }}" name="_token">
			</form>
		</center>
	</section>

@stop