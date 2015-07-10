<?php

namespace App\Services\Social;

use Tricks\Trick;
use RuntimeException;
use Illuminate\Config\Repository;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Database\Eloquent\Collection;
use Guzzle\Http\Exception\BadResponseException;

class Duoshuo
{
    /**
     * The curl client used for Duoshuo API interaction
     *
     * @var \Guzzle\Service\Client
     */
    protected $client;

    /**
     * Config repository.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Create a new Disqus instance.
     *
     * @param  \Guzzle\Service\Client         $client
     * @param  \Illuminate\Config\Repository  $config
     * @return void
     */
    public function __construct(GuzzleClient $client, Repository $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Get a config item.
     *
     * @param  mixed $key
     * @return mixed
     */
    protected function getConfig($key = null)
    {
        $key = is_null($key) ? '' : '.' . $key;

        return $this->config->get('services.duoshuo' . $key);
    }

    /**
     * Normalize the given trick(s) to an array of tricks.
     *
     * @param  mixed $tricks
     * @return array
     */
    protected function getValidTricks($tricks)
    {
        if ($this->areInvalidTricks($tricks)) {
            throw new RuntimeException('Invalid tricks');
        }

        if ($tricks instanceof Trick) {
            $tricks = [ $tricks ];
        }

        return $tricks;
    }

    /**
     * Determine whether the given tricks are invalid.
     *
     * @param  mixed  $tricks
     * @return bool
     */
    protected function areInvalidTricks($tricks)
    {
        return ! $tricks instanceof Trick &&
               ! ($tricks instanceof Collection && $tricks->count() > 0);
    }

    /**
     * Get a formatted list of the trick ids.
     *
     * @param  array $tricks
     * @return array
     */
    protected function getThreadsArray($tricks)
    {
        $threads = [];


        foreach ($tricks as $trick) {
            $threads[] = $this->getThreadKey($trick->id);
        }

        return $threads;
    }

    /**
     * Return thred key.
     *
     * @param string $trickId
     *
     * @return string
     */
    protected function getThreadKey($trickId)
    {
        $prefix  = $this->getConfig('thread_key_prefix.trick');

        return $prefix . $trickId;
    }

    /**
     * Rarse response content from the response object.
     *
     * @param  Psr\Http\Message\ResponseInterface $response
     * @return array
     */
    protected function parseResponse($response)
    {
        try {
            $response = json_decode($response->getBody(), true);

            return $response['response'];
        } catch (BadResponseException $bre) {
            return null;
        }
    }

    /**
     * Get Duoshuo comemnts count by trick ids.
     *
     * @param array $trickIds
     *
     * @return array
     */
    public function getCommentCountsByIds($trickIds)
    {
        $threads = array_map(function($id){
            return $this->getThreadKey($id);
        }, $trickIds);

        $response = $this->getDuoshuoCounts($threads);

        $return = [];

        foreach ($trickIds as $id) {
            if (!empty($response) && !empty($response[$this->getThreadKey($id)])) {
                $return[$id] = $response[$this->getThreadKey($id)]['comments'];
            } else {
                $return[$id] = 0;
            }
        }

        return $return;
    }

    /**
     * Append the comment counts to the given tricks.
     * @param  mixed $tricks
     * @return mixed
     */
    public function appendCommentCounts($tricks)
    {
        $tricks = $this->getValidTricks($tricks);

        $threads = $this->getThreadsArray($tricks);

        $response = $this->getDuoshuoCounts($threads);

        foreach ($tricks as $trick) {
            if (empty($response) || empty($response[$this->getThreadKey($trick->id)])) {
                $trick->comment_count = 0;
                continue;
            }

            $trick->comment_count = $response[$this->getThreadKey($trick->id)]['comments'];
        }

        return $tricks instanceof Collection ? $tricks : $tricks[0];
    }

    /**
     * Get Duoshuo comments count.
     *
     * @param array $threads
     *
     * @return array
     */
    public function getDuoshuoCounts($threads)
    {
        $queries = [
            'query' => [
                'short_name' => $this->getConfig('short_name'),
                'threads'    => join(',', $threads),
            ],
        ];

        $response = $this->parseResponse($this->client->get('threads/counts.json', $queries));

        return $response;
    }
}
