<?php
namespace infoweb\skarabee\components;

use Yii;

class Skarabee extends \yii\base\Component
{
    /**
     * The Skarabee Weblink username
     * @var string
     */
    public $userName;
    
    /**
     * The Skarabee Weblink password
     * @var string
     */
    public $password;
    
    /**
     * The location of the Skarabee Weblink API WSDL file
     * @var string
     */
    public $wsdlLocation = 'http://weblink.skarabee.com/weblink.asmx?wsdl';    
        
    public $timeOut = 60;
    
    public $userAgent;
    
    public $debug = false;
    
    /**
     * @var SoapClient
     */
    protected $soapClient = null;
    
    protected $version = '1.0.0';
    
    public function init()
    {
        if (!$this->userName) {
            throw new \Exception('The Skarabee Weblink username is not set');
        } elseif (!$this->password) {
            throw new \Exception('The Skarabee Weblink password is not set');
        }
        
        parent::init();    
    }
    
    /**
     * Get the timeout that will be used
     *
     * @return  int
     */
    public function getTimeOut()
    {
        return (int) $this->timeOut;
    }
    
    /**
     * Set the timeout
     * After this time the request will stop. You should handle any errors triggered by this.
     *
     * @return  void
     * @param   int $seconds    The timeout in seconds
     */
    public function setTimeOut($seconds)
    {
        $this->timeOut = (int) $seconds;
    }

    /**
     * Get the useragent that will be used. Our version will be prepended to yours.
     * It will look like: "PHP Skarabee Member/<version> <your-user-agent>"
     *
     * @return  string
     */
    public function getUserAgent()
    {
        return (string) "PHP Skarabee Member/{$this->version} {$this->userAgent}";
    }

    /**
     * Set the user-agent for you application
     * It will be appended to ours, the result will look like: "PHP Skarabee Member/<version> <your-user-agent>"
     *
     * @return  void
     * @param   string $userAgent   Your user-agent, it should look like <app-name>/<app-version>
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = (string) $userAgent;
    }
    
    /**
     * Get a publication by id.
     *
     * @param int $id The publication ID.
     * @return array
     */
    public function get($id)
    {
        // init parameters
        $parameters = array();

        // define parameters
        $parameters['PublicationId'] = (int) $id;

        // define result
        $result = $this->doCall('GetPublication', $parameters);

        // return item
        return $result['Publication'];
    }

    /**
     * Get all publications with optional filtering on date or type.
     *
     * @param string $sinceDate [optional] If no date given, all publications will be returned.
     * @param mixed $types [optional] If no types are given, all allowed types will be returned.
     * @return array Returns all changed PublicationID values since date given.
     */
    public function getAll($sinceDate = null, $types = null)
    {
        // init parameters
        $parameters = array();

        // define parameters
        if($sinceDate !== null) $parameters['LastModified'] = $sinceDate;
        if($types !== null) $parameters['RequestedPropertyTypes'] = (array) $types;

        // define results
        $results = $this->doCall('GetPublicationSummaries', $parameters);

        // return items
        if(isset($results['PublicationSummaries']['PublicationSummary']))
        {
            // define return value
            $return = $results['PublicationSummaries']['PublicationSummary'];

            // we should return array of items, not one item array
            if(isset($return['ID'])) $return = array($return);

            // return
            return $return;
        }
        else return array();
    }

    /**
     * Get all projects with optional filtering on date or type.
     *
     * @param string $sinceDate [optional] If no date given, all publications will be returned.
     * @param array $types [optional] If no types are given, all allowed types will be returned.
     * @return array Returns all changed PublicationID values since date given.
     */
    public function getAllProjects($sinceDate = null, $types = null)
    {
        // init parameters
        $parameters = array();

        // define parameters
        if(!$sinceDate) $parameters['LastModified'] = $sinceDate;
        if(!$types) $parameters['RequestedPropertyTypes'] = $types;

        // define results
        $results = $this->doCall('GetProjectSummaries', $parameters);

        // return items
        if(isset($results['ProjectPublicationSummaries']['ProjectPublicationSummary']))
        {
            // define return value
            $return = $results['ProjectPublicationSummaries']['ProjectPublicationSummary'];

            // we should return array of items, not one item array
            if(isset($return['ID'])) $return = array($return);

            // return
            return $return;
        }
        else return array();
    }
    
    /**
     * Ping to Skarabee.
     *
     * @todo Verify if it works.
     * @param int $id The PublicationID you have received from Skarabee for a property.
     * @param int $status The status of the property.
     * @param int $statusDescription The description of the property.
     * @param int $internalId The ID for this property in our website.
     * @param int $internalURL The URL for this property in our website.
     */
    public function pingBack($id, $status, $statusDescription = 'description', $internalId, $internalURL)
    {
        // redefine status
        $status = (string) $status;

        // available statusses
        $values = array('AVAILABLE', 'DELETED', 'AGENT_NOT_ACTIVE', 'ERROR');

        // error checking
        if(!in_array($status, $values))
            throw new \Exception('The given \'status\' : ' . $status . ' is not one of the following values: ' . implode(', ', $values) . '.');

        // init feedback
        $feedback = array();

        // define parameters
        $feedback['PublicationID'] = (int) $id;
        $feedback['Status'] = $status;
        $feedback['StatusDescription'] = (string) $statusDescription;
        $feedback['ExternalID'] = (int) $internalId;
        $feedback['URL'] = (string) $internalURL;

        // init parameters
        $parameters['FeedbackList']['FeedbackList']['Feedback'] = $feedback;

        // call feedback
        return $this->doCall('Feedback', $parameters);
    }
    
    /**
     * Call a certain method with its parameters
     *
     * @param   string  $method
     * @param   string  $parameters
     * @return  SoapClient
     */
    protected function doCall($method, $parameters = array())
    {
        // Check if a soapClient exists
        if(!$this->soapClient)
        {
            // Check for credentials
            if(!$this->userName || !$this->password)
                throw new \Exception('Invalid credentials');

            $options = array(
                'login'                 => $this->userName,
                'password'              => $this->password,
                'soap_version'          => SOAP_1_1,
                'trace'                 => $this->debug,
                'exceptions'            => false,
                'connection_timeout'    => $this->getTimeOut(),
                'user_agent'            => $this->getUserAgent()
            );

            $this->soapClient = new \SoapClient($this->wsdlLocation, $options);
        }

        // Define result method which contains the results
        $resultMethod = $method . 'Result';
        $result = $this->soapClient->$method($parameters)->$resultMethod;
        mail('fabio@infoweb.be', __FILE__.' => '.__LINE__, var_export($result,true));
        return json_decode(json_encode($result), true);
    }  
}