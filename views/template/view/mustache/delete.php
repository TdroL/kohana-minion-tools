<h2><?php echo ucfirst($controller_name) ?> <small>delete</small></h2>

{{&form.open}}
	{{#has_errors}}
	<div class="alert alert-error">
		<a class="close" data-dismiss="alert" href="#">&times;</a>
		Found errors in form.
	</div>
	{{/has_errors}}

	<div class="control-group">
		<span class="control-label">{{label.id}}</span>
		<div class="controls">
			{{value.id}}
			{{^value.id}}<em>Empty</em>{{/value.id}}
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-danger">Remove</button>
		<a href="{{form.url.cancel}}" class="btn">Cancel</a>
	</div>
{{&form.close}}
