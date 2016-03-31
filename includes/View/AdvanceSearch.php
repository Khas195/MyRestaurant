<?php

/**
 * Created by PhpStorm.
 * User: Chanh
 * Date: 25/12/2015
 * Time: 11:12 AM
 */
class AdvanceSearch extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        $data = PackagePool::Instance()->requestPackage();
        $provinceList = PackagePool::Instance()->requestPackage();
        $districtDataHoChiMinh = PackagePool::Instance()->requestPackage();

        $districtDataHoChiMinh->setValue('District', ['1', '2', '3', '4', '5']);

        $districtDataHaNoi = PackagePool::Instance()->requestPackage();
        $districtDataHaNoi->setValue('District', ['District 6', 'District 7', 'District 8', 'District 8', 'District 10',]);


        $HoChiMinh = PackagePool::Instance()->requestPackage();
        $HoChiMinh->setValue('DistrictList', $districtDataHoChiMinh);

        $HaNoi = PackagePool::Instance()->requestPackage();
        $HaNoi->setValue('DistrictList', $districtDataHaNoi);

        $provinceList->setValue('hcm', $HoChiMinh);
        $provinceList->setValue('Ha Noi', $HaNoi);

        $data->setValue('Province List', $provinceList);

        $this->data = $data;
        $keys = $this->data->returnKeyList();
        ?>
        <?php

    foreach ($keys as $key) {
    if ($key == 'Province List') {
        ?>
         <link rel="stylesheet" href="<?php echo FILE_PATH('css').'AdvanceSearch.css'?>">

            <div id="provinceDiv">
                <div id = "province_box">
                Province: <select id="province" name="province" onchange="getDistrictList();">
                    <?php
                    $provinceList = $this->data->getValue($key);
                    $provinceListKeys = $provinceList->returnKeyList();
                    foreach ($provinceListKeys as $provinceListKey) {
                        ?>
                        <option value="<?php echo $provinceListKey ?>"><?php echo $provinceListKey ?></option>
                        <?php
                    }
                    ?>
                </select>
                </div>

                <div id="district">
                </div>
                <div id="districtHidden">
                    <?php
                    foreach ($provinceListKeys as $provinceListKey) {

                        ?>
                        <div id="<?php echo $provinceListKey; ?>" <?php echo 'style="display: none"';?>>

                            <?php

                            $province = $provinceList->getValue($provinceListKey);
                            $provinceKeys = $province->returnKeyList();

                            foreach ($provinceKeys as $provinceKey) {

                                if ($provinceKey == 'DistrictList') {
                                    $districtList = $province->getValue($provinceKey);
                                    $districtKeys = $districtList->returnKeyList();

                                    foreach ($districtKeys as $districtKey) {
                                        $districts = $districtList->getValue($districtKey);
                                        $i = 0;
                                            foreach ($districts as $district) {

                                                ?>
                                                <input type="checkbox" name=<?php echo $i;?> value="<?php echo $district ?>"> <?php echo $district ?> </br>
                                                <?php
                                                $i++;
                                            }
                                        }
                                    }
                                }

                            ?>
                        </div>
                        <?php
                    }

                    }
                    }

                    ?>

                </div>
            </div>
        <script>
            var e = document.getElementById("province");
            var province = e.options[e.selectedIndex].value;
            document.getElementById("district").innerHTML = document.getElementById(province).innerHTML;
            function getDistrictList() {
                province = e.options[e.selectedIndex].value;
                document.getElementById("district").innerHTML = document.getElementById(province).innerHTML;
                document.getElementById("district").style.display = "block";
                document.getElementById(province).style.display = "none";

            }
        </script>
        <?php
    }
}

?>


