<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active">
		<a href="#discussion" aria-controls="settings" role="tab" data-toggle="tab">Diskusi</a>
	</li>
	@can('manage')
	<li role="presentation">
		<a href="#module" aria-controls="settings" role="tab" data-toggle="tab">Materi</a>
	</li>
	<li role="presentation">
		<a href="#assignment" aria-controls="settings" role="tab" data-toggle="tab">Tugas</a>
	</li>
	<li role="presentation">
		<a href="#quiz" aria-controls="settings" role="tab" data-toggle="tab">Quiz</a>
	</li>
	@endcan
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="discussion">
		{!! Form::open(['route' => 'discuss.store']) !!}

			{!! Form::hidden('classroom_id', $classroom->id) !!}
			{!! Form::hidden('user_id', $lms['profile']->id) !!}

			<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
				{!! Form::textarea('content', null, ['class' => 'form-control discuss-textarea', 'placeholder' => 'Bagikan isi pikiran anda dikelas ini...', 'rows' => '2']) !!}
				{!! $errors->first('content', '<p class="help-block">:message</p>') !!}
			</div>

			<div class="text-right"> 
				{!! Form::button('<i class="fa fa-send"></i> Bagikan', ['class'=>'btn btn-flat btn-primary', 'type' => 'submit', 'id' => 'submitDiscussion']) !!}
			</div>

		{!! Form::close() !!}
	</div>
	@can('manage')
	<div role="tabpanel" class="tab-pane" id="module">
		<div class="text-center">
			<a href="#" data-toggle="modal" data-target="#courseModal">Pilih Materi</a> <span class="atau">atau</span> <a href="{{ route('courses.create') }}" class="btn btn-primary">Buat Materi Baru</a>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane" id="assignment">
		<div class="text-center">
			<a href="#" data-toggle="modal" data-target="#assignmentsModal">Pilih Tugas</a> <span class="atau">atau</span> <a href="{{ route('assignments.create') }}" class="btn btn-primary">Buat Tugas Baru</a>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane" id="quiz">
		<div class="text-center">
			<a href="#" data-toggle="modal" data-target="#quizzesModal">Pilih Quiz</a> <span class="atau">atau</span> <a href="{{ route('quizzes.create') }}" class="btn btn-primary">Buat Quiz Baru</a>
		</div>
	</div>
	@endcan
</div>

<div class="modal fade" id="quizzesModal" tabindex="-1" role="dialog" aria-labelledby="shareQuiz">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="shareQuiz">Bagikan quiz di kelas ini</h4>
			</div>
			{!! Form::open(['route' => ['quizzes.attach'], 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal']) !!}
				<div class="modal-body clearfix">
					<div class="col-md-12">
						{!! Form::hidden('classroom_id', $classroom->id) !!}
						<div class="form-group {{ $errors->has('quiz_id') ? 'has-error' : '' }}"> 
						{!! Form::select('quiz_id', $lms['profile']->teacherquizzes()->whereNotIn('id', $classroom->attachedQuizzes)->get()->pluck('title', 'id'), null, ['class' => 'select2 form-control', 'placeholder' => 'Pilih quiz...'])  !!}
						{!! $errors->first('quiz_id', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('Batal', ['class' => 'btn btn-link', 'data-dismiss' => 'modal']) !!}
					{!! Form::button('<i class="fa fa-share-alt"></i> Bagikan Quiz', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<div class="modal fade" id="assignmentsModal" tabindex="-1" role="dialog" aria-labelledby="shareAssignment">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="shareAssignment">Bagikan tugas ini</h4>
			</div>
			{!! Form::open(['route' => ['assignments.attach'], 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal']) !!}
				<div class="modal-body clearfix">
					<div class="col-md-12">
						{!! Form::hidden('classroom_id', $classroom->id) !!}
						<div class="form-group {{ $errors->has('assignment_id') ? 'has-error' : '' }}"> 
						{!! Form::select('assignment_id', $lms['profile']->teacherassignments()->whereNotIn('id', $classroom->attachedAssignments)->get()->pluck('title', 'id'), null, ['class' => 'select2 form-control', 'placeholder' => 'Pilih tugas...'])  !!}
						{!! $errors->first('assignment_id', '<p class="help-block">:message</p>') !!}
						</div>						
						<div class="form-group {{ $errors->has('start') ? 'has-error' : '' }}"> 
							<div class="input-group date">
                <input type="text" class="form-control datepicker" name="start" placeholder="Start" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
							{!! $errors->first('start', '<p class="help-block">:message</p>') !!}
						</div>
						<div class="form-group {{ $errors->has('deadline') ? 'has-error' : '' }}"> 
							<div class="input-group date">
                <input type="text" class="form-control datepicker" name="deadline" placeholder="Deadline" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
							{!! $errors->first('deadline', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('Batal', ['class' => 'btn btn-link', 'data-dismiss' => 'modal']) !!}
					{!! Form::button('<i class="fa fa-share-alt"></i> Bagikan Tugas', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="shareCourse">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Bagikan Materi ini</h4>
			</div>
			{!! Form::open(['route' => ['courses.attach'], 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal']) !!}
				<div class="modal-body clearfix">
					<div class="col-md-12">
						{!! Form::hidden('classroom_id', $classroom->id) !!}
						<div class="form-group {{ $errors->has('course_id') ? 'has-error' : '' }}"> 
						{!! Form::select('course_id', $lms['profile']->teachercourses()->whereNotIn('id', $classroom->attachedCourses)->get()->pluck('name', 'id'), null, ['class' => 'select2 form-control', 'placeholder' => 'Pilih materi...'])  !!}
						{!! $errors->first('course_id', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('Batal', ['class' => 'btn btn-link', 'data-dismiss' => 'modal']) !!}
					{!! Form::button('<i class="fa fa-share-alt"></i> Bagikan Materi', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>