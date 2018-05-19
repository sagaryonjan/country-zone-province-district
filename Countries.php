<?php

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


    /**
     * Get Province Name From DistrictName
     *
     * @param $district_name
     * @return mixed
     */
    public function getProvinceNameFromDistrict($district_name)
    {
        foreach ($this->files['countries'] as $country) {
            if(strtolower($country['name']) == $this->country_name) {
                foreach ($country['provinces'] as $province) {
                    $datas[] = $province['name'];
                    foreach ($province['districts'] as $district) {
                        if($district['name'] == $district_name) {
                            return $province['name'];
                        }
                    }

                }
            }
        }
    }

    public function getCountryNameFromProvince($province_name)
    {
        foreach ($this->files['countries'] as $country) {
            foreach ($country['provinces'] as $province) {
                if($province['name'] == $province_name) {
                    return $country['name'];
                }
            }
        }
    }

    /**
     * Conditional Checking
     *
     * @param $province_name
     * @return $this
     */
    public function whereProvince($province_name) {
        $this->province_name = $province_name;
        return $this;
    }


    /**
     * @param $dynamic_method
     * @param $arguments
     * @return array
     */
    function __call($dynamic_method, $arguments) {

        $method = $this->from_camel_case(substr($dynamic_method,3,strlen($dynamic_method)-3));

        $datas = [];
        foreach ($this->files['countries'] as $country) {
            if($method == 'all') {
                $datas[] = $country['name'];
            }
            else {
                if(strtolower($country['name']) == $this->country_name) {
                    if($method == 'districts') {
                        $datas = $this->getDataAsDistrict($country);
                    } else {
                        foreach ($country[$method] as $name) {
                            $datas[] = $name['name'];
                        }
                    }
                }
            }
        }

        return $datas;
    }

    /**
     * From Camel Case
     *
     * @param $str
     * @return null|string|string[]
     */
    private function from_camel_case($str) {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }

    /**
     * Get Districts
     *
     * @param $country
     * @return array
     */
    private function getDataAsDistrict($country)
    {
        $datas = [];
        foreach ($country['provinces'] as $province) {
            if($this->province_name) {
                if($province['name'] == $this->province_name) {
                    $datas = $province['districts'];
                }
            } else {
                $datas = array_merge($province['districts'], $datas);
            }
        }

        return $datas;
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

}