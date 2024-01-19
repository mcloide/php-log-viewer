# PHP Log Viewer

This project shows a simple way to visualize Apache, PHP and any other logs for that matter in a very simple way. By default it will display Errors and Access logs. The log format is default one from Apache, so if another format is used, you will need to adjust the base function to better display the log.

## Requirement

As it is known, a script can't simply access a log file that is under `/var/log` without proper permissions and, to ensure some security of the server, the best way to solve this issue is by making Apache to pipe 2 log files. To make this possible, edit your apache configuration and replace the current entries for these ones:

```bash
ErrorLog "|/usr/bin/tee -a /var/log/apache2/error.log /var/www/html/logs/httpd-error.log"
CustomLog ${APACHE_LOG_DIR}/access.log combined
# New access log
CustomLog /var/www/html/logs/httpd-access.log combined
```

If you have a custom log format, you can still use it, just use Apache's pipe process to write to more than one file.

```bash
"|/usr/bin/tee -a ..."
```

Clone this repo into your favorite folder, create a VirtualHost for it (or not) and let it work for you.

## Issues/Suggestions

- Issues: Open an issue please
- Suggestions: Open a PR.
