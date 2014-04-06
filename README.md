# *Knt-Crafty*

## A php dependency injector

This is a fork of [Crafty](http://phpcrafty.sourceforge.net/), a php dependency injector.

[Original sources](http://sourceforge.net/projects/phpcrafty/) are available on [sourceforge](http://sourceforge.net/).

## Work in progress

For now, the work is in progress and nothing has been specified nor fully tested yet.

What has been accomplished now:

 * Translation of existing tests from SimpleTest to [Atoum](http://www.atoum.org)
 * Creation of some functional tests using [Nette Tester](http://tester.nette.org/)
 * Using `Knt\Crafty` namespaces instead of `Crafty_` prefixes
 * Addition of a default autoloader and a single entry point for the library: Knt/Crafty/Crafty.php
