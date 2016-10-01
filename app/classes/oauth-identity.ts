export class OauthIdentity {
	constructor(public oauthIdentityId: number, public oauthIdentityProfileId: number, public oauthIdentityProviderId: string, public oauthIdentityProvider: string, public oauthIdentityAccessToken: string, public oauthIdentityTimeStamp: string) {}
}