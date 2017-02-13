<select class="form-control" name="{{{ $field->id }}}" id="{{{ $field->id }}}">
	@foreach ($field->all() as $option)
		<option value="{{{ $option->value }}}"{{ $option->value == $field->value ? ' selected="selected"' : null }}>
			{{{ $option->label }}}
		</option>
	@endforeach
</select>
