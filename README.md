# *Knt-Crafty*

## A php dependency injector

This is a fork of [Crafty](http://phpcrafty.sourceforge.net/).

[Original sources](http://sourceforge.net/projects/phpcrafty/) are available on [sourceforge](http://sourceforge.net/).

## Work in progress

For now, nothing has been specified nor fully tested.

### What has been done

 * Translation of existing tests from SimpleTest to [Atoum](http://www.atoum.org)
 * Creation of some functional tests using [Nette Tester](http://tester.nette.org/)
 * Using `Knt\Crafty` namespace instead of `Crafty_` prefixe
 * Addition of a default autoloader and a single entry point for the library: `Knt/Crafty/Crafty.php`

### To do 

 * More functional tests
 * *Real* unit tests

Wan't to take a look? Look at `tests/functional/Crafty/00 - Basic Usage` ;-).