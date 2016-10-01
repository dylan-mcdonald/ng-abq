export class Profile {
	constructor(public profileId: number, public profileAdmin: boolean, public profileNameFirst: string, public profileNameLast: string, public profileEmail: string, public profileUserName: string, public profileSalt: string, public profileHash: string, public profileActivationToken: string) {}
}
