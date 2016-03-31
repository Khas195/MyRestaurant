<?php

/**
 *
 */
class Package
{
    private $mPack = array(); // array

    public function setValue($key, $value)
    {
        if ($key != NULL) {
            $this->mPack[$key] = $value;
        } else {
            array_push($this->mPack, $value);
        }

    }
    public function setArray($array){
        unset($this->mPack);
        $this->mPack = $array;
    }
    public function getValue($key)
    {
        if (array_key_exists($key, $this->mPack))
            /*Return the key if array_search found the $key in $mPack*/
            return $this->mPack[$key];
        else return null;
    }

    public function resetPackage()
    {
        while (!empty($this->mPack)) {
            array_pop($this->mPack);
        }
    }


    public function removeValue($input)
    {  // the input can either be the key of the value or the value itself
        $tempKey = array_search($input, $this->mPack);

        if (!is_null($tempKey))
            unset($this->mPack[$tempKey]);
        else unset($this->mPack[$input]);
    }

    public function returnKeyList()
    {
        return array_keys($this->mPack);
    }

    public function returnAllValues()
    {
        return array_values($this->mPack);
    }
}

?>
