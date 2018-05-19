## Array Of Country. Nepal Country Zone,Provinces,Districts
```
$country   = new Countries();
$countries = $country->getAll();


$country   = new Countries('nepal');
$zones     = $country->getZones();
$provinces = $country->getProvinces();
$districts = $country->getDistricts();
$districts_as_province = $country
    ->whereProvince('Province No. 1')
    ->getDistricts();


// Get countr
$country   = new Countries();
$countries = $country->getAll();
$zones     = $country->name('nepal')
                    ->getZones();
$provinces = $country->name('nepal')
                    ->getProvinces();
$districts = $country->name('nepal')
                    ->getDistricts();
$districts_as_province = $country->name('nepal')
                    ->whereProvince('Province No. 1')
                    ->getDistricts();

echo '<pre>';
print_r($zones);
print_r($countries);
print_r($provinces);
print_r($districts);
echo '<pre>';
die;
```


