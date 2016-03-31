<!--
 * Created by Chanh on 10/12/2015.
-->

    function callData(dataName) {
        var data = "<?php echo json_encode($data); ?>";
        if (data != null) {
            if (data[dataName] !== undefined) {
                return data[dataName];
            }
        }
        return '';
    }
