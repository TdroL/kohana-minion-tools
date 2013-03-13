<form action="{{url.action}}">
	<fieldset>
		{{#has_errors}}
		<div class="alert alert-error">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			Found errors in form.
		</div>
		{{/has_errors}}

		{{#field.name}}
		<div class="control-group{{#error}} error{{/error}}">
			<label for="<?php echo $controller_name ?>-name">{{label}}</label>
			<div class="controls">
				<input type="text" name="name" id="<?php echo $controller_name ?>-name" />
				{{#error}}
				<span class="help-inline">{{error}}</span>
				{{/error}}
			</div>
		</div>
		{{/field.name}}

		<div class="form-actions">
			<button class="btn btn-primary">Save</button>
			<a href="{{url.cancel}}" class="btn">Cancel</a>
		</div>

	</fieldset>
</form>
