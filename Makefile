build:
	docker build . -t asyncphp

run-sync:
	docker run -v $(shell pwd)/sync:/app:rw -p 8080:8080 -t asyncphp php index.php

run-reactphp:
	docker run -v $(shell pwd)/reactphp:/app:rw -p 8080:8080 -t asyncphp php index.php

bash:
	docker run --user $(shell id -u) -v $(shell pwd):/app -it asyncphp bash