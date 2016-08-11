@extends('user.classrooms.classroom')

@section('classroom_content')
	<div class="panel panel-default">
		<header class="panel-heading clearfix">
			<h2 class="panel-title pull-left text-bold">{{ $assignment->title }}</h2>
		</header>
		<ul class="list-group">
			<li class="list-group-item">{!! $assignment->content !!}</li>
			<li class="list-group-item"><span class="text-small"><strong>Deadline:</strong> {{ formatDate($assignment->pivot->deadline) }}</span></li>
			@if($assignment->file)
				<li class="list-group-item"><span class="attached"><i class="fa fa-paperclip"></i></span><a href="{{ route('classrooms.download', $assignment->file) }}">{{ $assignment->file }}</a></li>
			@endif
		</ul>
	</div>
	@can('manage')		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title text-bold">Tugas terkumpul <span class="badge">{{ $assignment->submissions->count() }}</span></h4>
			</div>
			<ul class="list-group">
				<li class="list-group-item"><a href="{{ route('classrooms.downloadsubmission', [$classroom->id, $assignment->id]) }}"><i class="fa fa-download"></i> Data tugas terkumpul</a></li>
			</ul>
			<div class="panel-body">
				@forelse($assignment->submissions as $user)
					<div class="panel panel-info panel-sm">
						<div class="panel-heading">
							{{ $user->fullname }}
							{!! Form::open(['route' => 'submissions.destroy', 'method' => 'delete', 'class' => 'pull-right']) !!}
								{!! Form::hidden('user_id', $user->id) !!}
								{!! Form::hidden('assignment_id', $assignment->id) !!}
								{!! Form::submit('Batalkan', ['class'=>'btn btn-link btn-sm warning-delete', 'data-title' => 'tugas dari ' . $user->fullname]) !!}
							{!! Form::close() !!}
						</div>
						<div class="panel-body">
							<p><strong>Judul: </strong>{{ $user->pivot->title }}</p>
							<p><strong>Konten: </strong>{{ $user->pivot->content }}</p>
							@if($user->pivot->file)
								<p><i class="fa fa-cloud-download"></i> <a href="{{ route('classrooms.download', $user->pivot->file) }}">{{ $user->pivot->file }}</a></p>
							@endif
						</div>
					</div>
				@empty
					<h4 class="text-center no-content">Belum ada yang mengumpulkan tugas.</h4>
				@endforelse
			</div>
		</div>
	@else
		@if(date($assignment->pivot->deadline) >= date('Y-m-d'))
			@if(! $submit)
				<div class="panel panel-default">
					<header class="panel-heading">
						<h2 class="panel-title text-bold">Submit Tugas</h2>
					</header>
					<ul class="list-group">
						<li class="list-group-item">
							{!! Form::open(['route' => 'submissions.store', 'method' => 'post', 'files' => true]) !!}
								{!! Form::hidden('assignment_id', $assignment->id) !!}
								<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
									{!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Judul...']) !!}
									{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
								</div>
								<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
									{!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Konten...', 'rows' => '5']) !!}
									{!! $errors->first('content', '<p class="help-block">:message</p>') !!}
								</div>
								<div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
									{!! Form::file('file') !!}
									{!! $errors->first('file', '<p class="help-block">:message</p>') !!}
								</div>
								<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
									{!! Form::submit('Kumpul', ['class' => 'btn btn-primary']) !!}
								</div>
							{!! Form::close() !!}
						</li>
					</ul>
				</div>
			@else

				<div class="panel panel-default">
					<header class="panel-heading">
						<h2 class="panel-title text-bold">Anda sudah menyelesaikan tugas ini.</h2>
					</header>
					@foreach($submitted as $answer)
						<ul class="list-group">
							<li class="list-group-item"><strong>Judul: </strong>{{ $answer->pivot->title }}</li>
							<li class="list-group-item"><strong>Kontent: </strong>{!! $answer->pivot->content !!}</li>
							<li class="list-group-item"><strong>File: </strong>{{ $answer->pivot->file }}</li>
						</ul>
					@endforeach
				</div>
			@endif
		@else
			<h4 class="text-center no-content">Tugas sudah mencapai deadline.</h4>
		@endif
	@endcan

@endsection
