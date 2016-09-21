### PHP PSR linter library

## About

psrlint script that tokenizes PHP files to detect violations of a defined coding standard and automatically correct coding standard violations.

[![Build Status](https://travis-ci.org/koktut/hexlet-psr-linter.svg?branch=master)](https://travis-ci.org/koktut/hexlet-psr-linter)
[![Code Climate](https://codeclimate.com/github/koktut/hexlet-psr-linter/badges/gpa.svg)](https://codeclimate.com/github/koktut/hexlet-psr-linter)
[![Issue Count](https://codeclimate.com/github/koktut/hexlet-psr-linter/badges/issue_count.svg)](https://codeclimate.com/github/koktut/hexlet-psr-linter)
[![Test Coverage](https://codeclimate.com/github/koktut/hexlet-psr-linter/badges/coverage.svg)](https://codeclimate.com/github/koktut/hexlet-psr-linter/coverage)

## Requirements

* PHP >= 7.0
* Composer

## Installation

Install hexlet-psr-linter system-wide with the following command:

```
composer global require "koktut/hexlet-psr-linter=dev-master"
```

Make sure you have ~/.composer/vendor/bin/ in your PATH.

Or alternatively, include a dependency for koktut/hexlet-psr-linter in your composer.json file. For example:

```
{
    "require-dev": {
        "koktut/hexlet-psr-linter": "dev-master"
    }
}
```

You will then be able to run hexlet-psr-linter from the vendor bin directory:

```
./vendor/bin/psrlint -h
```

You can also download the hexlet-psr-linter source and run the psrlint command directly from the Git clone:

```
git clone https://github.com/koktut/hexlet-psr-linter.git
make install
php scripts/psrlint -h
```

## Demo

[![asciicast](https://asciinema.org/a/et0o7khsqd319zi6qt4hylt2g.png)](https://asciinema.org/a/et0o7khsqd319zi6qt4hylt2g)
