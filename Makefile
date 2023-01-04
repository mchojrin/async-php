build:
	docker-compose build

up:
	docker-compose up -d

run-sync:
	docker-compose run php cd sync; php index.php

run-reactphp:
	docker run -v $(shell pwd)/reactphp:/app:rw -p 8080:8080 -t asyncphp php index.php

run-guzzle:
	docker run -v $(shell pwd)/guzzle:/app:rw -p 8080:8080 -t asyncphp php index.php

run-spatie:
	docker run -v $(shell pwd)/spatie:/app:rw -p 8080:8080 -t asyncphp php index.php

run-amphp:
	docker run -v $(shell pwd)/amphp:/app:rw -p 8080:8080 -t asyncphp php index.php

bash:
	docker run --user $(shell id -u) -v $(shell pwd):/app -it asyncphp bash

root-bash:
	docker run --user $(shell id -u) -v $(shell pwd):/app -it asyncphp bash