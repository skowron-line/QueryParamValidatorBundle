QueryParamValidatorBundle
===

Bundle helps you validate request query string values

[![Build Status](https://travis-ci.org/skowron-line/QueryParamValidatorBundle.svg?branch=master)](https://travis-ci.org/skowron-line/QueryParamValidatorBundle) [![codecov.io](https://codecov.io/github/skowron-line/QueryParamValidatorBundle/coverage.svg?branch=master)](https://codecov.io/github/skowron-line/QueryParamValidatorBundle?branch=master)



Installation
===

```
composer require skowronline/query-param-validator-bundle
```

Usage
===

```php
<?php

/**
 * @QueryParam("order", allowed={"asc", "desc"}, required=true)
 */
public function indexAction()
```
