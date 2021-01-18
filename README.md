# Dynamic Content Plugin

Adds a blocklist to fill whole pages with content blocks

## Components

- Xitara\DynamicContent\Components\BlockList

## Widgets

- none

## Available permissions

- none

## Available events

- xitara.dynamiccontent.beforeProcessBlock
```
Event::listen('xitara.dynamiccontent.beforeProcessBlock', function ($block) {
    return $block;
});
```
- xitara.dynamiccontent.afterProcessBlock
```
Event::listen('xitara.dynamiccontent.afterProcessBlock', function ($block) {
    return $block;
});
```
