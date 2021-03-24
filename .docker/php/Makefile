server := "root@server.com"

.PHONY: dump
dump: wp-cli.phar
	php wp-cli.phar search-replace "http://localhost:8000" "http://monsite.fr" --export=dump.sql
	rsync -avH .dump.sql ssh $(server):/home/wwww/dump.sql
	ssh $(server)  'cd /home/www/ && make import'
	rm dump.sql

.PHONY: import
import: wp-cli.phar
	php wp-cli.phar db import dump.sql

wp-cli.phar:
	curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar