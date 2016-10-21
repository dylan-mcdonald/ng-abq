<form *ngIf="edited === false" #addLinkForm="ngForm" name="addLinkForm" id="addLinkForm" class="form-horizontal well" (ngSubmit)="createLink();" novalidate>

<!--	<h2 *ngIf="edited === true">Edit Link</h2>-->
	<h2>Create Link</h2>

	<div class="form-group" [ngClass]="{ 'has-error': linkUrl.touched && linkUrl.invalid }">
		<label for="link">Link Url</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="link" id="link" class="form-control" maxlength="50" required [(ngModel)]="link.linkUrl" #linkUrl="ngModel" />
		</div>
	</div>

	<button  type="submit" class="btn btn-info btn-lg" [disabled]="addLinkForm.invalid"><i class="fa fa-share"></i> Link</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<form *ngIf="edited === true" #addLinkForm="ngForm" name="addLinkForm" id="addLinkForm" class="form-horizontal well" (ngSubmit)="changeLink();" novalidate>

	<h2>Edit Link</h2>

	<table class="table table-bordered table-responsive table-striped table-word-wrap">
		<tr><th>Id</th><th>Submitter</th><th>Url</th><th>Submitted</th><th>Edit</th><th>Delete</th></tr>

			<td>{{ link.linkId }}</td>
			<td>{{ link.linkProfileUserName }}</td>
			<td>{{ link.linkUrl }}</td>
			<td>{{ link.linkDate.date | date: 'mm-dd-y @ HH:mm' }}</td>


	</table>

	<div class="form-group" [ngClass]="{ 'has-error': linkUrl.touched && linkUrl.invalid }">
		<label for="link">Link Url</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="link" id="link" class="form-control" maxlength="50" required [(ngModel)]="link.linkUrl" #linkUrl="ngModel" />
		</div>
	</div>

	<button  type="submit" class="btn btn-info btn-lg" [disabled]="addLinkForm.invalid"><i class="fa fa-share"></i> Link</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>

<h1>All Links by Member {{ link.linkProfileUserName }}</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Id</th><th>Submitter</th><th>Url</th><th>Submitted</th><th>Edit</th><th>Delete</th></tr>
	<tr *ngFor="let link of links">
		<td>{{ link.linkId }}</td>
		<td>{{ link.linkProfileUserName }}</td>
		<td>{{ link.linkUrl }}</td>
		<td>{{ link.linkDate.date | date: 'mm-dd-y @ HH:mm' }}</td>
		<td><a class="btn btn-warning" (click)="switchLink(link)"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		<td><a class="btn btn-warning" (click)="deleteLink(link);"><i class="fa fa-ban" aria-hidden="true"></i></a></td>
	</tr>
</table>