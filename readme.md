## Array Of Country. Nepal Country Zone,Provinces,Districts
```
$country   = new Countries('nepal');
$zones     = $country->getZones();
$countries = $country->getAll();
$provinces = $country->getProvinces();
$districts = $country->getDistricts();
$districts_as_province = $country
    ->whereProvince('Province No. 1')
    ->getDistricts();

$country   = new Countries();
$countries = $country->name('nepal')
                    ->getAll();
$zones     = $country->name('nepal')
                    ->getZones();
$provinces = $country->name('nepal')
                    ->getProvinces();
$districts = $country->name('nepal')
                    ->getDistricts();
$districts_as_province = $country->name('nepal')
                    ->whereProvince('Province No. 1')
                    ->getDistricts();


$get_province_name_from_district = $country->name('nepal')->getProvinceNameFromDistrict('Baglung');
$get_country_name_from_province = $country->getCountryNameFromProvince('Province No. 1');

```


