# Dynamic Content Plugin

Adds a blocklist to fill whole pages with content blocks

## Components

- Xitara\VoodooBlocks\Components\Blocklist

## Widgets

- none

## Available permissions

- none

## Available events

- xitara.voodooblocks.beforeProcessBlock
```
Event::listen('xitara.voodooblocks.beforeProcessBlock', function ($block) {
    return $block;
});
```
- xitara.voodooblocks.afterProcessBlock
```
Event::listen('xitara.voodooblocks.afterProcessBlock', function ($block) {
    return $block;
});
```

## Todo:

- remove obsolete database tables
- remove obsolete models and controllers
- remove obsolete components
