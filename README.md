# Talend Job Manager

A tool for manage Talend job (zip format) for your application.

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?logo=php)](https://php.net/)
[![Talend Version](https://img.shields.io/badge/talend-%3E%3D%205.x-red?logo=talend)](https://www.talend.com/fr/products/talend-open-studio/)

## Installation

You can install this lib in your PHP project using composer:

    composer require inzh/talend-job-manager

## Build your job

On first, you need to build your job with Talend, tested with Talend Open Studio. 

Just right click on your job and select in menu:

![Menu image example](data:image/png;base64,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)

File output example:

```bash
myjobname_0.1.zip
```
## Development:

You can use directly executor class in your code, for example:


- For add or update job in repository

```php
use inzh\talend\job\manager\executor\SimpleJobExecutor;

$path = "myjobname_0.1.zip"; // Your job zip file 
$repositoryPath = "jobs"; // Your repository path

SimpleJobExecutor::put($path, $repositoryPath);
```

- To run the latest version of job :

```php
use inzh\talend\job\manager\executor\SimpleJobExecutor;

$jobName = "myjobname"; // Your job name
$repositoryPath = "jobs"; // Your repository path
$parameters = ["contextparam1" => "value1", "contextparam2" => "value2"]; // Context parameters passed to job

$output = SimpleJobExecutor::execute($jobName, $parameters, $repositoryPath);
print_r($output);
```

- To run the specific version of job :

```php
use inzh\talend\job\manager\executor\SimpleJobExecutor;

$jobName = "myjobname"; // Your job name
$repositoryPath = "jobs"; // Your repository path
$parameters = ["contextparam1" => "value1", "contextparam2" => "value2"]; // Context parameters passed to job
$version = 0.1;

$output = SimpleJobExecutor::execute($jobName, $parameters, $repositoryPath, $version);
print_r($output);
```
#

[© 2011-2022 [InZH] Studio.](https://www.inzh.fr/)