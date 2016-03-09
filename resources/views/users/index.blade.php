@extends('home')

@section('header_scripts')
<link href="{{ asset( '/css/select2.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('page_description')
    <a href="{{ route('users.create') }}" class="btn btn-flat btn-info btn-xs"><i class="fa fa-plus"></i> Tambah Baru</a>
@endsection

@section('content')
<div class="row">
	<div class="pull-left col-xs-6 col-sm-8 col-md-3">
		<div class="btn-group" role="group">
			<a class="btn btn-default" href="{{ route('users.index') }}">All</a>
			<a class="btn btn-default" href="{{ route('users.index', ['type' => 'staff']) }}">Staff</a>
			<a class="btn btn-default" href="{{ route('users.index', ['type' => 'teacher']) }}">Guru</a>
			<a class="btn btn-default" href="{{ route('users.index', ['type' => 'student']) }}">Siswa</a>
		</div>
		<div class="btn-group" role="group">
			<a class="btn btn-default" href="{{ route('users.trash') }}"><i class="fa fa-trash"></i></a>
		</div>
	</div>
	<div class="pull-right col-xs-6 col-sm-4 col-md-3">

		{!! Form::open(['method' => 'get']) !!}
			<div class="form-group {!! $errors->has('title') ? 'has-error' : '' !!}">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-search"></i></span>
					{!! Form::text( 'q', Request::has('q') ? Request::get('q') : null, ['class' => 'form-control', 'placeholder' => 'Cari user...']) !!}
				</div>
			</div>
		{!! Form::close() !!}
		
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Tabel User</h3>
			</div>
			<div class="box-body">
				<table id="users-datatable" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><input type="checkbox"></input></th>
							<th>Nama</th>
							<th>Email</th>
							<th>Status</th>
							<th>Role</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
							<tr>
								<td><input type="checkbox" name="id[]" value="{{ $user->id }}"></input></td>
		                        <td>
		                        	<div>{{ $user->fullname }}</div>
		                        	<div>
		                        		@if(Route::currentRouteNamed('users.trash'))
			                        		{!! Form::open(['route' => ['users.restore', $user->id], 'method' => 'patch', 'class' => 'form-delete-inline']) !!}
	        									{!! Form::submit('Batal Hapus', ['class'=>'btn btn-flat btn-link btn-xs']) !!}
	        								{!! Form::close() !!}
			                        		{!! Form::open(['route' => ['users.forcedelete', $user->id], 'method' => 'delete', 'class' => 'form-delete-inline']) !!}
	        									{!! Form::submit('Hapus Selamanya', ['class'=>'btn btn-flat btn-link btn-link-danger btn-xs warning-delete', 'data-title' => $user->fullname]) !!}
	        								{!! Form::close() !!}
        								@else
			                        		<a href="{{ route('users.edit', $user->id) }}" class="btn btn-flat btn-link btn-xs">Edit</a>
			                        		@if($user->rolename !== 'Administrator')
	        									{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete', 'class' => 'form-delete-inline']) !!}
		        									{!! Form::submit('Hapus', ['class'=>'btn btn-flat btn-link btn-link-danger btn-xs']) !!}
		        								{!! Form::close() !!}
		        							@endif
        								@endif
		                        	</div>
		                        </td>
		                        <td>{{ $user->email }}</td>
		                        <td>{{ $user->status }}</td>
		                        <td>{{ $user->rolename }}</td>
		                    </tr>
	                    @endforeach
	                </tbody>
	                <tfoot>
						<tr>
							<th><input type="checkbox"></input></th>
							<th>Nama</th>
							<th>Email</th>
							<th>Status</th>
							<th>Role</th>
						</tr>
					</tfoot>
				</table>
				<div class="pull-right">
				@if( $querystring !== null )
					{!! $users->appends($querystring)->links() !!}
				@else
					{!! $users->links() !!}
				@endif
				</div>
			</div>
		</div>
	</div>
</div><!-- /.row -->
@endsection

@section('footer_scripts')
<script src="{{ asset ('/js/libs/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset ('/js/admin.js') }}" type="text/javascript"></script>
@endsection