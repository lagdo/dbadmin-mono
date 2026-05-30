#/bin/bash

# Set the AWS CLI options

aws configure set --profile dbadmin aws_access_key_id fake
aws configure set --profile dbadmin aws_secret_access_key fake
aws configure set --profile dbadmin region us-east-1
aws configure set --profile dbadmin output json
