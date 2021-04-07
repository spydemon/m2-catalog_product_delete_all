# Magento 2 — Catalog Product Delete All

## Aim of the module

This Magento 2 module purpose is to provide a simple helper that contain a method that will erase all products in database and all product medias.

## What you still have to do

Just inject the `DeleteAllProducts` helper in the class you need it, and use it.

## Warnings

* Check that indexers are updated by schedule, and not at each save. The deletion will be really long if it's not the case since a reindex will be done between each delete!
* The purpose of this module is more to help developers to save time instead of providing ready to use tools.
Don't expect to be able to use it out of the box without a minimal integration on your side.

## Compatibility

This module was tested on the Magento versions that follows.

| Version | State |
| ------- | ----- |
| 2.3.6 | Works |

## How to install it

Using Composer for installing this module is the best way:

```
composer require spydemon/m2-catalog_product_delete_all
```

## Help appreciated

If you like this module and find a bug or an enhancement, don't hesitate to fill an issue, or even better: a pull request. 😀
