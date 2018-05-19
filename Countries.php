<?php

 function dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '<pre>';
    die;
}


/**
 * Class Countries
 */
class Countries
{

    private $files;

    /**
     * @var $country_name
     */
    private $country_name;

    /**
     * @var
     */
    private $province_name;

    /**
     * Countries constructor.
     * @param null $country_name
     * @throws Exception
     */
    public function __construct($country_name = null)
    {
        $this->country_name = $country_name;
        $this->files = $this->file();
    }

    /**
     * @param $country_name
     * @return $this
     */
    public function name($country_name)
    {
        $this->country_name = $country_name;

        return $this;
    }


    public function whereProvince($province_name) {
        $this->province_name = $province_name;
        return $this;
    }

    /**
     * Get All Districts
     *
     * @return array
     */
    public function getDistricts()
    {
        $districts = [];
        foreach ($this->files['countries'] as $country) {
            if(strtolower($country['name']) == $this->country_name) {
                foreach ($country['provinces'] as $province) {
                    if($this->province_name) {
                        if($province['name'] == $this->province_name) {
                            $districts = $province['districts'];
                        }
                    } else {
                       $districts = array_merge($province['districts'], $districts);
                    }
                }
            }
        }
        return $districts;
    }

    /**
     * Get All Countries
     *
     * @return array
     */
    public function getAll()
    {
        $countries = [];
        foreach ($this->files['countries'] as $file) {
            $countries[] = $file['name'];
        }

        return $countries;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function file()
    {
        if(is_file('config.php'))
            return include 'config.php';

        throw new Exception('File Dosent Exist');
    }

    /**
     * @param $dynamic_method
     * @param $arguments
     * @return array
     */
    function __call($dynamic_method,$arguments) {

        $method = $this->from_camel_case(substr($dynamic_method,3,strlen($dynamic_method)-3));

        $data = [];
        foreach ($this->files['countries'] as $country) {

            if(strtolower($country['name']) == $this->country_name) {

                foreach ($country[$method] as $name)
                {
                    $data[] = $name['name'];
                }
            }
        }

        return $data;
    }

    function from_camel_case($str) {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }

}