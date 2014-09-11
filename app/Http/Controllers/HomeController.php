<?php namespace App\Http\Controllers;

use App\Store;
use Illuminate\Routing\Controller;
use App\Http\Requests\CreateStoreRequest;
use App\Http\Requests\CreateHookRequest;

class HomeController extends Controller
{
    /**
     * Index page
     *
     * @return \View
     */
    public function index()
    {
        return \View::make('index')->with('stores', \App\Store::all());
    }

    /**
     * Start oAuth process if a submitted store validates.
     *
     * @param  \App\Http\Requests\CreateStoreRequest  $request
     * @return void
     */
    public function validate(CreateStoreRequest $request)
    {
        $store = new Store;
        $store->url = $request->url;
        $this->oauth($store);
    }

    /**
     * Handle oAuth of a new store.
     *
     * @param  \App\Store  $store
     * @return void
     */
    public function oauth($store = null)
    {
        if (!$store) {
            $store = new Store;
            $store->url = \Input::get('shop');
        }

        $provider = $this->getProvider($store);

        if (! isset($_GET['code'])) {
            // If we don't have an authorization code then get one
            header('Location: '.$provider->getAuthorizationUrl());
            exit;
        } else {
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'client_id' => \Config::get('shopify.clientId'),
                'client_secret' => \Config::get('shopify.clientSecret'),
                'code' => $_GET['code']
            ]);

            // Save to DB
            $store->token = $token;
            $store->save();

            \Session::flash('success', true);
            return \Redirect::to('stores');
        }
    }

    /**
     * Display the page of webhooks.
     *
     * @param  int  $id
     * @return \View
     */
    public function webhooks($id)
    {
        $store = Store::find($id);
        $provider = $this->getProvider($store);
        $hooks = $provider->getWebhooks($store->token);

        return \View::make('hooks')->with('hooks', $hooks->webhooks);
    }

    /**
     * Register a new hook, if the submitted hook validates.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\CreateHookRequest  $request
     * @return void
     */
    public function createHook($id, CreateHookRequest $request)
    {
        $store = Store::find($id);
        $provider = $this->getProvider($store);

        $hook = \Input::only('topic', 'address', 'format');

        try {
            $hook = $provider->createWebhook($hook, $store->token);
        } catch (\Guzzle\Http\Exception\ClientErrorResponseException $e) {
            \View::share('errors', new \Illuminate\Support\MessageBag(array($e->getMessage())));
            \Redirect::back()->withInput();
        }

        \Session::flash('success', true);
        return $this->webhooks($id);
    }

    /**
     * Get a new oAuth provider for a store.
     *
     * @param  \App\Store  $store
     * @return \App\Extensions\Shopify
     */
    protected function getProvider($store)
    {
        $provider = new \App\Extensions\Shopify(array(
            'store' => $store->name,
            'clientId'  =>  \Config::get('shopify.clientId'),
            'scopes' => array('read_orders', 'read_products', 'read_customers'),
            'redirectUri'   =>  \Url::to('oauth')
        ));

        return $provider;
    }
}
