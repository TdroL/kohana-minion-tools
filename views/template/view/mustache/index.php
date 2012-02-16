<h2><?php echo ucfirst($controller_name) ?> <small>index</small></h2>

{{#flash}}
<div class="alert alert-{{type}}">
	<a class="close" data-dismiss="alert" href="#">&times;</a>
	{{message}}
</div>
{{/flash}}

<p>
	<a href="{{url.create}}" class="btn btn-primary btn-create">Add new <?php echo $controller_name ?></a>
</p>

<table id="<?php echo $controller_name ?>-index" class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Id</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{{#items}}
		<tr>
			<td>{{id}}</td>
			<td>{{id}}</td>
			<td>
				<a href="{{urls.update}}" class="btn btn-update" data-label="Update"><span>Update</span></a>
				<a href="{{urls.delete}}" class="btn btn-delete" data-label="Delete"><span>Delete</span></a>
			</td>
		</tr>
		{{/items}}
	</tbody>
</table>
