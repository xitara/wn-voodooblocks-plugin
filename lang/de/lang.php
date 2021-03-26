<?php return [
    'plugin' => [
        'name' => 'Dynamic Content',
        'description' => 'Dynamischer Content einbindbar über Komponenten und Snippets',
        'author' => 'Xitara Websolution',
        'icon' => 'icon-leaf',
        'iconSvg' => '/plugins/xitara/dynamiccontent/assets/images/dynamiccontent-icon.svg',
        'homepage' => 'https://xitara.net',
    ],
    'submenu' => [
        'label' => 'Dynamischer Content',
        'text' => 'Texte',
        'group' => 'Gruppen',
        'blocklist' => 'Block Listen',
        'blockgroup' => 'Block Gruppen',
    ],
    'tab' => [
        'data' => 'Statischer Inhalt',
        'images' => 'Bilder',
        'slider' => 'Slider',
        'lightbox' => 'Lightbox',
        'dynamic_content' => 'Dynamischer Inhalt',
        'dynamic_content_prompt' => 'Neuer Inhalt',
        'time_control' => 'Zeiteinstellung',
        'buttons' => 'Buttons',
    ],
    'prompt' => [
        'images' => 'Neues Bild',
    ],
    'controller' => [
        'text' => 'Text',
        'group' => 'Gruppe',
        'new_block' => 'Neuen Block anlegen',
        'is_heading' => 'Überschrift und Unterüberschrift anzeigen',
        'section_blocks' => 'Blockliste',
        'section_blocks_comment' => 'Maximale Anzahl der Blöcke ist auf 24 begrenzt. Das resultiert aus der Standardeinstellung "max_input_vars = 1000" auf Webservern. Werden mehr Blöcke benötigt, können mehrere Blocklisten über "Block Gruppen" zusammengefasst werden<br>Alle Blöcke gleichzeitig auf- und zuklappen: Strg + Mausklick auf <i class="icon-chevron-up"></i>',
    ],
    'manual' => [
        'heading' => 'Anleitung für Platzhalter im Text',
        'description' => 'Folgende Liste zeigt die vorhandenen Komponenten/Snippets und die zugehörigen Platzhalter.',
    ],
    'comments' => [
        'excerpt' => 'Optional. Falls nicht angegeben, wird ggf. direkt das Feld "Inhalt" ausgespielt.',
    ],
    'no_blocklist' => '--- keine Blockliste ---',
];
