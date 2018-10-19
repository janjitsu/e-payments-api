#!/bin/bash

# this script will download google cloud instance metadata and add them to gcloud instance as env vars
# use it like 
# export "$(./inject-metadata.sh)"

VARIABLES=(
        PAGSEGURO_TOKEN_PRODUCTION
        PAGSEGURO_APP_ID_PRODUCTION
        PAGSEGURO_APP_KEY_PRODUCTION
        PAGSEGURO_ENV
        PAGSEGURO_EMAIL
)

for env_var in "${VARIABLES[@]}"; do
        request=`curl -s http://metadata.google.internal/computeMetadata/v1/project/attributes/$env_var -H "Metadata-Flavor: Google"`
        echo "${env_var}=${request}"
done;

