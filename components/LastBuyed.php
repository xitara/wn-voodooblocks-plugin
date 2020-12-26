<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use Xitara\EroBridge\Classes\Api;

class LastBuyed extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'LastBuyed Component',
            'description' => 'No description provided yet...',
        ];
    }

    public function defineProperties()
    {
        return [
            'heading' => [
                'title' => 'Überschrift',
                'description' => '',
                'type' => 'string',
            ],
            'items' => [
                'title' => 'Anzahl Artikel',
                'description' => '',
                'default' => 2,
                'type' => 'string',
            ],
            'type' => [
                'title' => 'Artikeltyp',
                'description' => '',
                'type' => 'dropdown',
                'options' => [
                    'album' => 'Album',
                    'foto' => 'Foto',
                    'shop' => 'Shop',
                    'trinkgeld' => 'Trinkgeld',
                    'video' => 'Video',
                ],
            ],
            'image' => [
                'title' => 'Bild',
                'description' => '',
                'type' => 'dropdown',
                'options' => [
                    'fsk_16' => 'FSK 16',
                    'fsk_18' => 'FSK 18',
                ],
            ],
        ];
    }

    public function onRun()
    {
        // var_dump($this->property('type'));
        // var_dump($this->property('items'));
        // var_dump($this->property('image'));

        $response = Api::call('payments/search', [
            'column' => 'place',
            'value' => $this->property('type'),
            'columns' => ['id', 'artikel_id', 'preis', 'userid', 'timestamp', 'date'],
            'columnsArticle' => ['name', 'artikelname', 'img', 'img18', 'bild', 'bild_fsk18', 'datei'],
            'maxItems' => $this->property('items'),
            'orderBy' => 'timestamp',
            'orderDir' => 'desc',
        ]);

        // var_dump($response);
        // exit;

        if ($response->status != 200) {
            return;
        }

        foreach ($response->body->data as $article) {
            if ($this->property('image') == 'fsk_16') {
                // $image = $article->bild;
                $image = $article->img;
            } else {
                // $image = $article->bild_fsk18;
                $image = $article->img18;
            }

            $data[] = [
                'id' => $article->artikel_id,
                'image' => $image,
                // 'name' => $article->artikelname,
                'name' => $article->name,
                'price' => $article->preis,
                'file' => $article->date,
            ];
        }

        $this->page['lastBuyed_heading'] = $this->property('heading');
        $this->page['lastBuyed'] = $data;
    }
}
