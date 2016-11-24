@extends('layouts.app')

@section('htmlheader_title')
Home
@endsection


@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading text-center">Logo</div>

			<div class="panel-body">
				<img src='{{ asset("images/$cliente->logo") }}' alt="..." class="img-rounded center-block img-responsive">
			</div>
			{!! Form::open (['route'=> ['cliente/logo'], 'method' => 'POST', 'class'=>'form-horizontal','files'=>true, 'enctype'=>'multipart/form-data']) !!}
			<div class="box-footer">

				<label for="exampleInputFile"><i class="fa fa-edit"></i>Actualizar Imagen de Logo</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="file" class="form-control input-file" name="logo">
					</div>
					<div class="col-xs-4">
						<button type="submit" class="btn btn-success"><i class="fa fa-upload"></i></button>
					</div>
				</div>
			</div>
			{!! Form::close()!!}
		</div>
	</div>
</div>

<script type="text/javascript">
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function(){

	window.URL = window.URL || window.webkitURL;

	$('.input-file').change(function (){
		var file = this.files[0];
		var filename = file.name;

		var fil = $(this);

		var img = new Image();

		img.src = window.URL.createObjectURL( file );

		img.onload = function() {
			var width = img.naturalWidth,
			height = img.naturalHeight;

			window.URL.revokeObjectURL( img.src );

			// alert('width: ' + width + ', height: '+ height);

			if( (width < 200 || width > 250) && (height < 200 || height > 250)) {
				alert('El tamano del logo tiene que ser entre 200x200 y 250x250 pixeles');
				fil.val('');
			}
			else {

			}
		};

	});

});

</script>

@endsection
