DROP TABLE IF EXISTS attendee;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS link;
DROP TABLE IF EXISTS oauthIdentity;
DROP TABLE IF EXISTS passwordReset;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
  	profileId         INT UNSIGNED AUTO_INCREMENT NOT NULL,
  	profileAdmin      TINYINT UNSIGNED DEFAULT 0  NOT NULL,
  	profileNameFirst  VARCHAR(50)                 NOT NULL,
  	profileNameLast   VARCHAR(50)                 NOT NULL,
  	profileEmail      VARCHAR(75)                 NOT NULL,
  	profileUserName   VARCHAR(25)                 NOT NULL,
  	UNIQUE (profileUserName),
  	UNIQUE (profileEmail),
  	PRIMARY KEY (profileId)
);

CREATE TABLE post (
	postId              INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postProfileUserName VARCHAR(25)                 NOT NULL,
	postSubmission      VARCHAR(150)                 NOT NULL,
	postTime            DATETIME                    NOT NULL,
	FOREIGN KEY (postProfileUserName) REFERENCES profile (profileUserName),
	PRIMARY KEY (postId)
);

CREATE TABLE event (
	eventId             INT UNSIGNED AUTO_INCREMENT NOT NULL,
	eventProfileId      INT UNSIGNED						NOT NULL,
	eventName           VARCHAR(50)                 NOT NULL,
	eventDate           VARCHAR(50)                 NOT NULL,
	eventTime           VARCHAR(75)                 NOT NULL,
	FOREIGN KEY (eventProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (eventId)
);

CREATE TABLE passwordReset (
  	passwordResetId             INT UNSIGNED AUTO_INCREMENT NOT NULL,
  	passwordResetProfileId      INT UNSIGNED                NOT NULL,
  	passwordResetProfileEmail   VARCHAR(50)                 NOT NULL,
  	passwordResetToken          VARCHAR(50)                 NOT NULL,
  	passwordResetTime           DATETIME                    NOT NULL,
  	UNIQUE (passwordResetToken),
  	FOREIGN KEY (passwordResetProfileId) REFERENCES profile (profileId),
  	FOREIGN KEY (passwordResetProfileEmail) REFERENCES profile (profileEmail),
  	PRIMARY KEY (passwordResetId)
);

CREATE TABLE oauthIdentity (
	oauthIdentityId             INT UNSIGNED AUTO_INCREMENT NOT NULL,
	oauthIdentityProfileId      INT UNSIGNED                NOT NULL,
	oauthIdentityProviderId     CHAR(28)                    NOT NULL,
	oauthIdentityProvider       CHAR(28)                    NOT NULL,
	oauthIdentityAccessToken    CHAR(28)                    NOT NULL,
	oauthIdentityTimeStamp      DATETIME                    NOT NULL,
	FOREIGN KEY (oauthIdentityProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (oauthIdentityId)
);

CREATE TABLE link (
	linkId              INT UNSIGNED AUTO_INCREMENT     NOT NULL,
	linkProfileId       INT UNSIGNED                    NOT NULL,
	linkProfileUserName VARCHAR(25)                     NOT NULL,
	linkUrl             VARCHAR(100)                    NOT NULL,
	linkDate            DATETIME		                   NOT NULL,
	FOREIGN KEY (linkProfileId) REFERENCES profile (profileId),
	FOREIGN KEY (linkProfileUserName) REFERENCES profile (profileUserName),
	PRIMARY KEY (linkId)
);

CREATE TABLE image (
	imageId         INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageProfileId  INT UNSIGNED                NOT NULL,
	imageFileName   VARCHAR(128)                NOT NULL,
	imageType       VARCHAR(10)                 NOT NULL,
	UNIQUE (imageFileName),
	FOREIGN KEY (imageProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (imageId)
);

CREATE TABLE comment (
	commentId               INT UNSIGNED AUTO_INCREMENT NOT NULL,
	commentProfileUserName  VARCHAR(25)                 NOT NULL,
	commentPostId           INT UNSIGNED                NOT NULL,
	commentSubmission       VARCHAR(150)                NOT NULL,
	commentTime             DATETIME                    NOT NULL,
	FOREIGN KEY (commentPostId) REFERENCES post (postId),
	FOREIGN KEY (commentProfileUserName) REFERENCES profile (profileUserName),
	PRIMARY KEY (commentId)
);

CREATE TABLE attendee (
	attendeeId              INT UNSIGNED AUTO_INCREMENT NOT NULL,
  attendeeEventId         INT UNSIGNED                NOT NULL,
	attendeeProfileId       INT UNSIGNED                NOT NULL,
	FOREIGN KEY (attendeeEventId) REFERENCES event (eventId),
	FOREIGN KEY (attendeeProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (attendeeId)
);



