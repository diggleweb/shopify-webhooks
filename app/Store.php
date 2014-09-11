<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * Do not use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Clean up and set the url.
     *
     * @param  string  $value
     * @return void
     */
    public function setUrlAttribute($value)
    {
        $url = parse_url($value);
        unset($url['scheme']);

        $this->attributes['url'] = reset($url);
    }

    /**
     * Set the token object.
     *
     * @param  \League\OAuth2\Client\Token\AccessToken  $value
     * @return void
     */
    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = serialize($value);
    }

    /**
     * Get the token object.
     *
     * @param  League\OAuth2\Client\Token\AccessToken  $value
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    public function getTokenAttribute($value)
    {
        return unserialize($this->attributes['token']);
    }

    /**
     * Get the shop name part from the url.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        if (!$this->url) {
            return false;
        }

        $components = parse_url($this->url);
        unset($components['scheme']);

        $host = explode('.', reset($components));

        return reset($host);
    }

    /**
     * Get the URL to the page to add webhooks.
     *
     * @return string
     */
    public function getWebhooksUrlAttribute()
    {
        return \URL::route('webhooks', array('id' => $this->id));
    }
}
