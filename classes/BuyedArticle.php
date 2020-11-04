<?php namespace Xitara\DynamicContent\Classes;

use October\Rain\Parse\Bracket;
use Xitara\DynamicContent\Models\Text;
use Xitara\EroBridge\Classes\Api;
use Xitara\EroBridge\Classes\EroCmsData;

class BuyedArticle
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

    public function getData($config)
    {
        list($session, $userId) = explode('|', get('session'));

        $result = Api::call('article/buyed', [
            'column' => 'artikel_id',
            'value' => $config['article'],
            'start' => $config['start_at'],
            'userlist' => [$userId],
        ]);

        if ($result->status == 200) {
            $place = $this->getToplist($userId, $config);

            $sum = 0;
            foreach ($result->body->data as $order) {
                $articleName = $order->artikelname;
                $buyedDates[] = $order->datetime;
                $prices[] = ($order->preis > 0) ? $order->preis : $order->gesamtpreis;
                $sum += ($order->preis > 0) ? $order->preis : $order->gesamtpreis;
            }

            if ($place['next'] == -1) {
                $text = ((Text::find($config['text_first_place']))->text);
            } else {
                $text = ((Text::find($config['text_place']))->text);
            }

            $text = Bracket::parse($text, [
                'article_id' => $config['article'],
                'article_name' => $articleName,
                'buyed_dates' => $buyedDates,
                'placement' => $place['placement'],
                'next_sum' => $place['next'],
                'points' => ceil($sum / $config['credits_per_point']),
                'prices' => $prices,
                'sum' => $sum,
                'user_id' => $userId,
                'user_name' => EroCmsData::getUsernameFromId($userId),
            ]);

        } else {
            $article = EroCmsData::getArticleData($config['article']);

            $text = ((Text::find($config['text_no_place']))->text);
            $text = Bracket::parse($text, [
                'article_id' => $config['article'],
                'article_name' => $article->artikelname,
                'user_id' => $userId,
                'user_name' => EroCmsData::getUsernameFromId($userId),
            ]);
        }

        return $text;
    }

    private function getToplist($userId, $config)
    {
        $result = Api::call('article/buyed', [
            'column' => 'artikel_id',
            'value' => $config['article'],
            'start' => $config['start_at'],
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
