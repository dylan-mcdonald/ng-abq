DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS oauthIdentity;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS attendee;
DROP TABLE IF EXISTS link;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS passwordReset;

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

CREATE TABLE event (
	eventId             INT UNSIGNED AUTO_INCREMENT NOT NULL,
	eventProfileId      TINYINT UNSIGNED DEFAULT 0  NOT NULL,
	eventName           VARCHAR(50)                 NOT NULL,
	eventDate           VARCHAR(50)                 NOT NULL,
	eventTime           VARCHAR(75)                 NOT NULL,
	PRIMARY KEY (eventId)
);

CREATE TABLE attendee (
	attendeeId              INT UNSIGNED AUTO_INCREMENT NOT NULL,
    attendeeEventId         TINYINT UNSIGNED DEFAULT 0  NOT NULL,
	attendeeProfileId       TINYINT UNSIGNED DEFAULT 0  NOT NULL,
	PRIMARY KEY (attendeeId)
);

CREATE TABLE link (
	eventId             INT UNSIGNED AUTO_INCREMENT NOT NULL,
	eventProfileId      TINYINT UNSIGNED DEFAULT 0  NOT NULL,
	eventName           VARCHAR(50)                 NOT NULL,
	eventDate           VARCHAR(50)                 NOT NULL,
	eventTime           VARCHAR(75)                 NOT NULL,
	PRIMARY KEY (eventId)
);

CREATE TABLE post (
	postId              INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postProfileUserName VARCHAR(50)                 NOT NULL,
	postSubmission      VARCHAR(50)                 NOT NULL,
	postTime            DATETIME                    NOT NULL,
	PRIMARY KEY (postId)
);

CREATE TABLE comment (
	commentId               INT UNSIGNED AUTO_INCREMENT NOT NULL,
	commentProfileUserName  VARCHAR(50)                 NOT NULL,
	commentSubmission       VARCHAR(50)                 NOT NULL,
	commentPostId           VARCHAR(50)                 NOT NULL,
	commentTime             DATETIME                    NOT NULL,
	PRIMARY KEY (commentId)
);

CREATE TABLE image (
	imageId       INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageFileName VARCHAR(128)                NOT NULL,
	imageType     VARCHAR(10)                 NOT NULL,
	UNIQUE (imageFileName),
	PRIMARY KEY (imageId)
);

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