# kw_scripts

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
