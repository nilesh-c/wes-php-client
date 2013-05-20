<?php

namespace WesPHPClient;

/**
 * EntitySuggesterService helps you leverage the Entity Suggester REST api
 */
class EntitySuggesterService
{
    /**
     * @var MyrrixClient
     */
    protected $client;

    /**
     * @param string $host     The hostname
     * @param int    $port     The port
     * @param string $username The username
     * @param string $password The password
     */
    function __construct($host, $port, $username = null, $password = null)
    {
        $this->client = MyrrixClient::factory(array(
            'hostname' => $host,
            'port'     => $port,
            'username' => $username,
            'password' => $password,
        ));
    }

    /**
     * Gets a recommendation for an unknown item, infer its recommended properties/values using a preference(list of properties and property-values) array.
     *
     * @param array $properties The known properties of the unknown item
     * @param int   $count       The number of results to retrieve
     *
     * @return array
     */
    public function getRecommendation(array $properties = array(), $count = null)
    {
        $command = $this->client->getCommand('GetRecommendation', array(
            'properties'  => $properties,
            'howMany'      => $count,
        ));

        return $this->client->execute($command)->json();
    }

    /**
     * Sets a list of item-property or item-property+value pairs
     *
     * @param array $properties An array of arrays with keys 'userID', 'itemID' and 'value'
     *
     * @return bool
     */
    public function ingest(array $properties)
    {
        $command = $this->client->getCommand('Ingest', array(
            'data' => $properties,
        ));

        return $this->client->execute($command)->isSuccessful();
    }


    /**
     * Asks Myrrix to refresh, may take time.
     *
     * @return bool
     */
    public function refresh()
    {
        $command = $this->client->getCommand('Refresh');

        return $this->client->execute($command)->isSuccessful();
    }


    /**
     * Asks if Myrrix is ready to answer requests.
     *
     * @return bool
     */
    public function isReady()
    {
        $command = $this->client->getCommand('Ready');

        return $this->client->execute($command)->isSuccessful();
    }

    /**
     * @return MyrrixClient
     */
    public function getClient()
    {
        return $this->client;
    }
}
