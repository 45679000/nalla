<?php

/* List of installed additional extensions. If extensions are added to the list manually
	make sure they have unique and so far never used extension_ids as a keys,
	and $next_extension_id is also updated. More about format of this file yo will find in 
	FA extension system documentation.
*/

$next_extension_id = 4; // unique id for next installed extension

$installed_extensions = array (
  1 => 
  array (
    'name' => 'Thinker theme',
    'package' => 'thinker-theme',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/thinker',
  ),
  2 => 
  array (
    'name' => 'Theme Studio',
    'package' => 'studio',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/studio',
  ),
  3 => 
  array (
    'name' => 'Theme Exclusive for Dashboard',
    'package' => 'exclusive_db',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/exclusive_db',
  ),
);
