## Websites Response Checker project powered by Yii2

### Disclaimer
This is very basic structure, I"ll plan to make it less ugly and add user authentication in course of time.

## Installation
```bash
$ git clone https://github.com/Alexey-654/websites-response-checker.git
```

```bash
$ composer install
```

Inside repo alredy set test sqlite database, so you do not need to settle it by yourself.

Run Development Server and take a look on project.

```bash
$ php yii serve
```

To run email notification in case server is not responding you should need to add cron task

In Ubuntu run.

```bash
$ crontab -e
```

Then add task to file.
Do not forget to change path to project folder and your email

```bash
2 * * * * php path-to-project/yii_check_website_response/yii website-checker/send-email-on-bad email-report-recipient@example.com
```
