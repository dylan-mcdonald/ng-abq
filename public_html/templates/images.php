<h1>Images</h1>
<p>See what we've been up to in the ABQ Angular community.</p>
<p></p>
<h3>All Images</h3>
<table class="table table-bordered table-responsive table-striped table-word-wrap">

	<tr>
		<th>Id</th>
		<th>Filename</th>
	</tr>

	<tr *ngFor="let image of images">
		<td>{{ image.imageId }}</td>
		<td>{{ image.imageFileName }}</td>
	</tr>

</table>