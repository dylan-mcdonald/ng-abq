<form *ngIf="edited === false" #addProfileForm="ngForm" name="addProfileForm" id="addProfileForm" class="form-horizontal well" (ngSubmit)="createProfile();" novalidate>
	<h2>Create Profile</h2>

	<div class="form-group" [ngClass]="{ 'has-error': profileNameFirst.touched && profileUserName.invalid }">
		<label for="first">First Name</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="first" id="first" class="form-control" maxlength="50" required [(ngModel)]="profile.profileNameFirst" #profileNameFirst="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': profileNameLast.touched && profileUserName.invalid }">
		<label for="last">Last Name</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="last" id="last" class="form-control" maxlength="50" required [(ngModel)]="profile.profileNameLast" #profileNameLast="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': profileUserName.touched && profileUserName.invalid }">
		<label for="user">Username</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="user" id="user" class="form-control" maxlength="50" required [(ngModel)]="profile.profileUserName" #profileUserName="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': profileEmail.touched && profileUserName.invalid }">
		<label for="email">Email</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="email" id="email" class="form-control" maxlength="50" required [(ngModel)]="profile.profileEmail" #profileEmail="ngModel" />
		</div>
	</div>

	<button type="submit" class="btn btn-info btn-lg" [disabled]="addProfileForm.invalid"><i class="fa fa-share"></i> Profile</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<form *ngIf="edited === true" #addProfileForm="ngForm" name="addProfileForm" id="addProfileForm" class="form-horizontal well" (ngSubmit)="changeProfile();" novalidate>
	<h2>Edit Profile</h2>

	<div class="form-group" [ngClass]="{ 'has-error': profileNameFirst.touched && profileUserName.invalid }">
		<label for="first">First Name</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="first" id="first" class="form-control" maxlength="50" required [(ngModel)]="profile.profileNameFirst" #profileNameFirst="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': profileNameLast.touched && profileUserName.invalid }">
		<label for="last">Last Name</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="last" id="last" class="form-control" maxlength="50" required [(ngModel)]="profile.profileNameLast" #profileNameLast="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': profileUserName.touched && profileUserName.invalid }">
		<label for="user">Username</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="user" id="user" class="form-control" maxlength="50" required [(ngModel)]="profile.profileUserName" #profileUserName="ngModel" />
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': profileEmail.touched && profileUserName.invalid }">
		<label for="email">Email</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="email" id="email" class="form-control" maxlength="50" required [(ngModel)]="profile.profileEmail" #profileEmail="ngModel" />
		</div>
	</div>

	<button type="submit" class="btn btn-info btn-lg" [disabled]="addProfileForm.invalid"><i class="fa fa-share"></i> Profile</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>

<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>

<h1>Member Profile</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Edit</th><th>Delete</th></tr>
	<tr *ngFor="let profile of profiles">
		<td>{{ profile.profileNameFirst }}</td>
		<td>{{ profile.profileNameLast }}</td>
		<td>{{ profile.profileUserName }}</td>
		<td>{{ profile.profileEmail }}</td>
		<td><a class="btn btn-warning" (click)="switchProfile(profile)"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
		<td><a class="btn btn-warning" (click)="deleteProfile(profile);"><i class="fa fa-ban" aria-hidden="true"></i></a></td>
	</tr>
</table>