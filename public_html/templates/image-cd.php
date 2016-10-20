<form #addImageForm="ngForm" name="addImageForm" id="addImageForm" class="form-horizontal well" (ngSubmit)="createImage();" novalidate>
	<h2>Create Image</h2>

	<div class="form-group" [ngClass]="{ 'has-error': imageFileName.touched && imageFileName.invalid }">
		<label for="image">Image FileName</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="image" id="image" class="form-control" maxlength="50" required [(ngModel)]="image.imageFileName" #imageFileName="ngModel" />
		</div>
	</div>

	<button type="submit" class="btn btn-info btn-lg" [disabled]="addImageForm.invalid"><i class="fa fa-share"></i> Image</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>

<h1>All Images by Member {{ image.imageProfileId }}</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Id</th><th>Submitter</th><th>FileName</th><th>Type</th><th>Delete</th></tr>
	<tr *ngFor="let image of images">
		<td>{{ image.imageId }}</td>
		<td>{{ image.imageProfileId }}</td>
		<td>{{ image.imageFileName }}</td>
		<td>{{ image.imageType }}</td>
		<td><a class="btn btn-warning" (click)="switchImage(image);"><i class="fa fa-ban" aria-hidden="true"></i></a></td>
	</tr>
</table>