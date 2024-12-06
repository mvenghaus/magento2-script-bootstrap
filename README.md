# Magento 2 - Script Bootstrap

## Run your (quick & dirty) scripts with the usual comfort 

Sometimes, you might want to run small Magento scripts without creating an additional module for them. 
To achieve this, you need to bootstrap Magento yourself. 
This is where this module comes in handy, it manages the bootstrap process for you. 

What are the benefits?

- instant setup (1 simple file)
- no module means no deployment (setup:upgrade, ...)

## Installation

```bash
composer require mvenghaus/magento2-script-bootstrap
```

**NOTE** It's not a magento module so you don't have to run setup:upgrade.

## Basic Example 

Let's assume you have a folder "scripts" in your root directory.

scripts/hello-world.php
```php
<?php declare(strict_types=1);

use Mvenghaus\ScriptBootstrap\Bootstrap;
use Mvenghaus\ScriptBootstrap\Contracts\ScriptInterface;

use Magento\Framework\Filter\TranslitUrl;

// magento bootstrap
require __DIR__ . '/../app/bootstrap.php';

class Script implements ScriptInterface
{
    public function __construct(
        private readonly TranslitUrl $translitUrl,
    ) {
    }

    public function run(): void
    {
        echo $this->translitUrl->filter('Hello World');
    }
}

Bootstrap::run(Script::class);
```

### Just run it
```bash
php script/hello-world.php
```

## Modfiy the enviroment

You can use the following PHP attributes on your ```run``` method to modify your environment.

### #[SetAreaCode]

You can easily update your area code with this attribute.

```php
#[SetArea(\Magento\Framework\App\Area::AREA_ADMINHTML)]
```

### #[SetSecureArea]

Certain operations, such as deleting in Magento, need to be performed within a 'secure area.' This attribute activates that functionality. 

```php
#[SetSecureArea]
```

## Example

```php
...
    #[SetArea(\Magento\Framework\App\Area::AREA_ADMINHTML)]
    #[SetSecureArea]
    public function run(): void
    {
        echo $this->translitUrl->filter('Hello World');
    }

...
```