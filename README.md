QueryParamValidatorBundle
===

Bundle helps you validate request query string values

[![Build Status](https://travis-ci.org/skowron-line/QueryParamValidatorBundle.svg?branch=master)](https://travis-ci.org/skowron-line/QueryParamValidatorBundle) [![codecov.io](https://codecov.io/github/skowron-line/QueryParamValidatorBundle/coverage.svg?branch=master)](https://codecov.io/github/skowron-line/QueryParamValidatorBundle?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/bf1aa441-a59a-4bbf-b47e-a852ee7c482a/mini.png)](https://insight.sensiolabs.com/projects/bf1aa441-a59a-4bbf-b47e-a852ee7c482a)



Installation
===

```
composer require skowronline/query-param-validator-bundle
```

```yml
// app/config.yml
imports:
    ...
    - { resource: '@SkowronlineQueryParamValidatorBundle/Resources/config/services.yml' }
```

Usage
===

```php
/**
 * @QueryParam("order", allowed={"asc", "desc"}, required=true)
 */
public function indexAction()
```

```
/route -> 404 Page Not Found
/route?order=asc -> 200 Ok
/route?order=desc -> 200 Ok
/route?order=random -> 404 Page Not Found
```

You can use multiple annotations

```php
/**
 * @QueryParam("order", allowed={"asc", "desc"}, required=true)
 * @QueryParam("page", required=false)
 */
public function indexAction()
```
