UPGRADE FROM 1.2.x to 1.3
=======================

### Configuration

If you upgrade to version 1.3.x you have to check your configuration classes.
The ConfigurationInterace changes and two functions has been added.

```php
/**
  * Gets the request factory callback if it is set
  * This callback can be used to manipulate the request before its returned.
  *
  * @return \Closure
  */
public function getRequestFactory();
```

```php
/**
 * Gets the responsetransformer factory callback if it is set
 * This callback can be used to manipulate the request before its returned.
 *
 * @return \Closure
 */
public function getResponseTransformerFactory();
```
