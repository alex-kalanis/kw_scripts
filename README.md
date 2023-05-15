# kw_scripts

[![Build Status](https://app.travis-ci.com/alex-kalanis/kw_scripts.svg?branch=master)](https://app.travis-ci.com/github/alex-kalanis/kw_scripts)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_scripts/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_scripts/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_scripts/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_scripts)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_scripts.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_scripts)
[![License](https://poser.pugx.org/alex-kalanis/kw_scripts/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_scripts)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_scripts/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_scripts/?branch=master)

Store scripts for simplified render after everything has been prepared.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_scripts": "1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader). Use example as reference.

2.) Initialize styles by calling "\kalanis\kw_scripts\Scripts::init()" in bootstrap

3.) Create render which uses "\kalanis\kw_scripts\Scripts::getAll()".

4.) Call "\kalanis\kw_scripts\Scripts::want()" in your controllers.

5.) Just run your site.
