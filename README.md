# Project 2
+ By: Chutian Gao
+ Production URL: <http://p2.findcharlie.me>

## Outside resources
+ Bootstrap 3.3: <https://getbootstrap.com/docs/3.3/getting-started/>
+ Form Class: <https://github.com/susanBuck/dwa15-php/blob/master/includes/Form.php>

## Code style divergences
+ When definning variables, I used multiple spaces before `=`  in order to make the values are aligned. 
+ In Associate Arrays, I used multiple spaces before or after `=>` in order to make the keys and values are aligned to the left. 

## Notes for instructor
+ I edited `Form.php` and added one parameter to function `validation()` so that it can display customized field names (titles).
+ Also replaced `ctype_digit()` with `is_numeric()` used by `numeric()` function in `Form` Class becauce `ctype_digit($dollars)` returns `false` when `$dollars` is a float.