# silverstripe-mailgun
Mailgun integration for SilverStripe

Create a configfile with following contents

```

---
Name: silverstripemailgun
---
SilverStripers\silverstripemailgun\Models\SilverStripersMailer:
  SMTPusername: 'Your mailgun SMTPLogin'
  SMTPpassword: 'Your mailgun password'
  
  
```

## Installation

Use composer to install on your SilverStripe 4 website.

```
composer require silverstripers/silverstripe-mailgun dev-master
```