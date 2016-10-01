export class PasswordReset {
	constructor(public passwordResetId: number, public passwordResetProfileId: number, public passwordResetProfileEmail: string, public passwordResetToken: string, public passwordResetTime: string) {}
}