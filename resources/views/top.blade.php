@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8 form-container">
			<div class="card">
				<div class="card-header">
					New
				</div>
				<div class="card-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<!-- New Wish Form -->
					<form action="/wish" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- Wish Name -->
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" name="name" id="wish-name" class="form-control" value="{{ old('wish') }}" placeholder="欲しいもの">
							</div>
						</div>

						<!-- Add Wish Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-10">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-plus"></i>追加
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!-- Wish list -->
			@if (count($wish_list) > 0)
				<div class="card">
					<div class="card-heading"></div>
					<div class="card-body">
						<table class="table table-striped task-table">
							<thead>
								<th>Wish</th>
								<th>&nbsp;</th>
							</thead>
							<tbody>
								@foreach ($wish_list as $wish)
									<tr>
										<td class="table-text"><div>{{ $wish->name }}</div></td>

										<!-- Task Delete Button -->
										<td>
											<form action="/wish/{{ $wish->id }}" method="POST">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}

												<button type="submit" class="btn btn-danger">
													<i class="fa fa-trash"></i>削除
												</button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endif
		</div>
	</div>
@endsection