<?php

/* List of installed additional extensions. If extensions are added to the list manually
	make sure they have unique and so far never used extension_ids as a keys,
	and $next_extension_id is also updated. More about format of this file yo will find in 
	FA extension system documentation.
*/

$next_extension_id = 18; // unique id for next installed extension

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
  4 => 
  array (
    'name' => 'Import Transactions',
    'package' => 'import_transactions',
    'version' => '2.4.0-6',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/import_transactions',
  ),
  5 => 
  array (
    'name' => 'Inventory Items CSV Import',
    'package' => 'import_items',
    'version' => '2.4.0-3',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/import_items',
  ),
  6 => 
  array (
    'name' => 'Cash Flow Statement Report',
    'package' => 'rep_cash_flow_statement',
    'version' => '2.4.0-2',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_cash_flow_statement',
  ),
  7 => 
  array (
    'name' => 'Dated Stock Sheet',
    'package' => 'rep_dated_stock',
    'version' => '2.4.0-1',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_dated_stock',
  ),
  8 => 
  array (
    'name' => 'Requisitions',
    'package' => 'requisitions',
    'version' => '2.4.0-3',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/requisitions',
  ),
  9 => 
  array (
    'name' => 'Report Generator',
    'package' => 'repgen',
    'version' => '2.4.0-4',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/repgen',
  ),
  10 => 
  array (
    'name' => 'Tax inquiry and detailed report on cash basis',
    'package' => 'rep_tax_cash_basis',
    'version' => '2.4.0-1',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_tax_cash_basis',
  ),
  11 => 
  array (
    'name' => 'Bank Statement w/ Reconcile',
    'package' => 'rep_statement_reconcile',
    'version' => '2.4.0-1',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_statement_reconcile',
  ),
  12 => 
  array (
    'name' => 'Sales Summary Report',
    'package' => 'rep_sales_summary',
    'version' => '2.4.0-1',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_sales_summary',
  ),
  13 => 
  array (
    'name' => 'Inventory History',
    'package' => 'rep_inventory_history',
    'version' => '2.4.0-1',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_inventory_history',
  ),
  14 => 
  array (
    'name' => 'Annual expense breakdown report',
    'package' => 'rep_annual_expense_breakdown',
    'version' => '2.4.0-2',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_annual_expense_breakdown',
  ),
  15 => 
  array (
    'name' => 'Annual balance breakdown report',
    'package' => 'rep_annual_balance_breakdown',
    'version' => '2.4.0-4',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_annual_balance_breakdown',
  ),
  16 => 
  array (
    'name' => 'osCommerce Order and Customer Import Module',
    'package' => 'osc_orders',
    'version' => '2.4.0-3',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/osc_orders',
  ),
  17 => 
  array (
    'name' => 'Import Multiple Journal Entries',
    'package' => 'import_multijournalentries',
    'version' => '2.4.0-3',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/import_multijournalentries',
  ),
);
