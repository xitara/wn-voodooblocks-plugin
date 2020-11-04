<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use October\Rain\Parse\Bracket;
use Xitara\DynamicContent\Models\Text;
use Xitara\EroBridge\Classes\Api;
use Xitara\EroBridge\Classes\EroCmsData;

class BuyedArticle extends ComponentBase
{
    public static $placeholder = [
        'article_id',
        'article_name',
        'buyed_dates',
        'placement',
        'points',
        'next_sum',
        'prices',
        'sum',
        'user_id',
        'user_name',
    ];

    public function componentDetails()
    {
        return [
            'name' => 'xitara.dynamiccontent::component.buyedarticle.name',
            'description' => 'xitara.dynamiccontent::component.buyedarticle.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'article' => [
                'title' => 'xitara.dynamiccontent::component.buyedarticle.article',
                'description' => 'xitara.dynamiccontent::component.buyedarticle.article_description',
                'type' => 'dropdown',
            ],
            'startAt' => [
                'title' => 'xitara.dynamiccontent::component.buyedarticle.start_at',
                'description' => 'xitara.dynamiccontent::component.buyedarticle.start_at_description',
                'type' => 'string',
                'default' => '2000-01-01 00:00:00',
                'validationPattern' => '\d{4}(-)\d{2}(-)\d{2}( \d{2}(:)\d{2}(:)\d{2})?',
                'validationMessage' => 'xitara.core::core.validation.date',
            ],
            'interval' => [
                'title' => 'xitara.dynamiccontent::component.buyedarticle.interval',
                'description' => 'xitara.dynamiccontent::component.buyedarticle.interval_description',
                'type' => 'dropdown',
                'options' => [
                    'none' => 'xitara.dynamiccontent::component.buyedarticle.options.none',
                    'day' => 'xitara.dynamiccontent::component.buyedarticle.options.day',
                    'week' => 'xitara.dynamiccontent::component.buyedarticle.options.week',
                    'month' => 'xitara.dynamiccontent::component.buyedarticle.options.month',
                    'year' => 'xitara.dynamiccontent::component.buyedarticle.options.year',
                ],
                'default' => 'none',
            ],
            'creditsPerPoint' => [
                'title' => 'xitara.dynamiccontent::component.buyedarticle.credits_per_point',
                'description' => 'xitara.dynamiccontent::component.buyedarticle.credits_per_point_description',
                'type' => 'string',
                'default' => 25,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'xitara.core::core.valiidation.only_numbers',
            ],
            'textNoPlace' => [
                'title' => 'xitara.dynamiccontent::component.buyedarticle.no_place',
                'description' => 'xitara.dynamiccontent::component.buyedarticle.no_place_description',
                'type' => 'dropdown',
            ],
            'textPlace' => [
                'title' => 'xitara.dynamiccontent::component.buyedarticle.with_place',
                'description' => 'xitara.dynamiccontent::component.buyedarticle.with_place_description',
                'type' => 'dropdown',
            ],
            'textFirstPlace' => [
                'title' => 'xitara.dynamiccontent::component.buyedarticle.first_place',
                'description' => 'xitara.dynamiccontent::component.buyedarticle.first_place_description',
                'type' => 'dropdown',
            ],
        ];
    }

    public function getTextNoPlaceOptions()
    {
        return Text::orderBy('name', 'asc')->lists('name', 'id');
    }

    public function getTextPlaceOptions()
    {
        return Text::orderBy('name', 'asc')->lists('name', 'id');
    }

    public function getTextFirstPlaceOptions()
    {
        return Text::orderBy('name', 'asc')->lists('name', 'id');
    }

    public function getArticleOptions()
    {
        $result = Api::call('article/search', [
            'search' => '',
            'list' => true,
        ]);

        return $result->body->data;
    }

    public function onRun()
    {
        list($session, $userId) = explode('|', get('session'));

        $result = Api::call('article/buyed', [
            'column' => 'artikel_id',
            'value' => $this->property('article'),
            'start' => $this->property('startAt'),
            'userlist' => [$userId],
        ]);

        if ($result->status == 200) {
            $place = $this->getToplist($userId);

            $sum = 0;
            foreach ($result->body->data as $order) {
                $articleName = $order->artikelname;
                $buyedDates[] = $order->datetime;
                $prices[] = ($order->preis > 0) ? $order->preis : $order->gesamtpreis;
                $sum += ($order->preis > 0) ? $order->preis : $order->gesamtpreis;
            }

            if ($place['next'] == -1) {
                $text = ((Text::find($this->property('textFirstPlace')))->text);
            } else {
                $text = ((Text::find($this->property('textPlace')))->text);
            }

            $text = Bracket::parse($text, [
                'article_id' => $this->property('article'),
                'article_name' => $articleName,
                'buyed_dates' => $buyedDates,
                'placement' => $place['placement'],
                'next_sum' => $place['next'],
                'points' => ceil($sum / $this->property('creditsPerPoint', 25)),
                'prices' => $prices,
                'sum' => $sum,
                'user_id' => $userId,
                'user_name' => EroCmsData::getUsernameFromId($userId),
            ]);

        } else {
            $article = EroCmsData::getArticleData($this->property('article'));

            $text = ((Text::find($this->property('textNoPlace')))->text);
            $text = Bracket::parse($text, [
                'article_id' => $this->property('article'),
                'article_name' => $article->artikelname,
                'user_id' => $userId,
                'user_name' => EroCmsData::getUsernameFromId($userId),
            ]);
        }

        $this->page['text'] = $text;
    }

    private function getToplist($userId)
    {
        $result = Api::call('article/buyed', [
            'column' => 'artikel_id',
            'value' => $this->property('article'),
            'start' => $this->property('startAt'),
            'columnsArticle' => ['id', 'artikel_id', 'preis', 'member_id'],
            'columnsOrder' => ['id', 'gesamtpreis'],
        ]);

        if ($result->status == 200) {
            foreach ($result->body->data as $order) {
                if (!isset($list[$order->member_id])) {
                    $list[$order->member_id] = 0;
                }

                $list[$order->member_id] += ($order->preis > 0) ? $order->preis : $order->gesamtpreis;
            }
        }

        arsort($list);

        foreach ($list as $user => $sum) {
            $data = [
                'id' => $user,
                'sum' => $sum,
            ];

            if (isset($toplist[$sum])) {
                $toplist[$sum] = array_merge($toplist[$sum], [$data]);
            } else {
                $toplist[$sum] = [$data];
            }

        }

        $toplist = array_values($toplist);

        foreach ($toplist as $place => $item) {
            foreach ($item as $user) {

                // $flag = array_search($userId, $item);

                if ($user['id'] == $userId) {
                    $placement = $place + 1;

                    if ($place > 0) {
                        $nextPlacement = $toplist[$place - 1][0]['sum'];
                    }

                    break;
                }
            }
        }

        return ['placement' => $placement, 'next' => $nextPlacement ?? -1];
    }
}
