<?php
define('dbServer', 'correzioni-devel-db');
//~ define('dbServer', '192.168.15.159');
define('dbUser', 'Olimpiadi');
define('dbPass', 'alfabeto');
define('dbName', 'CorOli');
define('ServerRoot', '/var/www/html/');
define('urlRoot', '');
define('UploadDirectory', '/home/user/uploads/'); // The owner of the folder should be the same as httpd process owner
//~ define('ServerRoot', '/afs/uz.sns.it/nobackup/dario2994/public_html/correzioni-olimpiadi');
//~ define('urlRoot', '/~dario2994/correzioni-olimpiadi');

// Email configuration (the default is a typical gmail configuration)
// 'EmailSMTP = false' implies the usage of local sendmail to send the email
// 'EmailSMTP = true' sends the email through the configured SMTP
define('EmailSMTP', true);
// In case of 'EmailSMTP = true', mail server information and authentication data
define('EmailHost', 'correzioni-devel-mail');
define('EmailPort', 1025); 
define('EmailUsername', 'username@gmail.com');
define('EmailPassword', 'password');
define('EmailSMTPAuth', false);
define('EmailSMTPSecure', 'none');

// The mail used to send corrections, verification codes and to receive any issues regarding the site
define('EmailAddress', 'username@gmail.com');
// The absolute path to PHPMailerAutoload.php
// If PHPMailer is in include_path, then you can define it as 'PHPMailerAutoload.php'
define('PHPMailerPath', '/var/www/PHPMailer-master');
// The max length of all the email addresses handled in the application.
define('EmailAddress_MAXLength', 63);

define('SessionDuration', 43200); // In seconds
define('ContestName_MAXLength', 255);
define('ContestName_MINLength', 2);
define('ContestNotAcceptedEmail_MAXLength', 8191);
define('username_MAXLength', 31);
define('username_MINLength', 3);
define('password_MAXLength', 63);
define('password_MINLength', 4);
define('ContestantName_MAXLength', 31);
define('ContestantSurname_MAXLength', 63);
define('ContestantSchool_MAXLength', 127);
define('ContestantSchoolCity_MAXLength', 127);
define('ProblemName_MAXLength', 31);
define('comment_MAXLength', 8191);
define('solutions_MAXSize', 20); // In Megabytes
define('VolunteerRequest_MAXSize', 4); // In Megabytes
