<a href="https://aimeos.org/">
    <img src="https://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos Swiftmailer adapter

[![Build Status](https://travis-ci.org/aimeos/ai-swiftmailer.svg)](https://travis-ci.org/aimeos/ai-swiftmailer)
[![Coverage Status](https://coveralls.io/repos/aimeos/ai-swiftmailer/badge.svg?branch=master)](https://coveralls.io/r/aimeos/ai-swiftmailer?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aimeos/ai-swiftmailer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aimeos/ai-swiftmailer/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/aimeos/ai-swiftmailer.svg)](http://hhvm.h4cc.de/package/aimeos/ai-swiftmailer)

The Aimeos web shop components can integrate into almost any PHP application and uses the infrastructure of the application for building URLs, caching content, configuration settings, logging messages, session handling, sending e-mails or handling translations.

The ai-swiftmailer extension integrates the PHP Swiftmailer library for handling e-mails into Aimeos. It's required if your application uses Swiftmailer for sending e-mails and offers access to a Swiftmailer object that can be used together with this extension.

## Table of content

- [Installation](#installation)
- [Setup](#setup)
- [License](#license)
- [Links](#links)

## Installation

To allow the Aimeos web shop components accessing the e-mail infrastructure of your own framework or application, you have to install the adapter first. As every Aimeos extension, the easiest way is to install it via [composer](https://getcomposer.org/). If you don't have composer installed yet, you can execute this string on the command line to download it:
```
php -r "readfile('https://getcomposer.org/installer');" | php -- --filename=composer
```

Add the ai-swiftmailer extension to the "require" section of your ```composer.json``` file:
```
"require": [
    "aimeos/ai-swiftmailer": "dev-master",
    ...
],
```
If you don't want to use the latest version, you can also install any release. The list of releases is available at [Packagist](https://packagist.org/packages/aimeos/ai-swiftmailer). Afterwards you only need to execute the composer update command on the command line:
```
composer update
```

## Setup

Now add the Swiftmailer object to the Aimeos context, which you have to create to get the Aimeos components running:
```
// $app is an object that can create the Swiftmailer object 
$closure = function() use ( $app ) {
    return $app->getSwiftMailer();
};

$mail = new MW_Mail_Swift( $closure );
$context->setMail( $mail );
```
Initializing and creating a Swiftmailer object is a resource intensive task. Therefore, it's best to avoid passing the Swiftmailer object directly to the ```MW_Mail_Swift``` constructor (which is also possible) but to use a closure that can create the object on demand.

## License

The Aimeos ai-swiftmailer extension is licensed under the terms of the LGPLv3 license and is available for free.

## Links

* [Web site](https://aimeos.org/)
* [Documentation](https://aimeos.org/docs)
* [Help](https://aimeos.org/help)
* [Issue tracker](https://github.com/aimeos/ai-swiftmailer/issues)
* [Source code](https://github.com/aimeos/ai-swiftmailer)
