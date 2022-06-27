<?php return [
    'plugin'           => [
        'name'        => 'Dynamic Content',
        'description' => 'Dynamischer Content einbindbar über Komponenten und Snippets',
        'author'      => 'Xitara Websolution',
        'icon'        => 'icon-leaf',
        'iconSvg'     => '/plugins/xitara/dynamiccontent/assets/images/dynamiccontent-icon.svg',
        'homepage'    => 'https://xitara.net',
    ],
    'submenu'          => [
        'label'      => 'Dynamischer Content',
        'text'       => 'Texte',
        'group'      => 'Gruppen',
        'blocklist'  => 'Block Listen',
        'blockgroup' => 'Block Gruppen',
    ],
    'tab'              => [
        'options'         => 'Grundeinstellungen',
        'content'         => 'Statischer Inhalt',
        'images'          => 'Bilder',
        'slider'          => 'Slider',
        'lightbox'        => 'Lightbox',
        'dynamic_content' => 'Dynamischer Inhalt',
        'time_control'    => 'Zeiteinstellung',
        'buttons'         => 'Buttons',
    ],
    'manual' => [
        'heading' => 'Platzhalter Übersicht',
        'description' => 'Übesicht über alle verfügbaren Platzhalter, sortiert nach
            Modulen. Die Platzhalter werden immer dann ersetzt, wenn das
            entspürechende Modul ausgewählt wurde',
    ],
    'heading'          => [
        'label'   => 'Überschrift',
        'comment' => '',
    ],
    'subheading'       => [
        'label'   => 'Unterüberschrift',
        'comment' => '',
    ],
    'slug'             => [
        'label'   => 'Slug',
        'comment' => '',
    ],
    'active'           => [
        'label'   => 'Aktiv',
        'comment' => '',
    ],
    'section_blocks'   => [
        'label'   => 'Blockliste',
        'comment' => 'Maximale Anzahl der Blöcke ist auf 24 begrenzt. Das resultiert aus der Standardeinstellung "max_input_vars = 1000" auf Webservern. Werden mehr Blöcke benötigt, können mehrere Blocklisten über "Block Gruppen" zusammengefasst werden<br>Alle Blöcke gleichzeitig auf- und zuklappen: Strg + Mausklick auf <i class="icon-chevron-up"></i><br><br>Die Reihenfolge der Anzeige: Vorspann -> Bilder/Slider -> Buttons -> Inhalt -> Buttons',
    ],
    'new_block'        => [
        'label'   => '',
        'comment' => '',
        'prompt'  => 'Neuer Block',
    ],
    'width'            => [
        'label'   => 'Breite',
        'comment' => '',
    ],
    'height'           => [
        'label'   => 'Höhe',
        'comment' => '',
    ],
    'excerpt'          => [
        'label'   => 'Vorspann',
        'comment' => 'Wird an Anfang der Box angezeigt. Vorhandene Buttons/Slider/Bilder folgen.',
    ],
    'content'          => [
        'label'   => 'Inhalt',
        'comment' => 'Wird nach vorhandenen Buttons/Slider/Bilder angezeigt, als am Ende der Box',
    ],
    'buttons_above'    => [
        'label'  => 'Button(s) zwischen "Vorspann" und "Inhalt"',
        'prompt' => 'Neuen Button hinzufügen',
    ],
    'buttons'          => [
        'label'  => 'Button(s) unter dem restlichen Inhalt',
        'prompt' => 'Neuen Button hinzufügen',
    ],
    'button'           => [
        'classes'    => [
            'label'   => 'Zusätzliche CSS-Klassen',
            'comment' => '',
        ],
        'label'      => [
            'label'   => 'Beschriftung',
            'comment' => '',
        ],
        'link'       => [
            'label'   => 'Link',
            'comment' => '',
        ],
        'icon_left'  => [
            'label'   => 'Icon links',
            'comment' => '',
        ],
        'icon_right' => [
            'label'   => 'Icon rechts',
            'comment' => '',
        ],
    ],
    'images'           => [
        'label'   => '',
        'comment' => '',
        'prompt'  => 'Neues Bild',
    ],
    'image'            => [
        'label'       => [
            'label'   => 'Bild',
            'comment' => '',
        ],
        'link'        => [
            'label'   => 'Link',
            'comment' => '',
        ],
        'url'        => [
            'label'   => 'URL',
            'comment' => 'Wird ignoriert, wenn ein Bild aus der Mediengalerie ausgewählt wurde',
        ],
        'title'       => [
            'label'   => 'Titel',
            'comment' => '',
        ],
        'description' => [
            'label'   => 'Beschreibung',
            'comment' => '',
        ],
    ],
    'slider'           => [
        'mode'               => [
            'label'   => 'Modus',
            'comment' => '',
        ],
        'start_at'           => [
            'label'   => 'Nummer des Startbildes',
            'comment' => '',
        ],
        'items'              => [
            'label'   => 'Anzahl gleichzeitig gezeigter Bilder',
            'comment' => '',
        ],
        'image_height'       => [
            'label'   => 'Bildhöhe in Pixel',
            'comment' => '',
        ],
        'is_loop'            => [
            'label'   => 'Loop',
            'comment' => '',
        ],
        'is_lazyload'        => [
            'label'   => 'Lazyload',
            'comment' => '',
        ],
        'is_controls'        => [
            'label'   => 'Blättertasten',
            'comment' => '',
        ],
        'axis'               => [
            'label'   => 'Scrollachse',
            'comment' => '',
        ],
        'is_nav'             => [
            'label'   => 'Navigations-Punkte',
            'comment' => '',
        ],
        'nav_position'       => [
            'label'   => 'Navigations-Position',
            'comment' => '',
        ],
        'is_nav_overlay'     => [
            'label'   => 'Navigations-Punkte auf dem Bild',
            'comment' => '',
        ],
        'is_autoplay'        => [
            'label'   => 'Autoplay',
            'comment' => '',
        ],
        'autoplay_speed'     => [
            'label'   => 'Geschwindigkeit in ms',
            'comment' => '',
        ],
        'is_autoplay_button' => [
            'label'   => 'Autoplay-Button anzeigen',
            'comment' => '',
        ],
        'responsive'         => [
            'label'   => 'Anzahl gleichzeitig gezeigter Bilder im Responsive',
            'comment' => 'Format: PIXEL: ANZAHL (z.B. 640: 3). Ein Wertepaar pro Zeile.<br><b>Mit Vorsicht verwenden, fehlerhafte Eingaben können dazu führen, dass der Slider nicht mehr funktioniert.</b>',
        ],
        'options'            => [
            'label'   => 'Weitere Slider-Optionen',
            'comment' => 'Format: option: wert, - mögliche Optionen sind <a href="https://github.com/ganlanyuan/tiny-slider#options" target="_blank">hier</a> zu finden.<br><b>Mit Vorsicht verwenden, fehlerhafte Eingaben können dazu führen, dass der Slider nicht mehr funktioniert.</b>',
        ],
        'classes'            => [
            'label'   => 'Zusätzliche CSS-Klassen',
            'comment' => '',
        ],
    ],
    'lightbox'         => [
        'is_loop' => [
            'label'   => 'Loop',
            'comment' => '',
        ],
        'options' => [
            'label'   => 'Weitere Lightbox-Optionen',
            'comment' => 'Format: option: wert, - mögliche Optionen sind <a href="https://github.com/biati-digital/glightbox#lightbox-options">hier</a> zu finden.<br><b>Mit Vorsicht verwenden, fehlerhafte Eingaben können dazu führen, dass die Lightbox nicht mehr funktioniert.</b>',
        ],
        ''        => [
            'label'   => '',
            'comment' => '',
        ],
        ''        => [
            'label'   => '',
            'comment' => '',
        ],
    ],
    ''                 => [
        'label'   => '',
        'comment' => '',
    ],
    'dropdown'         => [
        'auto'       => 'automatische Höhe',
        'carousel'   => 'Karussell (Slide)',
        'gallery'    => 'Galerie (Fade)',
        'horizontal' => 'Horizontal',
        'vertical'   => 'Vertikal',
        'bottom'     => 'unten',
        'top'        => 'oben',
    ],
    'is_raw'           => [
        'label'   => 'Raw-Anzeige',
        'comment' => 'Es wird nur der Blockinhalt ausgegeben, ohne Überschrift, Umrandung o.a.',
    ],
    'is_active'        => [
        'label'   => 'Aktiv',
        'comment' => '',
    ],
    'is_heading'       => [
        'label'   => 'Überschrift/Unterüberschrift anzeigen',
        'comment' => '',
    ],
    'is_box'           => [
        'label'   => 'Box anzeigen',
        'comment' => 'Umschliesst den Block mit einem Wrapper der einen Rahmen um den Inhalt erzeugt',
    ],
    'is_scrollbar'     => [
        'label'   => 'Scrollbalken falls nötig',
        'comment' => 'Blendet einen Scrollbalken ein, wenn der Inhalt länger ist als der Platz im Block. Hat keinen Einfluss wenn die Höhe auf "Automatisch" steht.',
    ],
    'is_image_text'    => [
        'label'   => 'Titel/Beschreibung des Bildes anzeigen',
        'comment' => '',
    ],
    'is_slider'        => [
        'label'   => 'Bilder als Slider anzeigen',
        'comment' => '',
    ],
    'is_lightbox'      => [
        'label'   => 'Bild bei Klick in Lightbox anzeigen',
        'comment' => '',
    ],
    'is_blank'         => [
        'label'   => 'Link in neuem Tab/Fenster öffnen',
        'comment' => '',
    ],
    'dynamic_content'  => [
        'label'   => '',
        'comment' => '',
        'prompt'  => 'Neues Modul',
    ],
    ''                 => [
        'label'   => '',
        'comment' => '',
    ],
    'start_at'         => [
        'label'   => 'Start',
        'comment' => '',
    ],
    'end_at'           => [
        'label'   => 'Ende',
        'comment' => '',
    ],
    'is_defaultcss'    => [
        'label'   => 'Default-CSS nutzen',
        'comment' => 'Wenn aktiv, wird das Default-CSS aus dem Plugin verwendet um Blöcke zu stylen',
    ],
    'is_blocklist_raw' => [
        'label'   => 'Raw-Anzeige',
        'comment' => 'Es wird nur Blockliste ausgegeben, ohne Überschriftund sonstige umgebende Elemente',
    ],
    'controller' => [
        'group' => 'Gruppe',
        'text' => 'Text',
    ],
];
