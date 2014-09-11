<?php namespace App\Extensions;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class Shopify extends AbstractProvider
{
    /**
     * Store name.
     *
     * @var string
     */
    public $store = '';

    /**
     * Autorize url.
     *
     * @return string
     */
    public function urlAuthorize()
    {
        return sprintf('https://%s.myshopify.com/admin/oauth/authorize', $this->store);
    }

    /**
     * Access token url.
     *
     * @return string
     */
    public function urlAccessToken()
    {
        return sprintf('https://%s.myshopify.com/admin/oauth/access_token', $this->store);
    }

    /**
     * Not used.
     *
     * @return void
     */
    public function urlUserDetails(AccessToken $token)
    {
    }

    /**
     * Not used.
     *
     * @return void
     */
    public function userDetails($response, AccessToken $token)
    {
    }

    /**
     * Request all registered webhooks.
     *
     * @param  \League\OAuth2\Client\Token\AccessToken  $token
     * @return mixed
     */
    public function getWebhooks(AccessToken $token)
    {
        $response = $this->apiCall($token, 'get');

        return json_decode($response);
    }

    /**
     * Register a new webhook.
     *
     * @param  string  $hook
     * @param  \League\OAuth2\Client\Token\AccessToken  $token
     * @return mixed
     */
    public function createWebhook(array $hook, AccessToken $token)
    {
        $data = ['webhook' => $hook];

        // $response = $this->callWebhook($hook, $token);
        $response = $this->apiCall($token, $hook, $data);

        return json_decode($response);
    }

    /**
     * Make an API call.
     *
     * @param  \League\OAuth2\Client\Token\AccessToken  $token
     * @param  string  $method
     * @return mixed
     */
    protected function apiCall(AccessToken $token, $method, $data = [])
    {
        $url = sprintf('https://%s.myshopify.com/admin/webhooks.json', $this->store);

        try {
            $client = $this->getHttpClient();
            $client->setBaseUrl($url);
            $client->setDefaultOption('headers', ['X-Shopify-Access-Token' => (string) $token]);

            if ($method == 'get') {
                $request = $client->get()->send();
                $response = $request->getBody();
            } else {
                $packet = json_encode($data);
                $request = $client->post($url, null, $packet);
                $request->setHeader("Content-Type", "application/json");
                $response = $request->send();
                $response = $response->getBody(true);
            }

        } catch (BadResponseException $e) {
            // @codeCoverageIgnoreStart
            $raw_response = explode("\n", $e->getResponse());
            throw new IDPException(end($raw_response));
            // @codeCoverageIgnoreEnd
        }

        return $response;

        $this->headers = [
            'X-Shopify-Access-Token' => (string) $token,
        ];
    }
}
