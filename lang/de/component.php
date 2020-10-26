<?php

return [
    'buyedarticle' => [
        'options' => [
            'none' => 'keins',
            'day' => 'Jeden Tag',
            'week' => 'Jede Woche',
            'month' => 'Jeden Monat',
            'year' => 'Jedes Jahr',
        ],
        'name' => 'Dynamischer Inhalt - Gekaufte Artikel',
        'description' => 'Wertet gekaufte Artikel aus und erzeugt konfigurierte Texte',
        'article' => 'Artikel',
        'article_id' => 'Artikel ID',
        'article_name' => 'Artikel Name',
        'buyed_dates' => 'Array mit dem Datum aller Käufe des Users',
        'placement' => 'Platzierung',
        'points' => 'Punkte (berechnet aus Summe und den eingestellten Coins pro Punkt)',
        'next_sum' => 'Summe die für den nächsten Platz nötig ist.',
        'prices' => 'Array mit Preisen aller Käufe des Users',
        'sum' => 'Summe die der User bisher gezahlt hat',
        'user_id' => 'User ID',
        'user_name' => 'Username',
        'no_place' => 'Text ohne Plazierung',
        'no_place_description' => 'Text, wenn es bisher keine Platzierung / Punkte gibt.',
        'with_place' => 'Text mit Plazierung',
        'with_place_description' => 'Text, wenn es bereits eine Platzierung gibt.',
        'credits_per_point' => 'Coins pro Punkt',
        'credits_per_point_description' => 'Gib an, wieviele Coins benötigt werden um einen Punkt zu bekommen.',
        'start_at' => 'Start Datum - Format: YYYY-MM-DD HH:MM:SS',
        'start_at_description' => 'Gibt an ab welchem Datum die Artikel ausgewertet werden sollen. Uhrzeit ist Optional. Wenn nicht angegen wird 00:00:00 als Defaultwert genommen',
        'interval' => 'Interval',
        'interval_description' => 'Gibt an in welchem Interval eine neue Auswertung starten soll. Z.B. Woche gibt an, dass das Startdatum jede Woche neu gesetzt wird.',

    ],
    'blocklist' => [
        'is_slider' => 'Slider',
        'is_lightbox' => 'Lightbox',
        'is_carousel' => 'Unendlicher Slider (Karusell/Infinity)',
        'start_at' => 'Nummer des Startbildes',
        'items' => 'Anzahl gleichzeitig gezeigter Bilder',
        'is_buttons' => 'Blättertasten anzeigen',
        'is_bullets' => 'Positions-Punkte anzeigen',
        'css_classes' => 'Zusätzliche CSS-Klasse(n) durch Leerzeichen getrennt (Optional)',
        'slider_options' => 'Weitere Slider-Optionen',
        'slider_options_comment' => 'Format: option: wert, - mögliche Optionen sind <a href="https://github.com/ganlanyuan/tiny-slider#options" target="_blank">hier</a> zu finden.<br><b>Mit Vorsicht verwenden, fehlerhafte Eingaben können dazu führen, dass der Slider nicht mehr funktioniert.</b>',
        'type' => 'Slidertyp',
        'loop' => 'Loop',
        'slide' => 'Slider',
        'fade' => 'Überblenden',
        'lightbox_options' => 'Weitere Lightbox-Optionen',
        'lightbox_options_comment' => 'Format: option: wert, - mögliche Optionen sind <a href="https://github.com/biati-digital/glightbox#lightbox-options">hier</a> zu finden.<br><b>Mit Vorsicht verwenden, fehlerhafte Eingaben können dazu führen, dass die Lightbox nicht mehr funktioniert.</b>',
        'mode' => 'Modus',
        'carousel' => 'Karussell (Slide)',
        'gallery' => 'Galerie (Fade)',
        'image_height' => 'Bildhöhe in Pixel',
        'bullets_overlay' => 'Positionspunkte liegen über dem Bild',
        'is_lazyload' => 'Lazyload',
        'is_controls' => 'Blättertasten',
        'is_nav' => 'Navigations-Punkte',
        'nav_position' => 'Navigations-Position',
        'nav_overlay' => 'Navigations-Punkte auf dem Bild',
        'axis' => 'Scrollachse',
        'is_autoplay' => 'Autoplay',
        'autoplay_speed' => 'Geschwindigkeit in ms',
        'is_autoplay_button' => 'Autoplay-Button anzeigen',
        'responsive' => 'Anzahl gleichzeitig gezeigter Bilder im Responsive',
        'responsive_comment' => 'Format: PIXEL: ANZAHL (z.B. 640: 3). Ein Wertepaar pro Zeile.<br><b>Mit Vorsicht verwenden, fehlerhafte Eingaben können dazu führen, dass der Slider nicht mehr funktioniert.</b>',
        'is_loop' => 'Loop',
        'is_scrolling' => 'Scrollbalken falls nötig',
        'is_scrolling_comment' => 'Blendet einen Scrollbalken ein, wenn der Inhalt länger ist als der Platz im Block. Hat keinen Einfluss wenn die Höhe auf "Automatisch" steht.',
        'is_image_text' => 'Text unter den Bilder anzeigen',
        'is_image_text_comment' => 'Wenn aktiviert, werden Titel und Beschreibung unter dem Bild angezeigt, falls diese vorhanden sind.',
        '' => '',
    ],
];
