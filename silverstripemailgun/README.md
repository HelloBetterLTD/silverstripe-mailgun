# silverstripe-mailgun
Mailgun integration for SilverStripe

Create a configfile with following contents

```yaml

---
Name: silverstripemailgun
---
SilverStripers\silverstripemailgun\Models\SilverStripersMailer:
  SMTPusername: 'Your mailgun SMTPLogin'
  SMTPpassword: 'Your mailgun password'
  
  
```