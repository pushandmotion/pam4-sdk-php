#!/bin/bash

./start-docker.sh

docker exec -it pam4sdk-testphp56 composer test tests/SdkTest.php
docker exec -it pam4sdk-testphp70 composer test tests/SdkTest.php