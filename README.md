# Benchmarking Azure and AWS
For benchmarking Azure and AWS (Cloud storage and CPU intensive tasks such as image resizing, etc.)

Azure - How to use blob storage from PHP<br>
https://azure.microsoft.com/en-us/documentation/articles/storage-php-how-to-use-blobs/

AWS SDK for PHP Documentation<br>
http://docs.aws.amazon.com/aws-sdk-php/v3/guide/getting-started/


#Requires<br>
#AWS account
- a VM instance (EC2 or a Elastic Beanstalk instance)
- S3 storage with an empty bucket. (NB: Very important, since the script completely deletes the bucket contents)
- API Key and Secret to the S3 account

#Azure account
- a VM instance (VM or a WebApp)
- Blob storage account with an empty container. (NB: Very important, since the script completely deletes the container contents)
- API Key to the Blob account
