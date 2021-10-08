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
        'options' => 'Grundeinstellungen',
        'content' => 'Statischer Inhalt',
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
        'excerpt' => 'Text wird <b>über</b> ggf. vorhandenen Bildern / Buttons ausgegeben',
        'content' => 'Text wird <b>unter</b> ggf. vorhandenen Bildern / Buttons ausgegeben',
    ],
    'no_blocklist' => '--- keine Blockliste ---',
];
