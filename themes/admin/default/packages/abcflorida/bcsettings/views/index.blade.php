@extends('layouts/default')

{{-- Page title --}}
@section('title')
@parent
{{ trans('platform/settings::common.title') }}
@stop

{{-- Inline scripts --}}
@section('scripts')
@parent
@stop

{{-- Inline styles --}}
@section('styles')
@parent
@stop

{{-- Page content --}}
@section('page')

{{-- Page header --}}
<section class="panel panel-default panel-tabs">

	{{-- Form --}}
	<form id="settings-form" class="form-horizontal" action="{{ request()->fullUrl() }}" role="form" method="post" accept-char="UTF-8" autocomplete="off">

		{{-- Form: CSRF Token --}}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<header class="panel-heading">

			<nav class="navbar navbar-default navbar-actions">

				<div class="container-fluid">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<span class="navbar-brand">{{{ trans('platform/settings::common.title') }}}</span>
					</div>

					{{-- Form: Actions --}}
					<div class="collapse navbar-collapse" id="actions">

						<ul class="nav navbar-nav navbar-right">

							@if ($section->anyFieldsetHasFields())
							<li>
								<button class="btn btn-primary navbar-btn" data-toggle="tooltip" data-original-title="{{{ trans('action.save') }}}">
									<i class="fa fa-save"></i> <span class="visible-xs-inline">{{{ trans('action.save') }}}</span>
								</button>
							</li>
							@endif

						</ul>

					</div>

				</div>

			</nav>

		</header>

		<div class="panel-body">

			<div role="tabpanel">

				<ul class="nav nav-tabs">
				@foreach ($sections as $_section)
					<li class="{{ $_section->id == $section->id ? 'active' : null }}">
						<a href="{{{ url()->toAdmin("settings/{$_section->id}") }}}">{{ $_section->name }}</a>
					</li>
				@endforeach
				</ul>

				<div class="tab-content">

				@if ($section->hasFieldsets())

					@foreach ($fieldsets as $fieldset)
					<fieldset>

						<legend>{{ $fieldset->name }}</legend>

						@if ($fieldset->hasFields())

							@foreach ($fieldset->all() as $field)
							<div class="form-group{{ Alert::onForm($field->id, ' has-error') }}">

								<label for="{{{ $field->id }}}" class="col-lg-3 control-label">

									{{{ $field->name }}}

									@if ($info = $field->info)
									<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ $info }}}"></i>
									@endif

								</label>

								<div class="col-lg-6">

									@include("platform/settings::types.{$field->type}")

									<span class="help-block">{{{ Alert::onForm($field->id) }}}</span>

								</div>

							</div>
							@endforeach

						@else
							<h3>{{{ trans('platform/settings::common.no_fields', [ 'section' => $section->id, 'fieldset' => $fieldset->id ]) }}}</h3>
						@endif

					</fieldset>
					@endforeach

				@else
					<h3>{{{ trans('platform/settings::common.no_fieldsets', [ 'section' => $section->id ]) }}}</h3>
				@endif

				</div>

			</div>

		</div>

	</form>

</section>

@help('platform/settings::help')

@stop
