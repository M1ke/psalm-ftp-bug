# Psalm Bug

This is a quick repo designed to show [an issue we've seen in Psalm](https://github.com/vimeo/psalm/issues/3340) in our codebase.

By having a certain package installed Psalm hard crashes without any output during a run.

This occurs even if the `vendor/` directory is ignored in `psalm.xml`.

## Pre-setup

To make the `composer.lock` file we ran the following in a PHP 7.2 environment:

```
composer require "dg/ftp:dev-master"
composer require --dev "vimeo/psalm"
```

Both packages installed with no issues.

## Crash

```
$ composer install
$ vendor/bin/psalm

Uncaught Psalm\Exception\TypeParseTreeException: Intersection types must be all objects or all object-like arrays, Psalm\Type\Atomic\TString provided in /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Type.php:586
Stack trace:
#0 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/Analyzer/CommentAnalyzer.php(1041): Psalm\Type::getTypeFromTree(Object(Psalm\Internal\Type\ParseTree\IntersectionTree), Object(Psalm\Codebase))
#1 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/PhpVisitor/ReflectorVisitor.php(1105): Psalm\Internal\Analyzer\CommentAnalyzer::extractClassLikeDocblockInfo(Object(PhpParser\Node\Stmt\Class_), Object(PhpParser\Comment\Doc), Object(Psalm\Aliases))
#2 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/PhpVisitor/ReflectorVisitor.php(272): Psalm\Internal\PhpVisitor\ReflectorVisitor->registerClassLike(Object(PhpParser\Node\Stmt\Class_))
#3 /home/m1ke/php/psalm-ftp-bug/vendor/nikic/php-parser/lib/PhpParser/NodeTraverser.php(200): Psalm\Internal\PhpVisitor\ReflectorVisitor->enterNode(Object(PhpParser\Node\Stmt\Class_))
#4 /home/m1ke/php/psalm-ftp-bug/vendor/nikic/php-parser/lib/PhpParser/NodeTraverser.php(91): PhpParser\NodeTraverser->traverseArray(Array)
#5 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/Scanner/FileScanner.php(94): PhpParser\NodeTraverser->traverse(Array)
#6 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/Codebase/Scanner.php(586): Psalm\Internal\Scanner\FileScanner->scan(Object(Psalm\Codebase), Object(Psalm\Storage\FileStorage), false, Object(Psalm\Progress\DefaultProgress))
#7 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/Codebase/Scanner.php(367): Psalm\Internal\Codebase\Scanner->scanFile('/home/m1ke/php/...', Array, false)
#8 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/Codebase/Scanner.php(475): Psalm\Internal\Codebase\Scanner->Psalm\Internal\Codebase\{closure}(0, '/home/m1ke/php/...')
#9 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/Codebase/Scanner.php(325): Psalm\Internal\Codebase\Scanner->scanFilePaths(1)
#10 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Codebase.php(477): Psalm\Internal\Codebase\Scanner->scanFiles(Object(Psalm\Internal\Codebase\ClassLikes), 3)
#11 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/Psalm/Internal/Analyzer/ProjectAnalyzer.php(519): Psalm\Codebase->scanFiles(3)
#12 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/src/psalm.php(588): Psalm\Internal\Analyzer\ProjectAnalyzer->check('/home/m1ke/php/...', false)
#13 /home/m1ke/php/psalm-ftp-bug/vendor/vimeo/psalm/psalm(2): require_once('/home/m1ke/php/...')
#14 {main}
(Psalm 3.11.2@d470903722cfcbc1cd04744c5491d3e6d13ec3d9 crashed due to an uncaught Throwable)
```

