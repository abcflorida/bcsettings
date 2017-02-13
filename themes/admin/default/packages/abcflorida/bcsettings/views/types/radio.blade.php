@foreach ($field->all() as $option)

	<label class="radio-inline">
		<input type="radio" name="{{{ $field->id }}}" value="{{{ $option->value }}}"{{ $option->value == $field->value ? ' checked="checked"' : null }}>
		{{{ $option->label }}}
	</label>

@endforeach
