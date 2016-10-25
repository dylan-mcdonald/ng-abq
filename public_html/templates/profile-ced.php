<form #addProfileForm="ngForm" name="addProfileForm" id="addProfileForm" class="form-horizontal well" (ngSubmit)="createProfile();" novalidate>
	<h2>Create Profile</h2>

	<div class="form-group" [ngClass]="{ 'has-error': profileUserName.touched && profileUserName.invalid }">
		<label for="profile">Profile UserName</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="profile" id="profile" class="form-control" maxlength="50" required [(ngModel)]="profile.profileUserName" #profileUserName="ngModel" />
		</div>
	</div>

	<button type="submit" class="btn btn-info btn-lg" [disabled]="addProfileForm.invalid"><i class="fa fa-share"></i> Profile</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>

<h1>All Profiles by Member {{ profile.profileProfileUserName }}</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Id</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Edit</th><th>Delete</th></tr>
	<tr *ngFor="let profile of profiles">
		<td>{{ profile.profileId }}</td>
		<td>{{ profile.profileNameFirst }}</td>
		<td>{{ profile.profileNameLast }}</td>
		<td>{{ profile.profileUserName }}</td>
		<td>{{ profile.profileEmail }}</td>
		<td><a class="btn btn-warning" (click)="switchProfile(profile)"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		<td><a class="btn btn-warning" (click)="switchProfile(profile);"><i class="fa fa-ban" aria-hidden="true"></i></a></td>
	</tr>
</table>